<?php
/**
* @copyright	Copyright (C) 2013 Jsn Project company. All rights reserved.
* @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* @package		Easy Profile
* website		www.easy-profile.com
* Technical Support : Forum -	http://www.easy-profile.com/support.html
*/

defined('_JEXEC') or die;
define( 'DS', DIRECTORY_SEPARATOR );
// Add Custom Fields
//if(class_exists('FieldsHelper')) FieldsHelper::prepareForm('com_users.user', $this->form, $this->data);
// Set Title
$this->document->setTitle($this->document->title.' - '.JsnHelper::getFormatName($this->data));
// Set Pathway
JFactory::getApplication()->getPathway()->addItem(JsnHelper::getFormatName($this->data));
// Load Events Dispatcher
$dispatcher	= JEventDispatcher::getInstance();
$this->user=JsnHelper::getUser($this->data->id);
$avatar=$this->form->getField('avatar');

$db = JFactory::getDbo();
$query = 'SELECT #__categories.id, #__categories.title FROM #__categories, #__fields_values WHERE  #__fields_values.field_id = 29 AND #__fields_values.item_id = '. $this->user->id .' AND #__categories.id in (#__fields_values.value) ORDER BY #__categories.title ASC';
$db->setQuery($query);
$category = $db->loadRowList();

function getService($id, $user_id){
	$base = JFactory::getDbo();
	$query = 'SELECT cont.id,cont.title,cont.alias,cont.state FROM #__categories as cat,#__content as cont WHERE cat.parent_id = '. $id .' AND cont.catid in (cat.id) AND cont.created_by = '. $user_id;
	$base->setQuery($query);
	$service = $base->loadAssocList();
	if (!empty($service)){
		$html = '';
		foreach ($service as $item){
			$html .= '<div class="priceList__item d-flex justify-content-between">';
			$html .= '<div class="priceList__item-coll">'.$item['title'].'</div>';
			$html .= '<div class="icons-coll d-flex align-items-center">';
			if ($item['state'] == 0){
				$html .= '<button class="btn_disable m-1"><i class="fa fa-times" aria-hidden="true" title="На модерации"></i></button>';
			} else {
				$html .= '<button class="btn_enable m-1"><i class="fa fa-check" aria-hidden="true" title="Опубликовано"></i></button>';	
			}				
			$html .= '<button class="btn_enable m-1"><a href="/cabinet/dobavit-uslugu/?s_id=' . $item['id'] .'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></button></button>';
			$html .= '<button class="btn_enable m-1 del_serv" data-id="'.$item['id'].'" data-name="'.$item['title'].'"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
			$html .= '</div></div>';
		};
		echo $html;
	} else {
		echo '<div class="priceList__item"><div class="priceList__item-coll">В этом разделе услуги не созданы</div><div class="clearFloat"></div></div>';
	}
}


?>
<!-- Main Container -->
<script>
jQuery(document).ready(function() {
	let val = '';
	let files;
	jQuery('input[type=file]').on('change', function(){
		files = this.files;
	});
	jQuery('.send_img').on('click', function() {
		event.stopPropagation(); 
		event.preventDefault(); 
		if( typeof files == 'undefined' ) return;
		var data = new FormData();
		jQuery.each( files, function( key, value ){
			data.append( key, value );
		});
		goPreloader('start');
		data.append( 'user', <?php echo $this->data->id?> );
		jQuery.ajax({
			url: 	'/templates/ryba/html/com_jsn/profile/upload_img.php',
			data		: data,
			type		: "POST",
			dataType    : 'json',
			cache       : false,
			processData : false,
			contentType: false,
			success: function(respond,status,jqXHR){ 
				if(!respond.error){
					jQuery('.gallery').html(respond.html);
				}
				else {
					jQuery('.gallery').html('<p class="err_file">Один или несколько файлов не соответствуют условиям и были пропущены.</p>'+respond.html);
				};
				goPreloader('stop');		
			},
			error: function( jqXHR, status, errorThrown ){
				console.log( 'ОШИБКА AJAX запроса: ' + status, jqXHR );
				goPreloader('stop');	
			}
		});	
	});
	jQuery('.del-but').on('click','.goDel', function() {
		let ee = this;
		let param = this.dataset.url;
		goPreloader('start');	
		jQuery.ajax({ 
			url: '/function.php',
			data: {action:'imgDel', param:param, userID:'<?php echo $this->data->id?>'},
			type: 'post',
			dataType: 'json',
			success: function(output) {
				jQuery.fancybox.close();
				jQuery.fancybox.open('<div class="message"><h3>Файл удален!</h3></div>');
				jQuery('.gallery').html(output.html);
				param = '';
				goPreloader('stop');
			}
		});
	});
	jQuery('.gallery').on('click','.del_img', function() {
		let $url = jQuery(this).data('url');
		jQuery.fancybox.open({
			src  : '#del-images',
			type : 'inline',
			opts : {
				beforeShow: function( instance, slide ) {
					jQuery(".del-img img").attr('src', $url);
					jQuery(".goDel").attr('data-url', $url);
				}
			}
		});	
	});
	jQuery('.icons-coll').on('click','.del_serv', function() {
		if (confirm("Вы действительно желаете удалить услугу?")) {
			let $id = jQuery(this).data('id');
			let $name = jQuery(this).data('name')
			goPreloader('start');	
			jQuery.ajax({ 
				url: '/function.php',
				data: {action:'serviceDel', id:$id, name:$name},
				type: 'post',
				success: function(output) {
					jQuery.fancybox.open({
						src  : output,
						type : 'html',
						opts : {afterClose :function(instance,current) {location.reload();}} 
					});
					goPreloader('stop');
				}
			});
		}
	});
});
</script>


<div class="jsn-p">

	<?php 
		echo(implode(' ',$dispatcher->trigger('renderBeforeProfile',array($this->data,$this->config))));
	?>

	<div class="jsn-p-opt">
		<?php if (JFactory::getApplication()->input->get('back')=='1') : ?>
				<?php if(JFactory::getUser()->id == $this->data->id) $other_id=''; else $other_id='&user_id='.$this->data->id; ?> 
				<a class="btn btn-xs btn-default" href="#" onclick="window.history.back();return false;">
						<i class="jsn-icon jsn-icon-share"></i> <?php echo JText::_('COM_JSN_BACK'); ?></a>
		<?php endif; ?>
		<?php if (JFactory::getUser()->id == $this->data->id || JFactory::getUser()->authorise('core.edit', 'com_users')) : ?>
				<?php if(JFactory::getUser()->id == $this->data->id) $other_id=''; else $other_id='&user_id='.$this->data->id; ?> 
				<a class="btn btn-xs btn-default" href="<?php echo JRoute::_('index.php?option=com_users&view=profile&layout=edit'.$other_id,false);?>">
						<i class="jsn-icon jsn-icon-cog"></i> <?php echo JText::_('COM_USERS_EDIT_PROFILE'); ?></a>
		<?php endif; ?>
		<?php if ($this->config->get('profile_contact_btn',1) && JFactory::getUser()->id != $this->data->id) :
			$db=JFactory::getDbo();
			$query=$db->getQuery(true)->select($db->quoteName('id'))->from('#__contact_details as c')->where($db->quoteName('user_id').'='.$this->data->id)->where($db->quoteName('published').'=1');
			$db->setQuery($query);
			$contactMenu=JFactory::getApplication()->getMenu()->getItems('link','index.php?option=com_contact&view=featured', true);
			if(count($contactMenu)) $cItemid = $contactMenu->id;
			else $cItemid='';
			if($contact=$db->loadResult()) : ?>
					<a class="btn btn-xs btn-default" href="<?php echo JRoute::_('index.php?option=com_contact&view=contact&Itemid='.$cItemid.'&id='.$contact,false);?>">
						<i class="jsn-icon jsn-icon-paper-plane"></i> <?php echo JText::_('JGLOBAL_EMAIL'); ?></a>
			<?php endif; ?>
		<?php endif; ?>
		<a href="index.php?option=com_content&view=article&id=6" class="btn btn-xs btn-default" >
			<i class="jsn-icon jsn-icon-calendar"></i> Добавить услугу
		</a>
		<?php 
			echo(implode(' ',$dispatcher->trigger('renderProfileButtons',array($this->data,$this->config))));
		?>
	</div>

	<!-- Top Container -->
	<div class="jsn-p-top <?php echo ($avatar ? 'jsn-p-top-a' : ''); ?>">

		<!-- Avatar Container -->
		<?php
			if($avatar) :
		?> 
			<div class="jsn-p-avatar">
				<?php
					echo $this->user->getField('avatar');
				?>
			</div>
		<?php
			endif;
		?>

		<!-- Title Container -->
		<div class="jsn-p-title">
			<h3>
				<?php echo $this->user->getField('formatname'); ?>
			</h3>

			<?php if($this->config->get('status',1)) : ?>	
				<?php echo $this->user->getField('status'); ?>
			<?php endif; ?>
		</div>

		<!-- Before Fields Container -->
		<div class="jsn-p-before-fields">
				<?php 
					$registerdate=$this->form->getField('registerdate');
					$lastvisitdate=$this->form->getField('lastvisitdate');
					if( $registerdate || $lastvisitdate ) : ?>
						<div class="jsn-p-dates">
							<?php if($registerdate) : ?>
							<div class="jsn-p-date-reg">
								<b><?php echo JText::_('COM_JSN_MEMBER_SINCE'); ?></b> <?php echo $this->user->getField('registerdate'); ?>
							</div>
							<?php endif; ?>
							<?php if($lastvisitdate) : ?>
							<div class="jsn-p-date-last">
								<b><?php echo JText::_('COM_JSN_LASTVISITDATE'); ?></b> <?php echo $this->user->getField('lastvisitdate'); ?>
							</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				<?php 
				echo(implode(' ',$dispatcher->trigger('renderBeforeFields',array($this->data,$this->config))));
				?>
		</div>		
	</div>

	<!-- Fields Container -->
	<div class="jsn-p-fields">
	<?php
		$tabs=$dispatcher->trigger('renderTabs',array($this->data,$this->config)); 
		$fields_output=implode(' ',$dispatcher->trigger('renderTabBeforeFields',array($this->data,$this->config)));
		$fields_output.=$this->loadTemplate('fields');
		$fields_output.=$this->loadTemplate('params');
		$fields_output.=implode(' ',$dispatcher->trigger('renderTabAfterFields',array($this->data,$this->config)));
		if($this->config->get('profile_fg_tabs',1)) echo($fields_output);
		else echo('<fieldset><legend>'.JText::_('COM_JSN_PROFILE_INFO').'</legend><div>'.$fields_output.'</div></fieldset>');
	
		$titles=array();
		$contents=array();
	
		foreach($tabs as $tab)
		{
			if (is_object($tab[0]))
		    {
		        foreach ($tab as $tabobject)
		        {
		            $contents[]='<fieldset><legend>'.$tabobject->title.'</legend>'.$tabobject->content.'</fieldset>';
		        }
		    }
		    else
				$contents[]='<fieldset><legend>'.$tab[0].'</legend>'.$tab[1].'</fieldset>';
		}
		echo(implode(' ',$contents));
	
	?>
	
	
		<fieldset id="fields-gal" class="master__services">
			<legend>Мои услуги</legend>
			<div class="accordionWrapper">
				<?php foreach ($category as $n => $item) { ?>
					<div class="accordionItem<?php echo $n == 0 ? ' open_' : ' close_'; ?>">
						<h2 class="accordionItemHeading" data-id=<?php echo $item[0]?>><?php echo $item[1];?></h2>
						<div class="accordionItemContent">
							<div class="serviceList">
								<?php getService($item[0], $this->user->id); ?>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
        </fieldset>
		<fieldset id="fields-gal">
			<legend>Галерея</legend>
			<div class="img_info">
				<p>Изображения должны соответствовать:</p>
				<ul>
					<li>Размер файла не должен превышать 500 кб;</li>
					<li>Допустимый тип файла jpg, png;</li>
					<li>Ориентация - ландшафт;</li>
				</ul>
			</div>
			<form action="" class="dropzone">
				<div class="field__wrapper fallback">
				   <input name="file" type="file" id="field__file-2" class="field field__file file" multiple 
				   accept="image/jpeg,image/png,image/jpg">
				   <label class="field__file-wrapper" for="field__file-2">
					 <div class="field__file-fake">Выбрать файл(ы)</div>
					 <div class="field__file-button send_img">Загрузить</div>
				   </label> 
				</div>
			</form>	
			
			<div class="d-flex gallery">
				<?php 
					$dir = $_SERVER[DOCUMENT_ROOT] . DS .'images'. DS . 'gallery' . DS  . $this->data->id;
					$files = array();
					foreach(glob($dir . '/*.{jpg,jpeg,png,JPG,JPEG,PNG}', GLOB_BRACE) as $file) { ?>
					<div class="gal_img">
						<a class="del_img" data-url="/images/gallery/<?php echo $this->data->id . '/' . basename($file) ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
						<a href="/images/gallery/<?php echo $this->data->id . '/' . basename($file) ?>" data-fancybox="gal">
							<img src="/images/gallery/<?php echo $this->data->id . '/' . basename($file) ?>" alt="">
						</a>	
					</div>	
				<?php } ?>
			</div>
		</fieldset>
	</div>
	<div class="jsn-p-bottom">
		<div class="jsn-p-after-fields">
			<?php 
				echo(implode(' ',$dispatcher->trigger('renderAfterFields',array($this->data,$this->config))));
			?>
		</div>
	</div>
	<div style="display:none;" id="del-images">
		<div>
			<h3>Вы действительно желаете удалить</h3>
			<div class="del-img">
				<img src="" alt="">
			</div>
			<div class="del-but d-flex jsn-p">
				<input type="button" class="btn btn-xs btn-default goDel" value="Да" data-url="">
				<input type="button" class="btn btn-xs btn-default" value="Нет" onclick="jQuery.fancybox.close();">
			</div>
		</div>	
	</div>
</div>







<?php 
echo(implode(' ',$dispatcher->trigger('renderAfterProfile',array($this->data,$this->config))));
?>

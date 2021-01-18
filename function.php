<?php

define( '_JEXEC', 1 );
define('JPATH_BASE', dirname(__FILE__) );
define( 'DS', DIRECTORY_SEPARATOR );
require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );

$db = JFactory::getDbo();

if(isset($_POST['action']) && !empty($_POST['action'])) {
	$action = $_POST['action'];
	$param = $_POST['param'];
	$userId = $_POST['userID'];
	switch($action) {
        case 'getCategory' :  echo getCategory ($param,$db);break;
        case 'getMetod' :  echo getMetod ($param,$db);break;
		case 'imgDel' :  echo imgDel ($param, $userId);break;
		case 'serviceDel' : echo serviceDel($_POST['id'],$_POST['name'], $db);break;
		
		default: break;
       
    }
}

function getCategory ($id, $base) {
	$query = $base->getQuery(true);
	$query->select($base->quoteName(array('id', 'title')));
	$query->from($base->quoteName('#__categories'));
	$query->where($base->quoteName('parent_id')  . " = " . $base->quote($id), 'AND');
	$query->where($base->quoteName('published')  . " = " . $base->quote('1'));
	$query->order('title ASC');
	$base->setQuery($query);
	$info = $base->loadRowList();
	if (empty($info)) {
		$sel = '<select class="spec_2" disabled name="category"><option value="0">Выбрать...</option></select>';
	} else {
		$sel = '<select class="spec_2" name="category" data-placeholder="Выбрать..."><option value="0"></option>';
		foreach ($info as $key => $item) { 
			$sel .='<option value="' . $item[0] . '">' . $item[1] . '</option>';	
		};
		$sel .='</select>';
	}
	return ($sel);	
};
function getMetod ($id, $base ) {	
	$query = $base->getQuery(true);
	$query->select($base->quoteName(array('#__fields.id','#__fields.fieldparams')));
	$query->from($base->quoteName(array('#__fields', 'joomla_fields_categories')));
	$query->where($base->quoteName('#__fields_categories.category_id') . " = " . $base->quote($id), 'AND');
	$query->where($base->quoteName('#__fields.id') . " = " . $base->quoteName('#__fields_categories.field_id'), 'AND');
	$query->where($base->quoteName('#__fields.state') . " = " . $base->quote('1'));
	$base->setQuery($query);
	$info = $base->loadRow();
	$array = json_decode($info[1], true);
	if (empty($array['options'])) {
		$sel = '<select class="spec_3" disabled name="metod"><option value="0">Выбрать...</option></select>';
	} else {
		$sel = '<select class="spec_3" name="metod[]" data-placeholder="Выбрать..." multiple><option value="0"></option>';
		foreach ($array['options'] as $key => $item) { 
			$sel .='<option value="' . $info[0].'|'. $item[name] . '">' . $item[name] . '</option>';	
		};
		$sel .='</select>';
	};
	return ($sel);	
};
function imgDel ($dir, $id ) {
	$filepath = JPATH_BASE . $dir;
	unlink($filepath);
	$files = array();
	foreach(glob(JPATH_BASE . '/images/gallery/' . $id . '/*.{jpg,png,jpeg,JPG,PNG,JPEG}', GLOB_BRACE) as $file) {
		$html .='<div class="gal_img">';
		$html .='<a class="del_img" href="javascript:;" data-url="/images/gallery/' . $id . '/' . basename($file) . '"><i class="fa fa-trash" aria-hidden="true"></i></a>';
		$html .='<a href="/images/gallery/' . $id . '/' . basename($file) . '" data-fancybox="gal">';
		$html .='<img src="/images/gallery/' . $id . '/' . basename($file) . '" alt="">';
		$html .='</a></div>';	
	}; 
	$data = array('html' => $html);
	echo (json_encode($data));
};
function getTypeMaster() {	
	$db = JFactory::getDbo();
	$query = $db->getQuery(true);
	$query->select($db->quoteName(array('id','fieldparams')));
	$query->from($db->quoteName('#__fields'));
	$query->where($db->quoteName('#__fields.id') . " = " . $db->quote('57'));
	$db->setQuery($query);
	$info = $db->loadRow();
	$array = json_decode($info[1], true);
	if (empty($array['options'])) {
		$sel = '<select class="spec_4" name="type"><option value="0">Выбрать...</option></select>';
	} else {
		$sel = '<select class="spec_4" name="type" data-placeholder="Выбрать..."><option value="0"></option>';
		foreach ($array['options'] as $key => $item) { 
			$sel .='<option value="' . $info[0].'|'. $item[name] . '">' . $item[name] . '</option>';	
		};
		$sel .='</select>';
	};
	return ($sel);




	
};
function serviceDel($id,$name,$base) {
	$query = 'DELETE c.*, f.* FROM #__content as c, #__fields_values as f WHERE c.id ='. $id .' and f.item_id = c.id';
	$base->setQuery($query);
	$base->query();
	return ('<div class="message"><h2>Удаление услуги</h2><p>Услуга <b>'. $name .'</b> была удалена</p></div>');	
	
	
}








?>
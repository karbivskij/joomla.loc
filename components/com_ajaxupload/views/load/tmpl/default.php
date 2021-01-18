<?php
/** @var $this AjaxuploadViewLoad */
defined( '_JEXEC' ) or die; // No direct access

$baseUrl = JUri::base();
$imagesPath = JUri::root() . 'images/gallery/';
//Подключение jQuery
JHtml::_( 'jquery.framework', false, null, false );
//Подколючение скриптов
JFactory::getDocument()
	->addScript( $baseUrl . 'components/com_ajaxupload/assets/scripts/jquery.ui.widget.js' )
	->addScript( $baseUrl . 'components/com_ajaxupload/assets/scripts/jquery.iframe-transport.js' )
	->addScript( $baseUrl . 'components/com_ajaxupload/assets/scripts/jquery.fileupload.js' );
?>

<script>
	jQuery(document).ready(function ($) {
		$('#fileupload').fileupload({//инициализация плагина загрузки файлов
			dataType: 'json',//тип данных
			url: '<?php echo $baseUrl; ?>index.php',//скрипт обратобчик
			formData: {//данные формы (компонен, задача, действие)
				option: 'com_ajaxupload',
				task: 'getAjax',
				action: 'upload'
			},
			add: function (e, data) {//Метод который вызывается перед загрузкой файлов
				$('#progress .bar').css('width', '0px');
				data.submit();//Субмит формы
			},
			done: function (e, data) {//метод который вызывается при завершение загрузки изображений
				if (data.result.loaded) {//если изображение успешно загружено то добавляем в таблицу загруженную картинку
					$('.table-files-upload tbody').append('<tr>' +
					'<td style="text-align: center;"><a href="' + data.result.file.full + '"><img  src="' + data.result.file.path + '" style="height: 50px;"  /></a></td>' +
					'<td><input type="button" class="btn btn-danger btn-delete-gallery-image" data-id="' + data.result.file.id + '" value="Удалить изображение"></td>' +
					'</tr>');
				}
			},
			progressall: function (e, data) {//метод для визуализации общего прогресса загрузки
				$('.progress-info').show();//показываем прогресс бар
				var progress = parseInt(data.loaded / data.total * 100, 10);//вычисляем процентно длину прогрессбара
				$('#progress .bar').css('width', progress + '%');//отображаем длину прогресс бара
			}
		});
		//Слушатель на кнопку для удаления уже загруженной картинки:
		$(document).on('click', '.btn-delete-gallery-image', function () {
			if (confirm('Удалить изображение?')) {
				var button = $(this);
				button.hide();
				$.getJSON('index.php?option=com_ajaxupload&task=getAjax&action=deleteImage&id=' + button.data('id'), function (response) {
					if (!response.result) {
						alert(response.message);
					} else {
						button.closest('tr').remove();
					}
				});
			}
		});
	});
</script>

<div class="item-page">
	<h1>Загрузка файлов</h1>
	<!-- поле для загрузки файлов -->
	<div class="upload-block-hidden btn btn-primary" style="position:relative;">+ Загрузить изображения в галерею
		<input id="fileupload" type="file" name="files[]" multiple style="position: absolute;opacity: 0; width: 100%; height: 100%; top: 0; left: 0;">
	</div>
	<br /><br />
	<!-- прогресс бар -->
	<div class="progress progress-info progress progress-striped active" id="progress">
		<div class="bar" style="width: 0%"></div>
	</div>
	<!-- Таблица в которой будут отображены загруженные изображения -->
	<table class="table table-files-upload table-bordered table-striped table-hover table-condensed" style="width: 500px;">
		<thead>
		<tr>
			<th style="width: 50px">Изображение</th>
			<th>Действие</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ( $this->images as $image ): ?>
			<tr>
				<td style="text-align: center;">
					<a href="<?php echo $imagesPath . $image->image; ?>" class="zoom-image">
						<img src="<?php echo $imagesPath . $image->image; ?>" alt="" style="height: 50px;" class="block" />
					</a>
				</td>
				<td>
					<input type="button" class="btn btn-danger btn-delete-gallery-image" data-id="<?php echo $image->id; ?>" value="Удалить изображение">
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>
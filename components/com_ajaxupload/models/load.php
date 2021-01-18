<?php

// No direct access
defined( '_JEXEC' ) or die;

/**
 * @author Alexand Denezh
 */
class AjaxuploadModelLoad extends JModelLegacy
{

	/**
	 * Вывод JSON данных
	 * @param $message
	 * @param bool $result
	 * @param array $custom
	 */
	private function printJson( $message, $result = false, $custom = array() )
	{
		$jsonData = array( 'result' => $result, 'message' => $message );
		foreach ( $custom as $key => $value ) {
			$jsonData[$key] = $value;
		}
		echo json_encode( $jsonData );
		exit;
	}

	/**
	 * Загрузка изображений
	 * @throws Exception
	 */
	public function upload()
	{
		$baseUrl = JUri::root();
		$input = JFactory::getApplication()->input;
		$files = $input->files->get( 'files', array(), 'array' ); //Список файлов для загрузки
		if ( isset( $files[0]['error'] ) && (int)$files[0]['error'] == 0 ) { //проверка или файл загружен
			try {
				jimport( 'joomla.filesystem.folder' );//библиотека для работы с папками
				$galleryPath = JPATH_SITE . '/images/gallery/'; //путь по которому будем загужать изображения
				//проверяем или папка для изображений существует, елси нет то создаем
				if ( !JFolder::exists( $galleryPath ) ) {
					JFolder::create( $galleryPath );
				}
				//Генерируем имя картинки
				$name = md5( $files[0]['tmp_name'] . mt_rand( 0, 9999 ) . mktime() ) . '.jpg';
				$image = new JImage( $files[0]['tmp_name'] );
				$image->resize( 800, 600, false );//уменьшаем картинку до 800*600 пикселей
				$image->toFile( $galleryPath . $name );//сохраняем картинку на диске
				$storedId = $this->pushImage( $name ); //Сохраняем запись о картинке в БД
				//сообщение о том что картинка загружена
				echo json_encode(
					array(
						'loaded' => 'true',
						'file' => array(
							'path' => $baseUrl . '/images/gallery/' . $name, //путь к загруженной картинки
							'id' => $storedId // id загруженной картинки в БД
						)
					)
				);
			} catch ( Exception $ex ) {
				//Если не удалось сохранить картинку то выводим сообшени об ошибке загрузки
				echo json_encode( array( 'loaded' => 'false' ) );
			}

		}
		exit;
	}


	/**
	 * Сохранение изображения в базе
	 * @param $image
	 * @return mixed
	 * @throws Exception
	 */
	private function pushImage( $image )
	{
		$table = $this->getTable( 'images' ); //таблица с картинками
		$table->bind(
			array( 'image' => $image )
		);
		$table->store(); //вставляем изображение
		return $table->id;//возврат id изображения
	}

	/**
	 * Удаление изображения из базы
	 * @throws Exception
	 */
	public function deleteImage()
	{
		$input = JFactory::getApplication()->input;
		$id = $input->getInt( 'id', 0 );
		$table = $this->getTable( 'images' ); //таблица с картинками
		if ( $table->load( $id ) ) { //Загружаем запись
			jimport( 'joomla.filesystem.file' );
			//Удаляем картинку из папки
			JFile::delete( JPATH_SITE . '/images/gallery/' . $table->image );
			if ( $table->delete( $id ) ) {//Если запись удалена то выводим сообщение о удалении
				$this->printJson( 'Изображение удалено!', true );
			}
		}
		$this->printJson( 'Ошибка удаления!' );
	}

	/**
	 * Список загруженных изображений
	 * @return mixed
	 */
	public function getImages()
	{
		$query = $this->getDbo()->getQuery( true )->select( '*' )
			->from( '#__images' );
		return $this->getDbo()->setQuery( $query )->loadObjectList();
	}
}
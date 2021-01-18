<?php
defined( '_JEXEC' ) or die; // No direct access

/**
 * Default Controller
 * @author Alexand Denezh
 */
class AjaxUploadController extends JControllerLegacy
{
	/**
	 * Typical view method for MVC based architecture
	 *
	 * This function is provide as a default implementation, in most cases
	 * you will need to override it in your own controllers.
	 *
	 * @param   boolean $cachable If true, the view output will be cached
	 * @param   array $urlparams An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return  JControllerLegacy  A JControllerLegacy object to support chaining.
	 *
	 * @since   12.20
	 */
	function display( $cachable = false, $urlparams = array() )
	{
		$this->default_view = 'load';
		parent::display( $cachable, $urlparams );
	}

	/**
	 * Вызов аякс метода из модели
	 * @throws Exception
	 */
	public function getAjax()
	{
		$input = JFactory::getApplication()->input;
		$model = $this->getModel( 'load' );
		$action = $input->getCmd( 'action' );
		$reflection = new ReflectionClass( $model );
		$methods = $reflection->getMethods( ReflectionMethod::IS_PUBLIC );
		$methodList = array();
		foreach ( $methods as $method ) {
			$methodList[] = $method->name;
		}
		if ( in_array( $action, $methodList ) ) {
			$model->$action();
		}
		exit;
	}
}
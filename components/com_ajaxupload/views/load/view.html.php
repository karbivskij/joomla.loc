<?php
defined( '_JEXEC' ) or die; // No direct access

/**
 * View for  current element
 * @author Alexand Denezh
 */
class AjaxuploadViewLoad extends JViewLegacy
{
	/**
	 * @var $images array
	 */
	public $images;

	/**
	 * Execute and display a template script.
	 *
	 * @param   string $tpl The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise a Error object.
	 *
	 * @see     JViewLegacy::loadTemplate()
	 * @since   12.2
	 */
	public function display( $tpl = null )
	{
		$this->images = $this->get( 'images' );

		$this->loadHelper( 'ajaxupload' );
		parent::display( $tpl );
	}

}
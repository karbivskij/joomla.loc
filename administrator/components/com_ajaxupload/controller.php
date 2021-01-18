<?php
defined( '_JEXEC' ) or die; // No direct access

/**
 * Default Controller
 * @author Alexand Denezh
 */
class AjaxuploadController extends JControllerLegacy
{
	/**
	 * Methot to load and display current view
	 * @param Boolean $cachable
	 */
	function display( $cachable = false, $urlparams = array())
	{
		$this->default_view = '';
		parent::display( $cachable, $urlparams);
	}

}
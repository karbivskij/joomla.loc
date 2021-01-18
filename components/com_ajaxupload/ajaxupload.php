<?php
defined( '_JEXEC' ) or die; // No direct access
/**
 * Component ajaxupload
 * @author Alexand Denezh
 */
$controller = JControllerLegacy::getInstance( 'ajaxupload' );
$controller->execute( JFactory::getApplication()->input->get( 'task' ) );
$controller->redirect();
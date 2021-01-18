<?php

// No direct access
defined( '_JEXEC' ) or die;

/**
 * Object Class Table
 * @author Alexand Denezh
 */
class TableImages extends JTable
{

	/**
	 * Class constructor
	 * @param Object $db (database link object)
	 */
	function __construct( &$db )
	{
		parent::__construct( '#__images', 'id', $db );
	}

	public function bind( $array, $ignore = '' )
	{
		if ( empty( $array['created'] ) ) {
			$array['created'] = JFactory::getDate()->toSql();
		}
		return parent::bind( $array, $ignore );
	}
}
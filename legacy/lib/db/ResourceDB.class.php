<?php
/**
* Handles all database functions for resources
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 11-08-05
* @package DBEngine
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/

$basedir = dirname(__FILE__) . '/../..';

include_once($basedir . '/lib/DBEngine.class.php');

/**
* Provide all access to database to manage reservations
*/
class ResourceDB extends DBEngine {
	
	/**
	* Gets a single property for a resource
	* @param string $property_name name of the property that we need to return
	* @param string $machid id of the resource to get
	* @return string value of the property that we are looking for
	*/
	function get_property($property_name, $machid) {
		$query = 'SELECT ' . $property_name . ' FROM ' . $this->get_table('resources') . ' WHERE machid=?';
		return $this->db->getOne($query, array($machid));
	}
	
	/**
	 * Returns all of the fields of from the resource table for a resource with this machid
	 * @param string $machid the id of the machine to load
	 * @return an array of all fields in the resource table
	 */
	function get_all_properties($machid) {
		$properties = array();
		
		$query = 'SELECT * FROM ' . $this->get_table('resources') . ' WHERE machid=?';
		$result = $this->db->query($query, array($machid));
		$this->check_for_error($result);
		
		while ($rs = $result->fetchRow()) {
			foreach ($rs as $key => $value) {
				$properties[$key] = $value;
			}
		}
		
		$result->free();
		
		return $properties;
	}
}
?>
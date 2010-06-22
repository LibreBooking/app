<?php
/**
* Resource class
* Provides access to resource data
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 11-08-05
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/

$basedir = dirname(__FILE__) . '/..';

include_once($basedir . '/lib/db/ResourceDB.class.php');

class Resource {
	
	var $machid = null;	
	var $db;
	var $properties = array();
	
	/**
	* Connects to the database
	* @param string optional machid of this resource
	*/
	function Resource($machid = null) {
		$this->db = new ResourceDB();
		$this->machid = $machid;
		
		if ($machid != null) {
			$this->load_properties();
		}
	}
	
	/**
	* Gets a single property for a resource
	* @param string $property_name name of the property that we need to return
	* @param string $machid id of the resource to get
	* @return string value of the property that we are looking for
	*/
	function get_property($property_name, $machid = null) {
		if ($machid == null) {
			$machid = $this->machid;
		}
		
		if (!isset($this->properties[$property_name])) {
			$this->properties[$property_name] = $this->db->get_property($property_name, $machid);
		}
		
		return $this->properties[$property_name];	
	}
	
	/**
	 * Loads all of the fields of from the resource table for a resource with this machid into the $properties field
	 * @param string $machid the id of the machine to load
	 */
	function load_properties($machid = null) {
		if ($machid == null) {
			$machid = $this->machid;
		}
		
		$this->properties = $this->db->get_all_properties($machid);
	}
}
?>
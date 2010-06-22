<?php
/**
* This file contains the database class to work with the AdditionalResource class
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 11-11-04
* @package DBEngine
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/
/**
* Base directory of application
*/
@define('BASE_DIR', dirname(__FILE__) . '/../..');
/**
* DBEngine class
*/
include_once(BASE_DIR . '/lib/DBEngine.class.php');

/**
* Provide functionality for getting and setting AdditionalResource data
*/
class AdditionalResourceDB extends DBEngine {

	/**
	* Return all data associated with this resourceid
	* @param string $id resourceid of user to find
	* @return array of AdditionalResource data
	*/
	function get_data($id) {
		$result = $this->db->getRow('SELECT * FROM ' . $this->get_table('additional_resources') . ' WHERE resourceid=?', array($id));
		$this->check_for_error($result);
		
		if (count($result) <= 0) {
			$this->err_msg = translate('That record could not be found.');
			return false;
		}
		
		return $this->cleanRow($result);
	}
	
	/**
	* Inserts a new AdditionalResource into the database
	* @param AdditionalResource the object to insert
	*/
	function create($resource) {
		$values = array (
			$resource->get_id(),
			$resource->get_name(),
			$resource->get_status(),
			$resource->get_number_available()	
		);
		
		$query = 'INSERT INTO ' . $this->get_table('additional_resources') . ' VALUES(?, ?, ?, ?)';
		$q = $this->db->prepare($query);
		$result = $this->db->execute($q, $values);
		$this->check_for_error($result);
	}
		
	/**
	* Updates an existing AdditionalResource in the database
	* @param AdditionalResource the object to update
	*/
	function update($resource) {
		$values = array (
			$resource->get_name(),
			$resource->get_status(),
			$resource->get_number_available(),
			$resource->get_id()
		);
		
		$query = 'UPDATE ' . $this->get_table('anonymous_users') . ' SET name=?, status=?, number_available=? WHERE resourceid=?';
		$q = $this->db->prepare($query);
		$result = $this->db->execute($q, $values);
		$this->check_for_error($result);
	}
}
?>
<?php
/**
* AdditionalResource class
* A AdditionalResource is a resource which cannot be reserved on its own, it must be added to a reservation
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 03-27-06
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/
/**
* Base directory of application
*/
$basedir = dirname(__FILE__) . '/..';
include_once($basedir . '/lib/db/AdditionalResourceDB.class.php');

class AdditionalResource {
	var $id = null;
	var $name = null;
	var $status;
  	var $number_available;

  	var $is_valid = false;
	var $err_msg = null;
	var $db;

	var $is_created = true;		// If this user has already been created in the DB or not

  	/**
	* Creates a new AdditionalResource object and loads data, if found
	* @param string $userid users id
	*/
	function AdditionalResource($resourceid = null) {
		$this->id = $resourceid;
		$this->db = new AdditionalResourceDB();

		if (!empty($this->id)) {		// Load values
			$this->load_by_id();
		}
	}

	/**
	* Returns all data associated with this resource
	*  using its ID as the identifier
	* @param none
	* @return array of AdditionalResource data
	*/
	function load_by_id() {
		$resource = $this->db->get_data($this->id);

		if (!$resource) {
			$this->err_msg = $this->db->get_err();
			return;
		}
		else
			$this->is_valid = true;

		$this->name = $resource['name'];
		$this->status = $resource['status'];
  		$this->number_available = $resource['number_available'];
	}

	/**
	* Saves the AdditionalResource to the database if all required fields exist
	* @param none
	*/
	function save() {
		if (empty($this->name)) {
			$err_msg = 'name is required';
			return false;
		}

		// All fields are ok, so insert
		if ($this->is_created) {
			$this->db->update($this);
		}
		else {
			$this->db->create($this);
			$this->is_created = true;		// We don't want to execute an insert next time save() is called
		}
	}

	/**
	* Creates a new AdditionalResource object for insertion into the DB
	* @param none
	* @returns new AdditionalResource object
	*/
	function &getNewResource() {
		$resource = new AdditionalResource();
		$resource->id = $resource->db->get_new_id();
		$resource->is_created = false;
		return $resource;
	}

	/**
	* Returns whether this resource is valid or not
	* @param none
	* @return boolean if resource is valid or not
	*/
	function is_valid() {
		return $this->is_valid;
	}

	/**
	* Returns the error message generated
	* @param none
	* @return error message as string
	*/
	function get_error() {
		return $this->err_msg;
	}

	/// GETTER FUNCTIONS ///
	function get_id() {
		return $this->id;
	}

	function get_name() {
		return $this->name;
	}

	function get_status() {
		return $this->email;
	}

  	function get_number_available() {
		return $this->number_available;
	}
}
?>
<?php
/**
* This file contains the AnonymousUser class for viewing
*  and manipulating user data
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 05-21-05
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/

$basedir = dirname(__FILE__) . '/..';

include_once($basedir . '/lib/db/AnonymousUserDB.class.php');

class AnonymousUser {
	var $userid;		// Properties
	var $email;			//
	var $fname;			//
	var $lname;			//

	var $is_valid = false;
	var $err_msg = null;
	var $db;
	
	var $is_created = true;		// If this user has already been created in the DB or not

	/**
	* Sets the userid variable
	* @param string $userid users id
	*/
	function AnonymousUser($userid = null) {		
		$this->userid = $userid;
		$this->db = new AnonymousUserDB();
		
		if (!empty($this->userid)) {		// Load values
			$this->load_by_id();
		}
	}
	
	/**
	* Returns all data associated with this user's profile
	*  using their ID as the identifier
	* @param none
	* @return array of user data
	*/
	function load_by_id() {
		$u = $this->db->get_user_data($this->userid);
		
		if (!$u) {
			$this->err_msg = $this->db->get_err();
			return;
		}
		else
			$this->is_valid = true;
			
		$this->fname	= $u['fname'];
		$this->lname	= $u['lname'];
		$this->email	= $u['email'];
	}
	
	/**
	* Saves the AnonymousUser to the database if all required fields exist
	* @param none
	*/
	function save() {
		if (empty($this->userid)) {
			$err_msg = 'userid is required';
			return false;
		}
		if (empty($this->fname)) {
			$err_msg = 'fname is required';
			return false;
		}
		if (empty($this->lname)) {
			$err_msg = 'lname is required';
			return false;
		}
		if (empty($this->email)) {
			$err_msg = 'email is required';
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
	* Creates a new AnonymousUser object for insertion into the DB
	* @param none
	* @returns new AnonymousUser object
	*/
	function &getNewUser() {
		$user = new AnonymousUser();
		$user->userid = $user->db->get_new_id();
		$user->is_created = false;
		return $user;
	}
	
	/**
	* Gets an anonymous userid by email
	* @param string $email the email address of the User or AnonymousUser
	* @return the memberid, if it exists
	*/
	function get_id_by_email($email) {
		$db = new AnonymousUserDB();
		return $db->get_id_by_email($email);
	}
		
	/**
	* Returns whether this user is valid or not
	* @param none
	* @return boolean if user is valid or not
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
	
	/**
	* Return this user's id
	* @param none
	* @return user id
	*/
	function get_id() {
		return $this->userid;
	}
	
	/**
	* Return the users first name
	* @param none
	* @return user first name
	*/
	function get_fname() {
		return $this->fname;
	}
	
	/**
	* Return the users last name
	* @param none
	* @return user last name
	*/
	function get_lname() {
		return $this->lname;
	}
	
	/**
	* Return the user's full name
	* @param none
	* @return the users full name as one string
	*/
	function get_name() {
		return $this->fname . ' ' . $this->lname;
	}
	
	/**
	* Returns the email address
	* @param none
	* @return email address of this user
	*/
	function get_email() {
		return $this->email;
	}
}
?>
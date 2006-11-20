<?php
/**
* This file contains the database class to work with the AnonymousUserDB class
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 05-21-04
* @package DBEngine
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/

$basedir = dirname(__FILE__) . '/../..';

include_once($basedir . '/lib/DBEngine.class.php');

/**
* Provide functionality for getting and setting user data
*/
class AnonymousUserDB extends DBEngine {

	/**
	* Return all data associated with this userid
	* @param string $userid id of user to find
	* @return array of user data
	*/
	function get_user_data($userid) {
		$result = $this->db->getRow('SELECT * FROM ' . $this->get_table('anonymous_users') . ' WHERE memberid=?', array($userid));
		$this->check_for_error($result);
		
		if (count($result) <= 0) {
			$this->err_msg = translate('That record could not be found.');
			return false;
		}
		
		return $this->cleanRow($result);
	}
	
	/**
	* Gets an anonymous user by email
	* @param string $email the email address of the User or AnonymousUser
	* @return the memberid, if it exists
	*/
	function get_id_by_email($email) {
		$result = $this->db->getRow('SELECT memberid FROM ' . $this->get_table('anonymous_users') . ' WHERE email=?', array($email));
		$this->check_for_error($result);
		
		if (count($result) <= 0) {
			$this->err_msg = translate('That record could not be found.');
			return false;
		}
		else {
			return $result['memberid'];
		}
	}
	
	/**
	* Inserts a new AnonymousUser into the database
	* @param AnonymousUser the object to insert
	*/
	function create(&$user) {
		$values = array (
			$user->get_id(),
			$user->get_email(),
			$user->get_fname(),
			$user->get_lname()			
		);
		
		$query = 'INSERT INTO ' . $this->get_table('anonymous_users') . ' VALUES(?, ?, ?, ?)';
		$q = $this->db->prepare($query);
		$result = $this->db->execute($q, $values);
		$this->check_for_error($result);
	}
		
	/**
	* Updates an existing AnonymousUser in the database
	* @param AnonymousUser the object to update
	*/
	function update(&$user) {
			$values = array (
			$user->get_email(),
			$user->get_fname(),
			$user->get_lname(),
			$user->get_id()			
		);
		
		$query = 'UPDATE ' . $this->get_table('anonymous_users') . ' SET email=?, fname=?, lname=? WHERE memberid=?';
		$q = $this->db->prepare($query);
		$result = $this->db->execute($q, $values);
		$this->check_for_error($result);
	}
}
?>
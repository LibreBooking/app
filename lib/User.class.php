<?php
/**
* This file contains the User class for viewing
*  and manipulating user data
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 05-15-06
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/

$basedir = dirname(__FILE__) . '/..';

include_once($basedir . '/lib/db/UserDB.class.php');

class User {
	var $userid;		// Properties
	var $email;			//
	var $fname;			//
	var $lname;			//
	var $phone;			//
  	var $inst;			//
  	var $position;		//
	var $perms = null;	//
	var $emails;		//
	var $logon_name;	//
	var $is_admin;		//
	var $groups = null;	//
	var $lang;
	var $timezone;

	var $is_valid = false;
	var $err_msg = null;
	var $db;

	/**
	* Sets the userid variable
	* @param string $userid users id
	*/
	function User($userid = null) {		
		$this->userid = $userid;
		$this->db = new UserDB();
		
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
		$data = $this->db->get_user_data($this->userid);
		
		if (!$data) {
			$this->err_msg = $this->db->get_err();
			return;
		}
		else {
			$this->is_valid = true;
		}
			
		$this->fname	= $data['fname'];
		$this->lname	= $data['lname'];
		$this->email	= $data['email'];
		$this->phone	= $data['phone'];
		$this->inst		= $data['institution'];
		$this->position	= $data['position'];
		$this->logon_name = (isset($data['logon_name']) ? $data['logon_name'] : null);
		$this->is_admin = (isset($data['is_admin']) && $data['is_admin'] == 1);
		$this->lang 	= $data['lang'];
		$this->timezone	= $data['timezone'];
		
		$this->perms = $this->_get_perms();
		$this->emails = $this->_get_emails();
		$this->groups = $this->_get_groups();
		unset($data);
	}
	
	/**
	* Gets a userid by email
	* @param string $email the email address of the User or AnonymousUser
	* @return the memberid, if it exists
	*/
	function get_id_by_email($email) {
		if ($this->db == null) { 
			$this->db = new UserDB();
		}
		return $this->db->get_id_by_email($email);
	}
	
	/**
	* Returns all permissions for this user
	* @param none
	* @return array of user permissions with the resource id as the key and 1 as the value
	*/
	function _get_perms() {
		global $conf;
		return ($conf['app']['use_perms'] ? $this->db->get_user_perms($this->userid) : array());
	}
	
	/**
	* Checks if the user has permission to use a resource
	* @param string $machid id of resource to check
	* @return boolean whether user has permission or not
	*/
	function has_perm($machid) {
		global $conf;
		return ($conf['app']['use_perms'] ? isset($this->perms[$machid]) : true);
	}
	
	/**
	* Gets the email contact setup for this user
	* @param none
	* @return array of email settings
	*/
	function _get_emails() {	
		if (!$emails = $this->db->get_emails($this->userid))
			$this->err_msg = $this->db->get_err();
		return $emails;
	}
	
	/**
	* Returns all groups this user belongs to and if they are an admin
	* @param none
	* @return array groups this user belongs to and if they are an admin.  key => groupid, value => array (groupid, group_name, is_admin)
	*/
	function _get_groups() {
		return $this->db->get_user_groups($this->userid);
	}
	
	/**
	* Gets a list of groups that this user is a member of
	* @param none
	* @return array groups this user belongs to and if they are an admin.  key => groupid, value => array (groupid, group_name, is_admin)
	*/
	function get_groups() {
		if ($this->groups == null) {
			$this->groups = $this->_get_groups();
		}
		
		return $this->groups;
	}
	
	/**
	* Gets a list of group ids that this user is a member of
	* @param none
	* @return array of group ids this user is a member of
	*/
	function get_groupids() {
		if ($this->groups == null) {
			$this->groups = $this->_get_groups();
		}
		
		return array_keys($this->groups);
	}
	
	/**
	* Gets a list of all groups that this user is an administrator of
	* @param none
	* @return array of all groupids that this user is an administrator for
	*/
	function get_admin_groups() {
		$admins = array();
		
		$groups = $this->get_groups();
		if ($groups != null) {
			foreach ($groups as $groupid => $data) {
				if ((int)$data['is_admin'] == 1) {
					$admins[] = $groupid;
				}
			}
		}
		
		return $admins;
	}
	
	/**
	* Returns all permissions for this user
	* @param none
	* @return array of permissions with key => machid value => resource name
	*/
	function get_perms() {
		if ($this->perms == null) {
			$this->persm = $this->_get_perms();
		}
		return $this->perms;
	}
	
	/**
	* Returns whether the user wants the type of email contact or not
	* @param string $type email contact type.
	*  Valid types are 'e_add', 'e_mod', 'e_del' for adding/modifying/deleting reservations, respectively
	* @return boolean whether user wants the email or not
	*/
	function wants_email($type) {
		return ($this->emails[$type] == 'y');
	}
	
	/**
	* Whether the user wants html or plain text emails
	* @param none
	* @return whether they want html email or not
	*/
	function wants_html() {
		return ($this->emails['e_html'] == 'y');
	}
	
	/**
	* Sets the users email preferences
	* @param string $e_add value to set e_add field to
	* @param string $e_mod value to set e_mod field to
	* @param string $e_del value to set e_del field to
    * @param string $e_app value to set e_app field to
	* @param string $e_html value to set e_html field to
	*/
	function set_emails($e_add, $e_mod, $e_del, $e_app, $e_html) {
		$this->db->set_emails($e_add, $e_mod, $e_del, $e_app, $e_html, $this->userid);
	}
	
	/**
	* Return all user data in an array
	* @param none
	* @return assoc array of all user data
	*/
	function get_user_data() {
		return array (
				'memberid' 	=> $this->userid,
				'email'		=> $this->email,
				'fname'		=> $this->fname,
				'lname'		=> $this->lname,
				'phone'		=> $this->phone,
				'institution'=> $this->inst,
				'position'	=> $this->position,
				'perms'		=> $this->perms,
				'logon_name'=> $this->logon_name,
				'groups' 	=> $this->groups,
				'lang' 		=> $this->lang,
				'timezone'	=> $this->timezone
			);
	}
	
	/**
	* Sets a users password
	* @param string $new_password the new password to set for this user
	*/
	function set_password($new_password) {
		$this->db->set_password($new_password, $this->userid);
	}
	
	/**
	* Adds the user to the list of groups
	* @param array $groups array of groups to add the user to
	*/
	function add_groups($groups) {
		$this->db->add_groups($this->userid, $groups);
		$this->groups = null;		// Will reload on the next call to get_groups()
	}
	
	/**
	* Removes the user from the list of groups
	* @param array $groups array of groups to remove the user from
	*/
	function remove_groups($groups) {
		$this->db->remove_groups($this->userid, $groups);
		$this->groups = null;		// Will reload on the next call to get_groups()
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
	* Returns whether this user is an admin of the group or not
	* @param array $groupids (optional) the group ids to check for admin on.  if this is not provided, this just checks if the user is an admin of any group
	* @return if the user is the group admin or not
	*/
	function is_group_admin($groupids = null) {
		$admin_groups = $this->get_admin_groups();
			
		if ( !is_null($groupids) ) {
			if ( count($admin_groups) <= 0 ) { 
				return false;		// No groups, so can't be an admin
			}
			for ($i = 0; $i < count($groupids); $i++) {
				if ( array_search($groupids[$i], $admin_groups) !== false ) {
					return true;	// Admin of at least one of the groups
				}
			}
		}
		else {
			return count($admin_groups) > 0;
		}
	}
	
	/**
	* Stores the user's language preference to the database
	* @param string $lang the language key
	*/
	function set_lang($lang) {
		$this->db->set_lang($this->userid, $lang);
	}
	
	/**
	* Returns the error message generated
	* @param none
	* @return error message as string
	*/
	function get_error() {
		return $this->err_msg;
	}
	
	function get_id() {
		return $this->userid;
	}
	
	function get_fname() {
		return $this->fname;
	}
	
	function get_lname() {
		return $this->lname;
	}
	
	function get_name() {
		return $this->fname . ' ' . $this->lname;
	}
	
	function get_email() {
		return $this->email;
	}
	
	function get_phone() {
		return $this->phone;
	}
	
	function get_inst() {
		return $this->inst;
	}
	
	function get_position() {
		return $this->position;
	}
	
	function get_isadmin() {
		return $this->is_admin;
	}
	
	function get_logon_name() {
		return $this->logon_name;
	}
	
	function get_lang() {
		return $this->lang;
	}
	
	function get_timezone() {
		return $this->timezone;
	}
}
?>
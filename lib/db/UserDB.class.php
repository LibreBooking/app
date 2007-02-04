<?php
/**
* This file contains the database class to work with the User class
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @author David Poole <David.Poole@fccc.edu>
* @version 03-16-06
* @package DBEngine
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/
$basedir = dirname(__FILE__) . '/../..';

include_once($basedir . '/lib/DBEngine.class.php');

/**
* Provide functionality for getting and setting user data
*/
class UserDB extends DBEngine {

	/**
	* Return all data associated with this userid
	* @param string $userid id of user to find
	* @return array of user data
	*/
	function get_user_data($userid) {
		$result = $this->db->getRow('SELECT * FROM ' . $this->get_table(TBL_LOGIN) . ' WHERE memberid=?', array($userid));
		$this->check_for_error($result);
		
		if (count($result) <= 0) {
			$this->err_msg = translate('That record could not be found.');
			return false;
		}
		
		return $this->cleanRow($result);
	}
	
	/**
	* Return an array of this users permissions
	* If the user has permission to use a resource
	*  its id will be an index in the array
	* @param string $userid id of user to look up
	* @return array of user permissions
	*/
	function get_user_perms($userid) {
		$return = array();
		
		$result = $this->db->query('SELECT p.*, m.name FROM ' . $this->get_table('permission') . ' as p INNER JOIN ' . $this->get_table('resources') . ' as m ON p.machid=m.machid WHERE memberid=?', array($userid));
		$this->check_for_error($result);
		
		while ($rs = $result->fetchRow())
			$return[$rs['machid']] = $rs['name'];
		
		$result->free();
		
		return $return;
	}
	
	/**
	* Returns an array of email settings for a user
	* @param string $userid id of member to look up
	* @return array of settings for user email contacts
	*/
	function get_emails($userid) {
		$result = $this->db->getRow('SELECT e_add, e_mod, e_del, e_app, e_html FROM ' . $this->get_table(TBL_LOGIN) . ' WHERE memberid=?', array($userid));
		$this->check_for_error($result);
		
		if (count($result) <= 0) {
			$this->err_msg = translate('That record could not be found.');
			return false;
		}
		
		return $result;			
	}
	
	/**
	* Sets the user email preferences in the database
	* @param string $e_add email on new reservation creation
	* @param string $e_mod email on reservation modification
	* @param string $e_del email on reservation delete
	* @param string $e_html send email in html or plain text
	* @param string $userid userid who we are managing
	*/
    function set_emails($e_add, $e_mod, $e_del, $e_app, $e_html, $userid) {
		$result = $this->db->query('UPDATE ' . $this->get_table(TBL_LOGIN)
						. ' SET e_add=?, '
						. 'e_mod=?, '
						. 'e_del=?, '
						. 'e_app=?, '
						. 'e_html=? '
						. 'WHERE memberid=?', array($e_add, $e_mod, $e_del, $e_app, $e_html, $userid));
		
		$this->check_for_error($result);
	}
	
	/**
	* Sets a users password
	* @param string $new_password the new password to set for this user
	* @param string $userid id of user to change password
	*/
	function set_password($new_password, $userid) {
		$result = $this->db->query(
						'UPDATE ' . $this->get_table(TBL_LOGIN)
						. ' SET password=? WHERE memberid=?',
						array($this->make_password($new_password), $userid)
					);
		
		$this->check_for_error($result);
	}
	
	/**
	* Gets an anonymous user by email
	* @param string $email the email address of the User or AnonymousUser
	* @return the memberid, if it exists
	*/
	function get_id_by_email($email) {
		$result = $this->db->getRow('SELECT memberid FROM ' . $this->get_table(TBL_LOGIN) . ' WHERE email=?', array($email));
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
	* Gets all groups that the user belongs to and if they are an admin
	* @param string $userid the id of the user to get groups for
	* @return array of groupid => array (groupid, group_name, is_admin) records that the user belongs to
	*/
	function get_user_groups($userid) {
		$return = array();
		
		$query = 'SELECT g.groupid, g.group_name, ug.is_admin FROM '
				. $this->get_table(TBL_USER_GROUPS) . ' ug INNER JOIN '
				. $this->get_table(TBL_GROUPS) . ' g ON g.groupid = ug.groupid
				WHERE ug.memberid=?';
		
		$result = $this->db->query($query, array($userid));
		$this->check_for_error($result);

		while ($rs = $result->fetchRow()) {
			$return[$rs['groupid']] = array('groupid' => $rs['groupid'], 'group_name' => $rs['group_name'], 'is_admin' => $rs['is_admin']);
		}
		
		$result->free();
		
		return $return;	
	}
	
	/**
	* Adds the user to the list of groups
	* @param array $groups array of groups to add the user to
	*/
	function add_groups($memberid, $groups) {
		if (count($groups) > 0) {
			$values = null;
		
			for ($i = 0; $i < count($groups); $i++) {
				$values[] = array($groups[$i], $memberid);
			}
			
			$query = 'INSERT INTO ' . $this->get_table(TBL_USER_GROUPS) . ' (groupid, memberid) VALUES (?,?)';
			
			$q = $this->db->prepare($query);
			$result = $this->db->executeMultiple($q, $values);
			$this->check_for_error($result);
		}
	}
	
	/**
	* Removes the user from the list of groups
	* @param array $groups array of groups to remove the user from
	*/
	function remove_groups($memberid, $groups) {
		$del_list = $this->make_del_list($groups);
		
		$query = 'DELETE FROM ' . $this->get_table(TBL_USER_GROUPS) . ' WHERE memberid = ? AND groupid IN (' . $del_list . ')';
		$q = $this->db->prepare($query);
		$result = $this->db->execute($q, array($memberid));
		$this->check_for_error($result);
	}
	
	/**
	* Sets the language preference for this user
	* @param string $memberid id of the user to set
	* @param string $lang the language key
	*/
	function set_lang($memberid, $lang) {
		$query = 'UPDATE ' . $this->get_table(TBL_LOGIN) . ' SET lang = ? WHERE memberid = ?';
		$q = $this->db->prepare($query);
		$result = $this->db->execute($q, array($lang, $memberid));
		$this->check_for_error($result);
	}
}
?>
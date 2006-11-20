<?php
/**
* UserInfoDB class
* Provides database functions for userInfo.php
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 04-10-04
* @package DBEngine
*
* Copyright (C) 2003 - 2006 phpScheduleIt
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
* Provide functionality for userInfo.php
*/
class UserInfoDB extends DBEngine {
	
	/**
	* Returns the previous (alphabetic) memberid
	* @param object $user current user object
	* @return previous memberid as string
	*/
	function get_prev_userid(&$user) {
		$data = array ($user->get_lname(), $user->get_lname(), $user->get_fname(), $user->get_id());
		$result = $this->db->getRow('SELECT memberid FROM ' . $this->get_table('login')
				. ' WHERE ('
				. ' (lname<?) '
				. ' OR (lname=? AND fname<=?)'
				. ') '
				. ' AND memberid <> ?'
				. ' ORDER BY lname, fname', $data);

		$this->check_for_error($result);
		
		if (count($result) <= 0)
			return $user->get_id();
		
		return $result['memberid'];
	}
	
	/**
	* Returns the next (alphabetic) memberid
	* @param object $user current user object
	* @return next memberid as string
	*/
	function get_next_userid(&$user) {
		$data = array ($user->get_lname(), $user->get_lname(), $user->get_fname(), $user->get_id());
		$result = $this->db->getRow('SELECT memberid FROM ' . $this->get_table('login')
				. ' WHERE ('
				. ' (lname>?) '
				. ' OR (lname=? AND fname>=?)'
				. ') '
				. ' AND memberid <> ?'
				. ' ORDER BY lname, fname', $data);

		$this->check_for_error($result);
		
		if (count($result) <= 0)
			return $user->get_id();
		
		return $result['memberid'];
	}
}
?>
<?php
/**
* Ability to search for group data
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 04-14-06
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/

require_once('db/GroupDB.class.php');

class Group
{
	var $data = null;
	var $id = null;
	var $name = null;
	var $adminid = null;
	
	function Group($data = null, $id = null) {
		$this->data = $data;
		
		if (!empty($id)) {
			$this->id = $id;		
			$row = $this->data->getGroup($id);
			
			$this->name = $row['group_name'];
			$this->adminid = $row['adminid'];
		}
	}
	
	/**
	* Gets a list of groups that the excluded memberid does not belong to
	* @param string $excluded_memberid groups will not be returned that have this member
	* @return array of group data
	*/
	function getGroups($excluded_memberid = null) {
		if (!empty($excluded_memberid)) {
			return $this->data->getExcludedGroups($excluded_memberid);
		}
		
		return $this->data->getGroups();
	}
}
?>
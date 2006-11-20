<?php

@define('BASE_DIR', dirname(__FILE__) . '/../..');
include_once(BASE_DIR . '/lib/DBEngine.class.php');

class GroupDB extends DBEngine
{
	/**
	* Gets all information about the selected group
	* @param string $id id if the group to return
	* @return array of group data
	*/
	function getGroup($id) {	
		$query = 'SELECT g.*, ug.memberid as adminid FROM ' . $this->get_table(TBL_GROUPS) . ' as g LEFT JOIN '
				. $this->get_table(TBL_USER_GROUPS) . ' as ug ON ug.groupid = g.groupid AND ug.is_admin = 1
				WHERE g.groupid=?';

		$result = $this->db->getRow($query, array($id));
		$this->check_for_error($result);
		
		if (count($result) <= 0) {
			$this->err_msg = translate('That record could not be found.');
			return false;
		}
		
		return $this->cleanRow($result);
	}
	
	/**
	* Gets all information about the all groups
	* @param string $id id if the group to return
	* @return array of group data
	*/
	function getGroups() {
		$return = array();
		
		$query = 'SELECT g.*, ug.memberid as adminid FROM ' . $this->get_table(TBL_GROUPS) . ' g LEFT JOIN '
				. $this->get_table(TBL_USER_GROUPS) . ' ug ON ug.groupid = g.groupid AND ug.is_admin = 1';
		
		$result = $this->db->query($query, array($id));
		$this->check_for_error($result);
		
		while ($rs = $result->fetchRow()) {
			$return[] = $this->cleanRow($rs);
		}
		
		$result->free();	
		return $return;
	}
	
	/**
	* Gets a list of groups that the excluded memberid does not belong to
	* @param string $excluded_memberid groups will not be returned that have this member
	* @return array of group data
	*/
	function getExcludedGroups($excluded_memberid) {
		$return = array();
		
		$query = 'SELECT g.* FROM ' . $this->get_table(TBL_GROUPS) . ' as g LEFT JOIN '
				. $this->get_table(TBL_USER_GROUPS) . ' ug ON ug.groupid = g.groupid AND ug.memberid = ? LEFT JOIN '
				. $this->get_table(TBL_USER_GROUPS) . ' ug2 ON ug.groupid = g.groupid AND ug2.is_admin = 1'
				. ' WHERE ug.groupid IS NULL';

		$result = $this->db->query($query, array($excluded_memberid));
		$this->check_for_error($result);
		
		while ($rs = $result->fetchRow()) {
			$return[] = $this->cleanRow($rs);
		}
		
		$result->free();	
		return $return;
	}
}
?>

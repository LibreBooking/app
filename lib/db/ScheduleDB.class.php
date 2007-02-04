<?php
/**
* ScheduleDB class
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @author Richard Cantzler <rmcii@users.sourceforge.net>
* @version 03-18-06
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

define('BLACKOUT_ONLY', 1);			// Define constants
define('RESERVATION_ONLY', 2);
define('ALL', 3);
define('READ_ONLY', 4);

/**
* Provide all database access/manipulation functionality
* @see DBEngine
*/
class ScheduleDB extends DBEngine {
	var $scheduleType;
	var $scheduleid;
	
	function ScheduleDB($scheduleid, $scheduleType) {
		$this->DBEngine();				// Call parent constructor
		$this->scheduleType = $scheduleType;
		$this->scheduleid = $scheduleid;
	}
	
	/**
	* Get all reservation data
	* This function gets all reservation data
	* between a given start and end date
	* @param int $start_date the starting date to get reservations for
	* @param int $end_date the ending date to get reservations for
	* @param array $machids list of resource ids to get reservations for
	* @param string $current_memberid the id of the currently logged in user
	* @return array of reservation data formatted: $array[date|machid][#] = array of data
	*  or an empty array
	*/
	function get_all_res($start_date, $end_date, $machids, $current_memberid = null) {
		$return = array();
		$mach_ids = $this->make_del_list($machids);
		
		// If it starts between the 2 dates, ends between the 2 dates, or surrounds the 2 dates, get it
		$sql = 'SELECT res.*, res_users.*, login.fname, login.lname, participant.memberid as participantid, participant.owner'
				. ' FROM ' . $this->get_table(TBL_RESERVATIONS) . ' as res'
				. ' INNER JOIN ' . $this->get_table(TBL_RESERVATION_USERS) . ' as res_users ON res.resid = res_users.resid'
				. ' INNER JOIN ' . $this->get_table(TBL_LOGIN) . ' as login ON res_users.memberid = login.memberid'
				. ' LEFT JOIN ' . $this->get_table(TBL_RESERVATION_USERS) . ' as participant ON res.resid = participant.resid AND participant.memberid = ? AND participant.invited = 0'
			. ' WHERE ( '
						. '( '
							. '(start_date >= ? AND start_date <= ?)'
							. ' OR '
							. '(end_date >= ? AND end_date <= ?)'
						. ' )'
						. ' OR '
						. '(start_date <= ?  AND end_date >= ?)'
			.      ' )'
			. ' AND res_users.owner=1';
		
		if ($this->scheduleType == RESERVATION_ONLY)
			$sql .= ' AND res.is_blackout <> 1 ';
		
		$sql .= ' AND res.machid IN (' . $mach_ids . ')';
		
		$sql .= ' ORDER BY res.start_date, res.starttime, res.end_date, res.endtime';

		$values = array($current_memberid, $start_date, $end_date, $start_date, $end_date, $start_date, $end_date);
		
		$p = $this->db->prepare($sql);
		$result = $this->db->execute($p, $values);
		
		$this->check_for_error($result);
		
		while ($rs = $result->fetchRow()) {
			$index = $rs['machid'];
			$return[$index][] = $rs;
		}
		
		$result->free();
		
		return $return;
	}
}
?>
<?php
/**
* MyCalendarDB class
* Provides backend DB functions for the MyCalendar class
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @author Richard Cantzler <rmcii@users.sourceforge.net>
* @version 04-08-06
* @package DBEngine
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/

@define('BASE_DIR', dirname(__FILE__) . '/../..');
include_once(BASE_DIR . '/lib/DBEngine.class.php');

/**
* Provide all database access/manipulation functionality
* @see DBEngine
*/
class ResCalendarDB extends DBEngine {
	
	function ResCalendarDB() {
		$this->DBEngine();				// Call parent constructor
	}
	
	/**
	* Get all reservation data
	* This function gets all reservation data
	* between a given start and end date
	* @param int $firstDate first date to return reservations from
	* @param int $lastDate last date to return reservations from
	* @param string $machid id of the user to look up reservations for
	* @param bool $is_resource if we are looking up resource data or not
	* @return array of reservation data or an empty array
	*/
	function get_all_reservations($firstDate, $lastDate, $id, $is_resource, $filterFirst, $filterLast) {
		$return = array();

		// If it starts between the 2 dates, ends between the 2 dates, or surrounds the 2 dates, get it
		$sql = 'SELECT res.*, res_users.*, resources.name, resources.location, users.fname, users.lname'
			. ' FROM ' . $this->get_table('reservations') . ' as res'
			. ' INNER JOIN ' . $this->get_table('reservation_users') . ' as res_users ON res.resid=res_users.resid'
			. ' INNER JOIN ' .  $this->get_table('resources') . ' as resources ON resources.machid = res.machid'
			. ' INNER JOIN ' . $this->get_table('login') .' as users ON users.memberid = res_users.memberid'
			. ' WHERE ( '
						. '( '
							. '(start_date >= ? AND start_date <= ?)'
							. ' OR '
							. '(end_date >= ? AND end_date <= ?)'
						. ' )'
						. ' OR '
						. '(start_date <= ?  AND end_date >= ?)'
			.      ' )'
			. ' AND res.is_blackout <> 1'
			. ' AND res_users.owner = 1';
		$sql .= (($is_resource) ? ' AND resources.machid = ?' : ' AND res.scheduleid = ?');

		$sql .= ' ORDER BY res.start_date, res.starttime, res.end_date, res.endtime';

		$values = array($firstDate, $lastDate, $firstDate, $lastDate, $firstDate, $lastDate, $id);
		
		$p = $this->db->prepare($sql);
		$result = $this->db->execute($p, $values);
		
		$this->check_for_error($result);
		
		while ($rs = $result->fetchRow()) {
			$rs['start_date'] = Time::getAdjustedDate($rs['start_date'], $rs['starttime']);
			$rs['end_date'] = Time::getAdjustedDate($rs['end_date'], $rs['endtime']);
			
			if ($rs['end_date'] >= $filterFirst && $rs['start_date'] <= $filterLast) {
				$return[] = $rs;
			}
		}
		
		$result->free();
		
		return $return;
	}
	
	/**
	* Get a list of all resources
	* @param none
	* @return array of all resources
	*/
	function get_resources() {
		$return = array();

		// Get all resources that are not on hidden schedules
		$sql = 'SELECT resources.* FROM ' . $this->get_table('resources') . ' as resources INNER JOIN ' . $this->get_table('schedules') . ' as schedules ON resources.scheduleid = schedules.scheduleid WHERE schedules.ishidden <> 1 ORDER BY scheduletitle, name';
		
		$result = $this->db->query($sql);
		
		$this->check_for_error($result);
		
		while ($rs = $result->fetchRow()) {
			$return[] = $rs;
		}
		
		$result->free();
		
		return $return;
	}
	
	/**
	* Get a all of the schedules and their settings
	* @param none
	* @return array of all schedule properties
	*/
	function get_schedules() {
		$return = array();

		// Get all non-hidden schedules
		$sql = 'SELECT * FROM ' . $this->get_table('schedules') .' as schedules WHERE ishidden <> 1 ORDER BY scheduletitle';
		
		$result = $this->db->query($sql);
		
		$this->check_for_error($result);
		
		while ($rs = $result->fetchRow()) {
			$return[] = $rs;
		}
		
		$result->free();
		
		return $return;	
	}
}
?>
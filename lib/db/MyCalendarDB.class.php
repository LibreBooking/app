<?php
/**
* MyCalendarDB class
* Provides backend DB functions for the MyCalendar class
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @author Richard Cantzler <rmcii@users.sourceforge.net>
* @version 04-08-06
* @package DBEngine
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/

@define('BASE_DIR', dirname(__FILE__) . '/../..');
include_once(BASE_DIR . '/lib/DBEngine.class.php');

/**
* Provide all database access/manipulation functionality
* @see DBEngine
*/
class MyCalendarDB extends DBEngine {
	
	function MyCalendarDB() {
		$this->DBEngine();				// Call parent constructor
	}
	
	/**
	* Get all reservation data
	* This function gets all reservation data
	* between a given start and end date
	* @param int $firstDate first date to return reservations from
	* @param int $lastDate last date to return reservations from
	* @param string $userid id of the user to look up reservations for
	* @param int $filterFirst the first date to filter allowed reservations for
	* @param int $filterLast the last date to filter allowed reservations for
	* @return array of reservation data formatted: $array[date][#] = array of data
	*  or an empty array
	*/
	function get_all_reservations($firstDate, $lastDate, $userid, $filterFirst, $filterLast) {
		$return = array();
		
		// If it starts between the 2 dates, ends between the 2 dates, or surrounds the 2 dates, get it
		$sql = 'SELECT res.*, res_users.*, resources.name, resources.location, login.fname, login.lname FROM '
			. $this->get_table('reservations') . ' as res'
			. ' INNER JOIN ' . $this->get_table('reservation_users') . ' as res_users ON res.resid=res_users.resid'
			. ' INNER JOIN ' . $this->get_table('resources') . ' as resources ON resources.machid=res.machid'
			. ' INNER JOIN ' . $this->get_table('login') . ' as login ON res_users.memberid = login.memberid'
			. ' WHERE ( '
						. '( '
							. '(start_date >= ? AND start_date <= ?)'
							. ' OR '
							. '(end_date >= ? AND end_date <= ?)'
						. ' )'
						. ' OR '
						. '(start_date <= ? AND end_date >= ?)'
			.      ' )'
			. ' AND res.is_blackout <> 1'
			. ' AND res_users.memberid = ?'
			. ' AND res_users.invited <> 1';
		$sql .= ' ORDER BY res.start_date, res.starttime, res.end_date, res.endtime, resources.name';

		$values = array($firstDate, $lastDate, $firstDate, $lastDate, $firstDate, $lastDate, $userid);
		
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
}
?>
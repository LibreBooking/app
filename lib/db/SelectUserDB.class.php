<?php
/**
* SelectUserDB class
* Provides backend DB functions for the SelectUser class
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @author Richard Cantzler <rmcii@users.sourceforge.net>
* @version 07-07-05
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
* Provide all database access/manipulation functionality
* @see DBEngine
*/
class SelectUserDB extends DBEngine {
	
	function SelectUserDB() {
		$this->DBEngine();				// Call parent constructor
	}
	
	/**
	* Get all reservation data
	* This function gets all reservation data
	* between a given start and end date
	* @param int $firstDate first date to return reservations from
	* @param int $lastDate last date to return reservations from
	* @param string $userid id of the user to look up reservations for
	* @return array of reservation data formatted: $array[date][#] = array of data
	*  or an empty array
	*/
	function get_all_reservations($firstDate, $lastDate, $userid) {
		$return = array();

		// If it starts between the 2 dates, ends between the 2 dates, or surrounds the 2 dates, get it
		$sql = 'SELECT res.*, res_users.*, resources.name, resources.location FROM ' . $this->get_table('reservations') . ' as res, ' . $this->get_table('reservation_users') . ' as res_users, ' . $this->get_table('resources')
			. ' as resources WHERE ( '
						. '( '
							. '(start_date >= ? AND start_date <= ?)'
							. ' OR '
							. '(end_date >= ? AND end_date <= ?)'
						. ' )'
						. ' OR '
						. '(start_date <= ?  AND end_date >= ?)'
			.      ' )'
			. ' AND res.resid=res_users.resid'
			. ' AND res.is_blackout <> 1'
			. ' AND res_users.memberid = ?'
			. ' AND res_users.invited <> 1'
			. ' AND resources.machid=res.machid';
		
		$sql .= ' ORDER BY res.start_date, res.starttime, res.end_date, res.endtime, resources.name';

		$values = array($firstDate, $lastDate, $firstDate, $lastDate, $firstDate, $lastDate, $userid);
		
		$p = $this->db->prepare($sql);
		$result = $this->db->execute($p, $values);
		
		$this->check_for_error($result);
		
		while ($rs = $result->fetchRow()) {
			$return[] = $rs;
		}
		
		$result->free();
		
		return $return;
	}
}
?>
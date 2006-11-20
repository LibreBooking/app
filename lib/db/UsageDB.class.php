<?php
/**
* UsageDB class
* Provides database functions for usage.php
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @author Attila <atoth@cmr.sote.hu>
* @version 05-04-06
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

class UsageDB extends DBEngine {

	/**
	* Get the min and max dates of all reservations in the database
	* @param none
	* @return array of min and max dates
	*/
	function get_min_max() {
		// Get min and max dates of reservations in database
		$query = 'SELECT MIN(start_date) as startmin, MAX(start_date) as startmax, MIN(end_date) as endmin, MAX(end_date) as endmax
							FROM ' . $this->get_table('reservations') . ' WHERE is_blackout <> 1';
		$result = $this->db->getRow($query);

		// Check query
		$this->check_for_error($result);
			
		if (empty($result['startmin'])) {		// If there are no reservations, set all dates to today
			list(
				$return['startmin']['mon'], $return['startmin']['day'], $return['startmin']['year'],
				$return['startmax']['mon'], $return['startmax']['day'], $return['startmax']['year'],
				$return['endmin']['mon'], $return['endmin']['day'], $return['endmin']['year'],
				$return['endmax']['mon'], $return['endmax']['day'], $return['endmax']['year']
				) 
				= split('-', date('m-d-Y-m-d-Y-m-d-Y-m-d-Y'));
		}
		else {							// Else, set min and max values
			list($return['startmin']['mon'], $return['startmin']['day'], $return['startmin']['year']) 
					= split('-', date('m-d-Y', $result['startmin']));
			list($return['startmax']['mon'], $return['startmax']['day'], $return['startmax']['year'])
					= split('-', date('m-d-Y', $result['startmax']));
			list($return['endmin']['mon'], $return['endmin']['day'], $return['endmin']['year']) 
					= split('-', date('m-d-Y', $result['endmin']));
			list($return['endmax']['mon'], $return['endmax']['day'], $return['endmax']['year'])
					= split('-', date('m-d-Y', $result['endmax']));		
		}
		
		return $return;
	}

	/**
	* Finds all reservations matching the given criteria
	* @param array $scheduleids scheduleids
	* @param array $memberids memberids
	* @param array $machid machids
	* @param int $startDateMin minimum start date timestamp
	* @param int $startDateMax maximum start date timestamp
	* @param int $endDateMin minimum end date timestamp
	* @param int $endDateMax maximum end date timestamp
	* @param int $starttimeMin minimum start time value
	* @param int $starttimeMax maximum start time value
	* @param int $endtimeMin minimum end time value
	* @param int $endtimeMax maximum end time value
	* @return mixed array of reservations or false if none are found
	*/
	function get_reservations($scheduleids, $memberids, $machids, $startDateMin, $startDateMax, $endDateMin, $endDateMax, $starttimeMin, $starttimeMax, $endtimeMin, $endtimeMax, $summarysearch, $searchtype) {
		
		// Limit columns as much as possible to speed up query
		$query = 'SELECT l.memberid, l.fname, l.lname,
				rs.machid, rs.name,
				s.scheduleid, s.scheduletitle,
				res.*,
				ru.memberid, ru.owner
				FROM ' . $this->get_table('login') . ' as l, '
					. $this->get_table('resources') . ' as rs, '
					. $this->get_table('schedules') . ' as s, '
					. $this->get_table('reservations') . ' as res, '
					. $this->get_table('reservation_users') . ' as ru ';

		// Begin setting up WHERE clause of query using passed in dates/times
		$where = ' WHERE (res.start_date>=?)
					AND (res.start_date<=?)
					AND (res.end_date>=?)
					AND (res.end_date<=?)
					AND (res.starttime>=?)
					AND (res.starttime<=?)
					AND (res.endtime>=?)
					AND (res.endtime<=?)
					AND (res.is_blackout <> 1)
					AND (res.is_pending <> 1)
					AND (res.resid = ru.resid) 
					AND (ru.owner = 1) ';
		// Begin setting up values array for query
		$values = array($startDateMin, $startDateMax, $endDateMin, $endDateMax, $starttimeMin, $starttimeMax, $endtimeMin, $endtimeMax);
	
		// Construct ORDER clause
		$order = ' ORDER BY l.lname, l.fname,
					rs.name,
					res.start_date, res.starttime, res.end_date, res.endtime ';
		/**********************************************
		* Determine what schedules to search for
		* 
		* If the first item in the array is string "all",
		* then search on all schedules.
		* Else get each scheduleid passed in and search just
		* for those schedules.
		**********************************************/
		// Add "AND" to where clause
		$where .= ' AND ';
	
		if ($scheduleids[0] != 'all') {
			// Join on specific memebers
			$where .= '(s.scheduleid=?';
			// Push this value onto values array
			array_push($values, $scheduleids[0]);
		}
	
		if ( (count($scheduleids)>1) && ($scheduleids[0] != 'all') ) {
			for ($i=1; $i<count($scheduleids); $i++) {
				$where .= ' OR s.scheduleid=?';
				// Push this value onto values array
				array_push($values, $scheduleids[$i]);
			}
		}
		// Add "AND" if WHERE clause is not empty
		$where .= ($scheduleids[0] != 'all') ? ') AND ' : '';
		// Join login/reservations on memberid
		$where .= ' (s.scheduleid=res.scheduleid) ';
		/**********************************************
		* Determine what users to search for
		* 
		* If the first item in the array is string "all",
		* then search on all users.
		* Else get each memberid passed in and search just
		* for those members.
		**********************************************/
		// Add "AND" to where clause
		$where .= ' AND ';
	
		if ($memberids[0] != 'all') {
			// Join on specific memebers
			$where .= '(l.memberid=?';
			// Push this value onto values array
			array_push($values, $memberids[0]);
		}
	
		if ( (count($memberids)>1) && ($memberids[0] != 'all') ) {
			for ($i=1; $i<count($memberids); $i++) {
				$where .= ' OR l.memberid=?';
				// Push this value onto values array
				array_push($values, $memberids[$i]);
			}
		}
		// Add "AND" if WHERE clause is not empty
		$where .= ($memberids[0] != 'all') ? ') AND ' : '';
		// Join login/reservation_users on memberid
		$where .= ' (l.memberid=ru.memberid) ';
		/**********************************************
		* Determine what resources to search for
		* 
		* If the first item in the array is string "all",
		* then search on all resources.
		* Else get each machid passed in and search just
		* for those resources.
		**********************************************/
		// Add "AND" to where clause
		$where .= ' AND ';
		
		if ($machids[0] != 'all') {
			// Join on specific pis
			$where .= '(rs.machid=?';
			array_push($values, $machids[0]);
		}
	
		if ( (count($machids)>1) && ($machids[0] != 'all') ) {
			for ($i = 1; $i < count($machids); $i++) {
				$where .= ' OR rs.machid=?';
				array_push($values, $machids[$i]);
			}
		}
		
		// Add "AND" if WHERE clause is not empty
		$where .= ($machids[0] != 'all') ? ') AND ' : '';
		// Join resources/reservations on machid
		$where .= ' (res.machid=rs.machid) ';
		
		// Summary search clause
		if (!empty($summarysearch)) {
			if ($searchtype != 'beginning') {
				$where .= ' AND res.summary LIKE "%' . $summarysearch . '%" ';
			}
			else {
				$where .= ' AND res.summary LIKE "' . $summarysearch . '%" ';
			}
		}
		
		// Put query together
		$query .= $where . $order;
		
		// Prepare query
		$q = $this->db->prepare($query);
		// Execute query
		$result = $this->db->execute($q, $values);

		// Check query
		$this->check_for_error($result);
		
		$return = array();
		while ($rs = $result->fetchRow())
			$return[] = $this->cleanRow($rs);
		
		return $return;
	}
	
	/**
	* Return the total reservation times for each resource
	* @param array $machids machids to return
	* @return mixed resource array of machid => total time
	*/
	function get_resource_times($machids) {
		$return = array();
		$mach_ids = $this->make_del_list($machids);
		$in = ($machids[0] != 'all') ? ' WHERE machid IN (' . $mach_ids . ') AND' : ' WHERE ';
		$query = 'SELECT sum(((end_date/60)+endtime)-((start_date/60)+starttime)) as sum, machid, is_blackout FROM ' . $this->get_table('reservations') . $in . ' (is_blackout <> 1) AND (is_pending <> 1) GROUP BY machid';
		$result = $this->db->query($query);
		
		$this->check_for_error($result);
		
		while ($rs = $result->fetchRow())
			$return[$rs['machid']] = $rs['sum'];

		return $return;
	}
}
?>
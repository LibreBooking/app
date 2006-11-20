<?php
/**
* Stats class
* Provides functions for finding statistics about
*  phpScheduleIt and reservations
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 11-21-04
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/
/**
* Base directory of application
*/
@define('BASE_DIR', dirname(__FILE__) . '/..');
/**
* Include StatsDB class
*/
include_once('db/StatsDB.class.php');
/**
* Include stats templates
*/
include_once(BASE_DIR . '/templates/stats.template.php');

define('MONTH', 1);			// Define constants
define('DAY_OF_WEEK', 2);
define('DAY_OF_MONTH', 3);
define('USER', 4);
define('RESOURCE', 5);
define('starttime', 6);
define('endtime', 7);

/**
* This class provides all the functionality for parsing and computing
*  statistics for all the reservations in the database.
* Results will be grouped by any number of grouping criteria.
* The user must call set_stats(CONSTANT_STAT_TYPE) and then print_stats()
*  for each statistic they want to print
*/
class Stats {

	var $days_in_mon = array (31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30 , 31);
	var $month_names = array();
	var $day_names = array();

	var $machids	 = array();
	var $userids	 = array();

	var $scheduleid		= '';
	var $sched			= array();
	var $timespan		= '';
	var $startDay		= 0;
	var $endDay			= 0;

	var $type;				// Type of stat to find
	var $db;

	var $labels = array();
	var $values = array();
	var $index  = array();
	var $dyntot = array();

	var $dynlabel = false;	// Whether to use dynamic labeling
	var $lbl_fnc;			// Dynamic label function name
	var $dyn_title;			// Dynamic title

	var $numUsers	= 0;
	var $numRes		= 0;
	var $numRs		= 0;
	var $total		= 0;
	var $longest	= 0;
	var $shortest	= 1440;
	var $active_resource = array ('num' => 0, 'id' => NULL, 'name' => NULL);	// Most active xxxx
	var $active_user 	 = array ('num' => 0, 'id' => NULL, 'name' => NULL);

	var $month;				// Stats arrays
	var $dayofmonth;		//
	var $dayofweek;			//
	var $starttime;			//
	var $endtime;			//
	var $total_time;		//
	var $resource;			//
	var $user;				//

	var $color0 = '#dedede';	// Graphical properties
	var $color1 = '#ededed';	// (alternating row colors)
	var $bar_outline = 'solid #000000 1px';
	var $bar_color	 = '#FF0000';
	var $height = '5px';		// (bar height)
	var $fnt_sz	= '10px';		//

	var $graph_title;

	function Stats() {
		global $months_abbr;
		global $days_abbr;

		$this->db = new StatsDB();
		for ($i = 1; $i <= count($months_abbr); $i++)
			$this->month_names[$i] = $months_abbr[$i-1];//array_fill(1, count($months_abbr), $months_abbr);
		$this->day_names = $days_abbr;
	}

	/**
	* Initializes the stats class
	* @param none
	*/
	function init() {
		$this->numUsers = $this->db->get_quick_stats('login');
		$this->numRes	= $this->db->get_quick_stats('reservations');
		$this->numRs	= $this->db->get_quick_stats('resources');

		// Set $this->machids array
		$machs = $this->db->get_resources();//'resources', array('machid', 'name'), array('name'));

		for ($i = 0; $i < count($machs); $i++)
			$this->machids[$machs[$i]['machid']] = $machs[$i]['name'];
		// Set $this->userids array
		$users = $this->db->get_table_data('login', array ('memberid, fname, lname'), array ('lname', 'fname'));
		for ($i = 0; $i < count($users); $i++)
			$this->userids[$users[$i]['memberid']] = $users[$i]['lname'] . ', ' . $users[$i]['fname'];

		$this->parse();
	}

	/**
	* Sets the schedule id
	* @param string $scheduleid id of the schedule
	*/
	function set_schedule($scheduleid) {
		if (empty($scheduleid))
			$this->scheduleid = $this->db->get_default_id();
		else
			$this->scheduleid = $scheduleid;

		return $this->db->check_scheduleid($this->scheduleid);
	}

	/**
	* Loads the schedule data
	* @param none
	*/
	function load_schedule() {
		$this->db->scheduleid = $this->scheduleid;

		$this->sched = $this->db->get_schedule_data($this->scheduleid);
		$this->timespan = $this->sched['timespan'];
		$this->startDay = $this->sched['daystart'];
		$this->endDay	= $this->sched['dayend'];
	}

	/**
	* Gets the list of schedules
	* @param none
	* @return array of schedules
	*/
	function get_schedule_list() {
		return $this->db->get_schedule_list();
	}

	/**
	* Prints out schedule invalid error
	* @param none
	*/
	function print_schedule_error() {
		CmnFns::do_error_box(translate('That schedule is not available.') . '<br/><a href="javascript: history.back();">' . translate('Back') . '</a>', '', false);
	}

	/**
	* Parse the database, storing necessary stats
	* @param none
	*/
	function parse() {

		$m = $w = $d = $s = $e = $r = $u = $p = array();
		$total_time = 0;

		$res = $this->db->get_all_stats();
		if (!$res) {		// If there are no reservations, return
			//echo $this->db->get_err();
			return;
		}

		for ($i = 0; $i < count($res); $i++) {
			$date = getdate($res[$i]['start_date']);
			$starttime = $res[$i]['starttime'];
			$endtime   = $res[$i]['endtime'];
			$start_date = $res[$i]['start_date'];
			$end_date = $res[$i]['end_date'];

			$m[$date['mon']]  = (!isset($m[$date['mon']])) ? 1 : $m[$date['mon']]  + 1;		// By month
			$d[$date['mday']][$date['mon']] = (!isset($d[$date['mday']][$date['mon']])) ? 1 : $d[$date['mday']][$date['mon']] + 1;	// By day of month
			$w[$date['wday']] = (!isset($w[$date['wday']])) ? 1 : $w[$date['wday']] + 1;	// By day of week

			$s[$starttime] = (!isset($s[$starttime])) ? 1 : $s[$starttime] + 1;	// By start time
			$e[$endtime] = (!isset($e[$endtime])) ? 1 : $e[$endtime] + 1;			// By end time
			$tot = (($end_date/60 + $endtime) - ($start_date/60 + $starttime));
			if ($tot < $this->shortest) $this->shortest = $tot;
			if ($tot > $this->longest) $this->longest = $tot;
			$total_time += $tot;

			$r[$res[$i]['machid']] = (!isset($r[$res[$i]['machid']])) ? 1 : $r[$res[$i]['machid']] + 1;
			if ($this->active_resource['num'] < $r[$res[$i]['machid']]) {	// Find most active resource
				$this->active_resource['num'] = $r[$res[$i]['machid']];
				$this->active_resource['id']  = $res[$i]['machid'];
				$this->active_resource['name'] = $this->machids[$res[$i]['machid']];
			}
			// Group by user for all reservations
			$u[$res[$i]['memberid']]['all'] = (!isset($u[$res[$i]['memberid']]['all'])) ? 1 : $u[$res[$i]['memberid']]['all'] + 1;
			if ($this->active_user['num'] < $u[$res[$i]['memberid']]['all']) {	// Find most active user
				$this->active_user['num'] = $u[$res[$i]['memberid']]['all'];
				$this->active_user['id']  = $res[$i]['memberid'];
				$this->active_user['name'] = $this->userids[$res[$i]['memberid']];
			}
			// Group by user for each resource
			$u[$res[$i]['memberid']][$res[$i]['machid']] = (!isset($u[$res[$i]['memberid']][$res[$i]['machid']])) ? 1 : $u[$res[$i]['memberid']][$res[$i]['machid']] + 1;

		}

		/* Arrays of stats data */
		$this->month =& $m;
		$this->dayofmonth =& $d;
		$this->dayofweek =& $w;
		$this->starttime =& $s;
		$this->endtime =& $e;
		$this->total_time =& $total_time;
		$this->resource =& $r;
		$this->user =& $u;
	}

	/**
	* Sets the object up to use dynamic labels
	* Parameter must be properly defined label handler
	* @param string $function_name
	*/
	function set_label_handler($function_name) {
		$this->dynlabel = true;
		$this->lbl_fnc = $function_name;
	}

	/**
	* Sets the stat mode
	* This will load specific labels and values
	*  to print out and will set any necessary
	*  values for this stat type
	* @param string $stat_type stat type to print
	* 			can be: MONTH, DAY_0F_WEEK, DAY_OF_MONTH, USER, RESOURCE, STARTTIME, ENDTIME
	*/
	function set_stats($stat_type) {
		global $conf;

		$start	= $this->sched['daystart'];
		$end	= $this->sched['dayend'];
		$interval = $this->sched['timespan'];

		unset($this->labels);		// Reinitialize variables
		$this->dynlabel = false;

		$this->type = $stat_type;

		switch ($stat_type) {
			case MONTH :
				$this->labels =& $this->month_names;
				$this->values =& $this->month;
				$this->total = $this->numRes;
				$this->graph_title = translate('Reservations by month');
			break;
			case DAY_OF_WEEK :
				$this->labels =& $this->day_names;
				$this->values =& $this->dayofweek;
				$this->total = $this->numRes;
				$this->graph_title = translate('Reservations by day of the week');
			break;
			case DAY_OF_MONTH :
				$this->set_label_handler('day_of_month_lbl');
				$this->values =& $this->dayofmonth;
				$this->index =& $this->month_names;
				$this->dyntot =& $this->month;
				$this->dyn_title = translate('Reservations per month');
			break;
			case USER :
				$this->labels =& $this->userids;
				$this->values =& $this->user;
				$this->total = $this->numRes;
				$this->index =& $this->machids;
				$this->dyntot =& $this->resource;
				$this->dyn_title = translate('Reservations per user');
			break;
			case RESOURCE :
				$this->labels =& $this->machids;
				$this->values =& $this->resource;
				$this->total = $this->numRes;
				$this->graph_title = translate('Reservations per resource');
			break;
			case STARTTIME :
				for ($i = $start; $i < $end; $i += $interval) {
					$this->labels[$i] = Time::formatTime($i, false);
				}
				$this->values =& $this->starttime;
				$this->total = $this->numRes;
				$this->graph_title = translate('Reservations per start time');
			break;
			case ENDTIME :
				for ($i = $start + $interval; $i <= $end; $i += $interval) {
					$this->labels[$i] = Time::formatTime($i, false);
				}
				$this->values =& $this->endtime;
				$this->total = $this->numRes;
				$this->graph_title = translate('Reservations per end time');
			break;
		}

	}

	/**
	* Prints the currently set stats
	* @param none
	*/
	function print_stats() {
		if (!empty($this->index))
			$this->print_multiple_stats();
		else
			print_stats($this);

		unset($this->index);
	}

	/**
	* Creates an index and prints out seperate tables
	*  for each index.
	* For example, to print all users individual resource usage,
	*  this function takes all the resource ids and loops through them,
	*  calculating the number of reservations per resource and printing
	*  a table for each one
	* @param none
	*/
	function print_multiple_stats() {
		if (!$this->dynlabel) {			// Only print all when we are not using dynamic labels
			$this->graph_title = $this->dyn_title . ' ' . translate('[All Reservations]');
			print_stats($this, 'all');			// Print all first
		}

		foreach ($this->index as $k => $v) {
			if ($this->dynlabel)		// Call dynamic label handler
				eval('$this->' . $this->lbl_fnc . '($k);');
			$this->total = isset($this->dyntot[$k]) ? $this->dyntot[$k] : 0;		// Set the total
			$this->graph_title = $this->dyn_title . ' ' . translate('for') . ' ' . $v;					// Set the title
			print_stats($this, $k);		// Print the graph
		}
	}

	/**
	* Returns the total number of items we are working with
	* @param none
	* @return total number of items in list
	*/
	function get_total() {
		return $this->total;
	}

	/**
	* Get total number of users in the system
	* @param none
	* @return number of users in system
	*/
	function get_num_users() {
		return $this->numUsers;
	}

	/**
	* Return number of resources in system
	* @param none
	* @return number of resources in system
	*/
	function get_num_rs() {
		return $this->numRs;
	}

	/**
	* Return number of reservations in system
	* @param none
	* @return total number of reservations in the system
	*/
	function get_num_res() {
		return $this->numRes;
	}

	/**
	* Returns the calculated percentage with a given value
	* Uses the total number of reservations if no total is given
	* @param int $val number to get percentage for (numerator)
	* @return float value result of the calculation
	*/
	function get_percent($val) {
		if (empty($this->total))
			return 0;

		return sprintf('%.02d', ($val/$this->total) * 100);
	}

	/**
	* Returns the total time of all the reservations
	* @param none
	* @return sum of all reservation times
	*/
	function get_total_time() {
		return $this->total_time;
	}

	/**
	* Returns the title of the graph
	* @param none
	* @return the title of the current graph
	*/
	function get_title() {
		return $this->graph_title;
	}

	/**
	* Dynamic label handler for day of month labels
	* @param mixed $index index for currently needed label
	*/
	function day_of_month_lbl($index) {
		unset($this->labels);
		for ($i = 1; $i <= $this->days_in_mon[$index-1]; $i++)
			$this->labels[$i] = $i;
	}
}
?>
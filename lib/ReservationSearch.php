<?php
/**
* Ability to search for reservations
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 04-19-06
* @package phpScheduleIt.ReservationSearch
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/

$basedir = dirname(__FILE__) . '/..';
require_once($basedir . '/lib/ReservationTime.class.php');
require_once($basedir . '/lib/db/ReservationSearchDB.class.php');

class ReservationSearch
{
	var $data = null;
	
	function ReservationSearch($data = null) {
		$this->data = $data;
	}
	
	function getReservation($id) {
		$res = new Reservation($id);
		$result = new ReservationResult();
		
		$result->copyFrom($res);
		
		return array($result);
	}
	
	function getReservations($userid, $start_date = null, $end_date = null) {
		$start = null;
		$end = null;
		
		if ($start_date != null) {
			$start = Time::getServerTime($start_date, 0);
		}
		if ($end_date != null) {
			$end = Time::getServerTime($end_date, 0);
		}

		return $this->data->getReservations($userid, $start, $end);
	}
}
?>
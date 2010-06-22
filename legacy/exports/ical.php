<?php
/**
* Provides ability to generate an iCalendar export file for a reservation or reservations within a date range
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 05-07-06
* @package phpScheduleIt.iCalendar
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/

require_once('../lib/pagebase/download/StreamDownload.php');
require_once('../lib/icalendar/ICalExport.php');
require_once('../lib/icalendar/ICalReservationFormatter.php');
require_once('../lib/vcalendar/VCalExport.php');
require_once('../lib/vcalendar/VCalReservationFormatter.php');
require_once('../lib/ReservationSearch.php');
require_once('../lib/Auth.class.php');

define('ICAL', 'ical');
define('VCAL','vcal');

if (!Auth::is_logged_in()) {
	CmnFns::redirect('../ctrlpnl.php', 1, false);
}

$export = getExport();
$ext = getExtension();

$page = new StreamDownload("phpScheduleIt.$ext", $export->toString());
$page->download();

function getExport() {
	$results = getResults();
	if (isset($_GET['type']) && $_GET['type'] == VCAL) {
		return new VCalExport($results);
	}
	else {
		return new ICalExport($results);
	}
}

function getExtension() {
	if (isset($_GET['type']) && $_GET['type'] == VCAL) {
		return 'vcs';
	}
	else {
		return 'ics';
	}
}

function getResults() {
	$search = new ReservationSearch(new ReservationSearchDB());
	
	$results = array();
	
	if (isset($_GET['resid'])) {
		$results = $search->getReservation(htmlspecialchars($_GET['resid']));
	}	
	else {
		$start = null;
		$end = null;
		
		$userid = Auth::getCurrentID();
		
		if ( isset($_GET['start_date']) && !empty($_GET['start_date']) ) {
			$start_date = htmlspecialchars($_GET['start_date']);
			$dates = explode(INTERNAL_DATE_SEPERATOR, $start_date);
			$start = mktime(0, 0, 0, $dates[0], $dates[1], $dates[2]);
		}
		 
		if ( isset($_GET['end_date']) && !empty($_GET['end_date']) ) {
			$end_date = htmlspecialchars($_GET['end_date']);
			$dates = explode(INTERNAL_DATE_SEPERATOR, $end_date);
			$end = mktime(0, 0, 0, $dates[0], $dates[1], $dates[2]);
		}
		
		$results = $search->getReservations($userid, $start, $end);
	}
	
	return $results;	
}
?>
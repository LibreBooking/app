<?php
/**
* Reservation class
* Provides access to reservation data
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 11-24-04
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/
/**
* Base directory of application
*/
@define('BASE_DIR', dirname(__FILE__) . '/..');
/**
* ResDB class
*/
include_once('db/ResDB.class.php');
/**
* Reservation parent class
*/
include_once('Reservation.class.php');

class Blackout extends Reservation {

	/**
	* Constructor calls parent constructor, telling it is a blackout
	* @param string $id id of this blackout
	*/
	function Blackout($id = null, $is_blackout = false, $is_pending = false, $scheduleid = null) {
		$this->Reservation($id, true, false, $scheduleid);
	}
}
?>
<?php
/**
* Represents a time on a reservation
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 04-19-06
* @package 
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/

class ReservationTime
{
	var $date = 0;
	var $time = 0;
	
	function ReservationTime($date, $time) {
		$this->date = $date;
		$this->time = $time;
	}
}
?>
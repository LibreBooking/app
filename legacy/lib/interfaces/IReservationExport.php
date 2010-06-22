<?php
/**
* Interface for exporting a formatted list of reservations
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 04-19-06
* @package Interfaces
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/

class IReservationExport
{
	var $_reservations;
	var $_formatter;

	function toString() {
		die ('Not implemented');
	}
	
	function getHeader() {
		die ('Not implemented');
	}
	
	function getFooter() {
		die ('Not implemented');
	}
}
?>
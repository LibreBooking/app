<?php
/**
* Utility class for timing code execution
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 11-11-05
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/

class Timer {
	var $name = null;
	
	var $s_sec = 0;
	var $s_msec = 0;
	var $e_sec = 0;
	var $e_msec = 0;
	var $total = 0;
	
	function Timer($name = 'Timer') {
		$this->name = $name;
	}
	
	function start() {
		list($this->s_sec, $this->s_msec) = explode(' ', microtime());	// Start execution timer
	}
	
	function stop() {
		list($this->e_sec, $this->e_msec) = explode(' ', microtime());		// End execution timer
	}
	
	function get_timer_value() {
		return ((float)$this->e_sec + (float)$this->e_msec) - ((float)$this->s_sec + (float)$this->s_msec);
	}
	
	function print_comment() {
		echo " <!-- $this->name execution time  " . $this->get_timer_value() . " seconds --> \n";
	}
	
	function toString() {
		echo $this->get_timer_value() . ' seconds';
	}
}
?>
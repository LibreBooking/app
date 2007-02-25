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
	private $name = null;
	
	private $s_sec = 0;
	private $s_msec = 0;
	private $e_sec = 0;
	private $e_msec = 0;
	private $total = 0;
	
	public function __construct($name = 'Timer') {
		$this->name = $name;
	}
	
	public function start() {
		list($this->s_sec, $this->s_msec) = explode(' ', microtime());	// Start execution timer
	}
	
	public function stop() {
		list($this->e_sec, $this->e_msec) = explode(' ', microtime());		// End execution timer
	}
	
	public function get_timer_value() {
		return ((float)$this->e_sec + (float)$this->e_msec) - ((float)$this->s_sec + (float)$this->s_msec);
	}
	
	public function print_comment() {
		echo " <!-- $this->name execution time  " . $this->get_timer_value() . " seconds --> \n";
	}
	
	public function toString() {
		echo $this->get_timer_value() . ' seconds';
	}
}
?>
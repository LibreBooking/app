<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
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
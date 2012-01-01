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

require_once('Language.php');
require_once('en_us.php');

class en_gb extends en_us
{
	public function __construct()
	{
		parent::__construct();
	}
	
	function _LoadDates()
	{
		$dates = array();
		
		// General date formatting used for all date display unless otherwise noted
		$dates['general_date'] = '%m/%d/%Y';
		// General datetime formatting used for all datetime display unless otherwise noted
		// The hour:minute:second will always follow this format
		$dates['general_datetime'] = '%m/%d/%Y @';
		// Date in the reservation notification popup and email
		$dates['res_check'] = '%A %m/%d/%Y';
		// Date on the scheduler that appears above the resource links
		$dates['schedule_daily'] = '%A,<br/>%m/%d/%Y';
		// Date on top-right of each page
		$dates['header'] = '%A, %B %d, %Y';
		
		// new stuff
		$dates['js_general_date'] = 'mm/dd/yy';
		$dates['general_date'] = 'm/d/Y';
		$dates['schedule_daily'] = 'l, m/d/Y';
		$dates['period_time'] = "g:i A";
		$dates['url'] = 'Y-m-d';
		$dates['reservation_email'] = 'm/d/Y @ g:i A (e)';
		
		$this->Dates = $dates;
	}
}
?>
<?php
/**
Copyright 2011-2016 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . '/lib/Reminder.class.php');

class FakeReminder extends Reminder
{
	function FakeReminder() {
		$day = date('d');
		$mon = date('m');
		$year = date('Y');

		$this->id = 'reminderid';
		$this->resid = 'resid';
		$this->start_time = 480;
		$this->end_time = 960;
		$this->start_date = mktime(0,0,0, $mon, $day-1, $year);
		$this->end_date = mktime(0,0,0, $mon, $day, $year);
		$this->resource_name = 'resource name';
		$this->location = 'location';
		$this->machid = 'machid';
		$this->email = 'email@email.com';
		$this->memberid = 'memberid';
		$this->timezone = 8;
	}
}
?>
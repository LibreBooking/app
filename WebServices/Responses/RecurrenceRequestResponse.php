<?php
/**
Copyright 2012-2020 Nick Korbel

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

require_once(ROOT_DIR . 'lib/WebService/namespace.php');

class RecurrenceRequestResponse
{
	public $type;
	public $interval;
	public $monthlyType;
	public $weekdays;
	public $repeatTerminationDate;

	public function __construct($type, $interval, $monthlyType, $weekdays, $repeatTerminationDate)
	{
		$this->type = $type;
		$this->interval = $interval;
		$this->monthlyType = $monthlyType;
		$this->weekdays = $weekdays;
		$this->repeatTerminationDate = $repeatTerminationDate;
	}

	public static function Example()
	{
		return new ExampleRecurrenceRequestResponse();
	}

	/**
	 * @return RecurrenceRequestResponse
	 */
	public static function Null()
	{
		return new RecurrenceRequestResponse(RepeatType::None, null, null, array(), null);
	}
}

class ExampleRecurrenceRequestResponse extends RecurrenceRequestResponse
{
	public function __construct()
	{
		$this->interval = 3;
		$this->monthlyType = RepeatMonthlyType::DayOfMonth . '|' . RepeatMonthlyType::DayOfWeek . '|null';
		$this->type = RepeatType::Daily . '|' . RepeatType::Monthly . '|' . RepeatType::None . '|' . RepeatType::Weekly . '|' . RepeatType::Yearly;
		$this->weekdays = array(0, 1, 2, 3, 4, 5, 6);
		$this->repeatTerminationDate = Date::Now()->ToIso();
	}
}


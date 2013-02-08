<?php
/**
Copyright 2013 Nick Korbel

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

class ReservationReminder
{
	private $value;
	private $interval;
	private $minutesPrior;

	public function __construct($value, $interval)
	{
		$this->value = $value;
		$this->interval = $interval;

		if ($interval == ReservationReminderInterval::Days)
		{
			$this->minutesPrior = $value * 60 * 24;
		}
		elseif ($interval == ReservationReminderInterval::Hours)
		{
			$this->minutesPrior = $value * 60;
		}
		else
		{
			$this->minutesPrior = $value;
		}
	}

	public static function None()
	{
		return new NullReservationReminder();
	}

	public function Enabled()
	{
		return true;
	}

	public function MinutesPrior()
	{
		return $this->minutesPrior;
	}
}

class NullReservationReminder extends ReservationReminder
{
	public function __construct()
	{
		parent::__construct(0, null);
	}

	public function Enabled()
	{
		return false;
	}

	public function MinutesPrior()
	{
		return 0;
	}
}

class ReservationReminderInterval
{
	const Minutes = 'minutes';
	const Hours = 'hours';
	const Days = 'days';
}

class ReservationReminderType
{
	const Start = 0;
	const End = 1;
}

?>
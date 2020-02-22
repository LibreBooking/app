<?php
/**
Copyright 2013-2020 Nick Korbel

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

class ReservationReminder
{
	private $value;
	private $interval;
	private $minutesPrior;

	public function __construct($value, $interval)
	{
		$this->value = is_numeric($value) ? $value : 0;
		$this->interval = $interval;

		if ($interval == ReservationReminderInterval::Days)
		{
			$this->minutesPrior = $this->value * 60 * 24;
		}
		elseif ($interval == ReservationReminderInterval::Hours)
		{
			$this->minutesPrior = $this->value * 60;
		}
		else
		{
			$this->interval = ReservationReminderInterval::Minutes;
			$this->minutesPrior = $this->value;
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

	/**
	 * @param int $minutes
	 * @return ReservationReminder
	 */
	public static function FromMinutes($minutes)
	{
		if ($minutes % 1440 == 0)
		{
			return new ReservationReminder($minutes / 1440, ReservationReminderInterval::Days);
		}
		elseif ($minutes % 60 == 0)
		{
			return new ReservationReminder($minutes / 60, ReservationReminderInterval::Hours);
		}
		else
		{
			return new ReservationReminder($minutes, ReservationReminderInterval::Minutes);
		}
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

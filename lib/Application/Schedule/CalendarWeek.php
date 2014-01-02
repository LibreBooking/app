<?php
/**
Copyright 2011-2014 Nick Korbel

This file is part of Booked SchedulerBooked SchedulereIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later versBooked SchedulerduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
alBooked SchedulercheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

class CalendarWeek implements ICalendarSegment
{
	/**
	 * @var array|CalendarDay[]
	 */
	private $days = array();

	/**
	 * @var string
	 */
	private $timezone;

	/**
	 * @var array|CalendarReservation[]
	 */
	private $reservations;

	public function __construct($timezone)
	{
		$this->timezone = $timezone;

		for ($i = 0; $i < 7; $i++)
		{
			$this->days[$i] = CalendarDay::Null();
		}
	}

	public static function FromDate($year, $month, $day, $timezone)
	{
		$week = new CalendarWeek($timezone);

		$date = Date::Create($year, $month, $day, 0, 0, 0, $timezone);

		$start = $date->Weekday();
		$lastDay = 7 - $start;

		for ($i = $start * -1; $i < $lastDay; $i++)
		{
			$week->AddDay(new CalendarDay($date->AddDays($i)));
		}

		return $week;
	}

	public function FirstDay()
	{
		for ($i = 0; $i < 7; $i++)
		{
			if ($this->days[$i] != CalendarDay::Null())
			{
				return $this->days[$i]->Date();
			}
		}

		return NullDate::Instance();
	}

	public function LastDay()
	{
		for ($i = 6; $i >=0; $i--)
		{
			if ($this->days[$i] != CalendarDay::Null())
			{
				return $this->days[$i]->Date()->AddDays(1);
			}
		}

		return NullDate::Instance();
	}

	public function AddReservations($reservations)
	{
		/** @var $reservation CalendarReservation */
		foreach ($reservations as $reservation)
		{
			$this->AddReservation($reservation);
		}
	}

	public function AddDay(CalendarDay $day)
	{
		$this->days[$day->Weekday()] = $day;
	}

	/**
	 * @return array|ICalendarDay[]
	 */
	public function Days()
	{
		return $this->days;
	}

	/**
	 * @param $reservation CalendarReservation
	 * @return void
	 */
	public function AddReservation($reservation)
	{
		$this->reservations[] = $reservation;
		/** @var $day CalendarDay */
		foreach ($this->days as $day)
		{
			$day->AddReservation($reservation);
		}
	}

	/**
	 * @return string|CalendarTypes
	 */
	public function GetType()
	{
		return CalendarTypes::Week;
	}

	/**
	 * @return Date
	 */
	public function GetPreviousDate()
	{
		return $this->FirstDay()->AddDays(-7);
	}

	/**
	 * @return Date
	 */
	public function GetNextDate()
	{
		return $this->FirstDay()->AddDays(7);
	}

	/**
	 * @return array|CalendarReservation[]
	 */
	public function Reservations()
	{
		return $this->reservations;
	}
}

?>
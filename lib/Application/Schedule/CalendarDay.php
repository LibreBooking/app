<?php
/**
Copyright 2011-2020 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/


interface ICalendarDay
{
	public function Date();
	public function DayOfMonth();
	public function Weekday();
	public function IsHighlighted();
	public function IsUnimportant();

	public function AddReservation($reservation);
	public function GetAdjustedStartDate($reservation);
}

class CalendarDay implements ICalendarDay, ICalendarSegment
{
	/**
	 * @var \Date
	 */
	private $date;

	/**
	 * @var bool
	 */
	private $isHighlighted = false;

	/**
	 * @var array|CalendarReservation[]
	 */
	private $reservations = array();

	public function __construct(Date $date)
	{
		$this->date = $date->GetDate();

		if ($this->date->DateEquals(Date::Now()))
		{
			$this->Highlight();
		}
	}

	/**
	 * @return int
	 */
	public function DayOfMonth()
	{
		return $this->date->Day();
	}

	/**
	 * @return int
	 */
	public function Weekday()
	{
		return $this->date->Weekday();
	}

	/**
	 * @return int
	 */
	public function IsHighlighted()
	{
		return $this->isHighlighted;
	}

	private function Highlight()
	{
		$this->isHighlighted = true;
	}

	private static $nullInstance = null;

	/**
	 * @static
	 * @return CalendarDay
	 */
	public static function Null()
	{
		if (self::$nullInstance == null)
		{
			self::$nullInstance = new NullCalendarDay();
		}
		return self::$nullInstance;
	}

	/**
	 * @return array|CalendarReservation[]
	 */
	public function Reservations()
	{
		return $this->reservations;
	}

	/**
	 * @param $reservation CalendarReservation
	 * @return void
	 */
	public function AddReservation($reservation)
	{
		if ( ($this->StartsBefore($reservation) || $this->StartsOn($reservation)) && ($this->EndsOn($reservation) || $this->EndsAfter($reservation)) )
		{
			$this->reservations[] = $reservation;
		}
	}

	/**
	 * @param $reservation CalendarReservation
	 * @return bool
	 */
	private function StartsBefore($reservation)
	{
		return $this->date->DateCompare($reservation->StartDate) >= 0;
	}

	/**
	 * @param $reservation CalendarReservation
	 * @return bool
	 */
	private function StartsOn($reservation)
	{
		return $this->date->DateEquals($reservation->StartDate);
	}

	/**
	 * @param $reservation CalendarReservation
	 * @return bool
	 */
	private function EndsAfter($reservation)
	{
		return $this->date->DateCompare($reservation->EndDate) < 0;
	}

	/**
	 * @param $reservation CalendarReservation
	 * @return bool
	 */
	private function EndsOn($reservation)
	{
		return $this->date->DateEquals($reservation->EndDate);
	}

	/**
	 * @param $reservation CalendarReservation
	 * @return Date
	 */
	public function GetAdjustedStartDate($reservation)
	{
		if ($reservation->StartDate->DateCompare($this->date) < 0)
		{
			return $this->date;
		}

		return $reservation->StartDate;
	}

	public function IsUnimportant()
	{
		return false;
	}

	/**
	 * @return Date
	 */
	public function Date()
	{
		return $this->date;
	}

	/**
	 * @return Date
	 */
	public function FirstDay()
	{
		return $this->date->GetDate();
	}

	/**
	 * @return Date
	 */
	public function LastDay()
	{
		return $this->date->AddDays(1)->GetDate();
	}

	/**
	 * @param $reservations array|CalendarReservation[]
	 * @return void
	 */
	public function AddReservations($reservations)
	{
		/** @var $reservation CalendarReservation */
		foreach ($reservations as $reservation)
		{
			$this->AddReservation($reservation);
		}
	}

	/**
	 * @return string|CalendarTypes
	 */
	public function GetType()
	{
		return CalendarTypes::Day;
	}

	/**
	 * @return Date
	 */
	public function GetPreviousDate()
	{
		return $this->date->AddDays(-1);
	}

	/**
	 * @return Date
	 */
	public function GetNextDate()
	{
		return $this->date->AddDays(1);
	}
}

class NullCalendarDay implements ICalendarDay
{
	public function __construct()
	{
	}

	public function Weekday()
	{
		return null;
	}

	public function IsHighlighted()
	{
		return false;
	}

	public function DayOfMonth()
	{
		return null;
	}

	public function Reservations()
	{
		return array();
	}

	public function AddReservation($reservation)
	{
		// no-op
	}

	public function GetAdjustedStartDate($reservation)
	{
		return NullDate::Instance();
	}

	public function IsUnimportant()
	{
		return true;
	}

	public function Date()
	{
		return NullDate::Instance();
	}
}

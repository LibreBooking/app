<?php

class CalendarMonth implements ICalendarSegment
{
	private $month;
	private $year;
	private $timezone;
	private $firstDay;
	private $lastDay;

	/**
	 * @var array|CalendarWeek[]
	 */
	private $weeks = array();

	public function __construct($month, $year, $timezone)
	{
		$now = Date::Now();
		$this->month = $month;
		$this->year = $year;
		$this->timezone = $timezone;

		$this->firstDay = Date::Create($this->year, $this->month, 1, 0, 0, 0, $this->timezone);
		$this->lastDay = $this->firstDay->AddMonths(1);

		$daysInMonth = $this->lastDay->AddDays(-1)->Day();

		$weeks = floor(($daysInMonth + $this->firstDay->Weekday()-1) / 7);

		for ($week = 0; $week <= $weeks; $week++)
		{
			$this->weeks[$week] = new CalendarWeek($timezone);
		}

		for ($dayOffset = 0; $dayOffset < $daysInMonth; $dayOffset++)
		{
			$currentDay = $this->firstDay->AddDays($dayOffset);
			$currentWeek = $this->GetWeekNumber($currentDay);
			$calendarDay = new CalendarDay($currentDay);

			if ($currentDay->DateEquals($now))
			{
				$calendarDay->Highlight();
			}

			$this->weeks[$currentWeek]->AddDay($calendarDay);
		}
	}

	public function Weeks()
	{
		return $this->weeks;
	}

	public function FirstDay()
	{
		return $this->firstDay;
	}

	public function LastDay()
	{
		return $this->lastDay;
	}

	/**
	 * @param $reservations array|ReservationItemView[]
	 * @return void
	 */
	public function AddReservations($reservations)
	{
		/** @var $reservation ReservationItemView */
		foreach ($reservations as $reservation)
		{
			/** @var $week CalendarWeek */
			foreach ($this->Weeks() as $week)
			{
				$week->AddReservation(CalendarReservation::FromView($reservation, $this->timezone));
			}
		}
	}

	/**
	 * @param Date $day
	 * @return int
	 */
	private function GetWeekNumber(Date $day)
	{
		$firstWeekday = $this->firstDay->Weekday();

		$week = floor($day->Day()/7);

		if ($day->Day()%7==0)
		{
			$week = $day->Day()/7;
		}
		else
		{
			if ($day->Weekday() < $firstWeekday)
			{
				$week++;
			}
		}

		return intval($week);
	}


}

?>
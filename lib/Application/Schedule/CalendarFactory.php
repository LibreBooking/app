<?php

class CalendarTypes
{
	const Month = 'month';
	const Week = 'week';
	const Day = 'day';
}

interface ICalendarFactory
{
	/**
	 * @abstract
	 * @param $year int
	 * @param $month int
	 * @param $timezone string timezone of dates in calendar
	 * @return CalendarMonth
	 */
	public function GetMonth($year, $month, $timezone);

	/**
	 * @abstract
	 * @param $type
	 * @param $year
	 * @param $month
	 * @param $day
	 * @param $timezone
	 * @return ICalendarSegment
	 */
	public function Create($type, $year, $month, $day, $timezone);
}

class CalendarFactory implements ICalendarFactory
{
	/**
	 * @param $year int
	 * @param $month int
	 * @param $timezone string timezone of dates in calendar
	 * @return CalendarMonth
	 */
	public function GetMonth($year, $month, $timezone)
	{
		return new CalendarMonth($month, $year, $timezone);
	}

	public function Create($type, $year, $month, $day, $timezone)
	{
		if ($type == CalendarTypes::Day)
		{
			return null;
		}

		if ($type == CalendarTypes::Week)
		{
			return null;
		}

		return $this->GetMonth($year, $month, $timezone);
	}
}

?>
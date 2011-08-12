<?php

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
}

?>
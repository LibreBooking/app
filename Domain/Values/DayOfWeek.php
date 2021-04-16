<?php

class DayOfWeek
{
	const SUNDAY = 0;
	const MONDAY = 1;
	const TUESDAY = 2;
	const WEDNESDAY = 3;
	const THURSDAY = 4;
	const FRIDAY = 5;
	const SATURDAY = 6;

	const NumberOfDays = 7;

	/**
	 * @return array|int[]|DayOfWeek
	 */
	public static function Days()
	{
		return range(self::SUNDAY, self::SATURDAY);
	}
}

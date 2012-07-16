<?php
/**
Copyright 2012 Nick Korbel

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

class Report_Range
{
	const DATE_RANGE = 'DATE_RANGE';
	const ALL_TIME = 'ALL_TIME';

	/**
	 * @var Report_Range|string
	 */
	private $range;

	/**
	 * @var Date
	 */
	private $start;

	/**
	 * @var Date
	 */
	private $end;

	/**
	 * @param $range string|Report_Range
	 * @param Date $start
	 * @param Date $end
	 */
	public function __construct($range, Date $start, Date $end)
	{
		$this->range = $range;
		$this->start = $start;
		$this->end = $end;
	}

	public function Add(ReportCommandBuilder $builder)
	{
		if ($this->range == self::DATE_RANGE)
		{
			$builder->Within($this->start, $this->end);
		}
	}

	/**
	 * @return Date
	 */
	public function Start()
	{
		return $this->start;
	}

	/**
	 * @return Date
	 */
	public function End()
	{
		return $this->end;
	}

	public function __toString()
	{
		return $this->range;
	}

	/**
	 * @static
	 * @return Report_Range
	 */
	public static function AllTime()
	{
		return new Report_Range(Report_Range::ALL_TIME, Date::Min(), Date::Max());
	}
}


?>
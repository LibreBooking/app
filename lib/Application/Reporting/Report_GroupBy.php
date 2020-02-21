<?php
/**
Copyright 2012-2020 Nick Korbel

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

class Report_GroupBy
{
	const NONE = 'NONE';
	const RESOURCE = 'RESOURCE';
	const SCHEDULE = 'SCHEDULE';
	const USER = 'USER';
	const GROUP = 'GROUP';

	/**
	 * @var Report_GroupBy|string
	 */
	private $groupBy;

	/**
	 * @param $groupBy string|Report_GroupBy
	 */
	public function __construct($groupBy)
	{
		$this->groupBy = $groupBy;
	}

	public function Add(ReportCommandBuilder $builder)
	{
		if ($this->groupBy == self::GROUP)
		{
			$builder->GroupByGroup();
		}
		if ($this->groupBy == self::SCHEDULE)
		{
			$builder->GroupBySchedule();
		}
		if ($this->groupBy == self::USER)
		{
			$builder->GroupByUser();
		}
		if ($this->groupBy == self::RESOURCE)
		{
			$builder->GroupByResource();
		}
	}

	public function __toString()
	{
		return $this->groupBy;
	}
}

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

class Report_ResultSelection
{
	const COUNT = 'COUNT';
	const TIME = 'TIME';
	const FULL_LIST = 'LIST';
	const UTILIZATION = 'UTILIZATION';

	/**
	 * @var Report_ResultSelection|string
	 */
	private $selection;

	/**
	 * @param $selection string|Report_ResultSelection
	 */
	public function __construct($selection)
	{
		$this->selection = $selection;
	}

	public function Add(ReportCommandBuilder $builder)
	{
		if ($this->selection == self::FULL_LIST)
		{
			$builder->SelectFullList();
		}
		if ($this->selection == self::COUNT)
		{
			$builder->SelectCount();
		}
		if ($this->selection == self::TIME)
		{
			$builder->SelectTime();
		}
		if ($this->selection == self::UTILIZATION)
        {
            $builder->SelectDuration()->IncludingBlackouts()->OfResources();
        }
	}

	/**
	 * @param $selection string
	 * @return bool
	 */
	public function Equals($selection)
	{
		return $this->selection == $selection;
	}

	public function __toString()
	{
		return $this->selection;
	}
}
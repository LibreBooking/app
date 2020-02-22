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

class Report_Usage
{
	const RESOURCES = 'RESOURCES';
	const ACCESSORIES = 'ACCESSORIES';

	/**
	 * @var Report_Usage|string
	 */
	private $usage;

	/**
	 * @param $usage string|Report_Usage
	 */
	public function __construct($usage)
	{
		$this->usage = $usage;
	}

	public function Add(ReportCommandBuilder $builder)
	{
		if ($this->usage == self::ACCESSORIES)
		{
			$builder->OfAccessories();
		}
		else
		{
			$builder->OfResources();
		}
	}

	public function __toString()
	{
		return $this->usage;
	}
}
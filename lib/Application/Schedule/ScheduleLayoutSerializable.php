<?php
/**
Copyright 2013-2020 Nick Korbel

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

class ScheduleLayoutSerializable
{
	/**
	 * @var array|PeriodSerializable[]
	 */
	public $periods;

	/**
	 * @param array|SchedulePeriod[] $periods
	 */
	public function __construct($periods)
	{
		foreach ($periods as $period)
		{
			$this->periods[] = new PeriodSerializable($period);
		}
	}
}

class PeriodSerializable
{
	public $begin;
	public $beginDate;
	public $end;
	public $endDate;
	public $label;
	public $labelEnd;
	public $isReservable;

	public function __construct(SchedulePeriod $period)
	{
		$this->begin = $period->Begin()->__toString();
		$this->end = $period->End()->__toString();
		$this->beginDate = $period->BeginDate()->__toString();
		$this->endDate = $period->EndDate()->__toString();
		$this->isReservable = $period->IsReservable();
		$this->label = $period->Label();
		$this->labelEnd = $period->LabelEnd();
	}
}

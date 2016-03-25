<?php
/**
 * Copyright 2016 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Domain/Access/namespace.php');

class FakeScheduleLayout implements IScheduleLayout
{
	/**
	 * @var SlotCount
	 */
	public $_SlotCount;

	public function __construct()
	{
		$this->_SlotCount = new SlotCount(1, 2);
	}

	public function Timezone()
	{
		// TODO: Implement Timezone() method.
	}

	/**
	 * @return bool
	 */
	public function UsesDailyLayouts()
	{
		// TODO: Implement UsesDailyLayouts() method.
	}

	/**
	 * @param Date $layoutDate
	 * @param bool $hideBlockedPeriods
	 * @return SchedulePeriod[]|array of SchedulePeriod objects
	 */
	public function GetLayout(Date $layoutDate, $hideBlockedPeriods = false)
	{
		// TODO: Implement GetLayout() method.
	}

	/**
	 * @param Date $date
	 * @return SchedulePeriod|null period which occurs at this datetime. Includes start time, excludes end time. null if no match is found
	 */
	public function GetPeriod(Date $date)
	{
		// TODO: Implement GetPeriod() method.
	}

	/**
	 * @param Date $startDate
	 * @param Date $endDate
	 * @param Date $testDate
	 * @param $scheduleId
	 * @return SlotCount
	 */
	public function GetSlotCount(Date $startDate, Date $endDate, Date $testDate = null, $scheduleId)
	{
		return $this->_SlotCount;
	}
}
<?php
/**
 * Copyright 2017-2019 Nick Korbel
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

    /**
     * @var SchedulePeriod[]
     */
	public $_Layout = array();

    /**
     * @var string
     */
    public $_Timezone;

    public $_UsesDailyLayouts = false;

    /**
     * @var SchedulePeriod[]
     */
    public $_DailyLayout = array();

    public function __construct()
	{
		$this->_SlotCount = new SlotCount(1, 2);
		$this->_Timezone = 'America/Chicago';
	}

	public function Timezone()
	{
		return $this->_Timezone;
	}

	/**
	 * @return bool
	 */
	public function UsesDailyLayouts()
	{
		return $this->_UsesDailyLayouts;
	}

	/**
	 * @param Date $layoutDate
	 * @param bool $hideBlockedPeriods
	 * @return SchedulePeriod[]|array of SchedulePeriod objects
	 */
	public function GetLayout(Date $layoutDate, $hideBlockedPeriods = false)
	{
	    if (!empty($this->_DailyLayout)){
	        return $this->_DailyLayout[$layoutDate->Timestamp()];
        }

		return $this->_Layout;
	}

    /**
     * @param Date $date
     * @param SchedulePeriod[] $layout
     */
	public function _AddDailyLayout(Date $date, $layout)
    {
        $this->_DailyLayout[$date->Timestamp()] = $layout;
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
	 * @return SlotCount
	 * @internal param $scheduleId
	 */
	public function GetSlotCount(Date $startDate, Date $endDate)
	{
		return $this->_SlotCount;
	}

	public function ChangePeakTimes(PeakTimes $peakTimes)
	{
		// TODO: Implement ChangePeakTimes() method.
	}

	public function RemovePeakTimes()
	{
		// TODO: Implement RemovePeakTimes() method.
	}

    /**
     * @return bool
     */
    public function FitsToHours()
    {
        // TODO: Implement FitsToHours() method.
    }

    /**
     * @return bool
     */
    public function UsesCustomLayout()
    {
        // TODO: Implement UsesCustomLayout() method.
    }
}
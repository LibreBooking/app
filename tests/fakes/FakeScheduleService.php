<?php

/**
 * Copyright 2017 Nick Korbel
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

class FakeScheduleService implements IScheduleService
{

    public $_DailyLayout;


    public function __construct()
    {
        $this->_DailyLayout = new FakeDailyLayout();
    }
    /**
     * @param bool $includeInaccessible
     * @param UserSession $session
     * @return Schedule[]
     */
    public function GetAll($includeInaccessible = true, UserSession $session = null)
    {
        // TODO: Implement GetAll() method.
    }

    /**
     * @param int $scheduleId
     * @param ILayoutFactory $layoutFactory factory to use to create the schedule layout
     * @return IScheduleLayout
     */
    public function GetLayout($scheduleId, ILayoutFactory $layoutFactory)
    {
        // TODO: Implement GetLayout() method.
    }

    /**
     * @param int $scheduleId
     * @param ILayoutFactory $layoutFactory
     * @param IReservationListing $reservationListing
     * @return IDailyLayout
     */
    public function GetDailyLayout($scheduleId, ILayoutFactory $layoutFactory, $reservationListing)
    {
       return $this->_DailyLayout;
    }
}
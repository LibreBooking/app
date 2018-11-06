<?php

/**
 * Copyright 2017-2018 Nick Korbel
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

class FakeDailyLayout implements IDailyLayout
{
    public $_Timezone;
    private $_Layouts = array();

    /**
     * @param Date $date
     * @param int $resourceId
     * @return array|IReservationSlot[]
     */
    function GetLayout(Date $date, $resourceId)
    {
       return $this->_Layouts[$date->GetDate()->Timestamp() . $resourceId];
    }

    /**
     * @param Date $date
     * @return bool
     */
    function IsDateReservable(Date $date)
    {
        // TODO: Implement IsDateReservable() method.
    }

    /**
     * @param Date $displayDate
     * @return string[]
     */
    function GetLabels(Date $displayDate)
    {
        // TODO: Implement GetLabels() method.
    }

    /**
     * @param Date $displayDate
     * @return mixed
     */
    function GetPeriods(Date $displayDate)
    {
        // TODO: Implement GetPeriods() method.
    }

    /**
     * @param Date $date
     * @param int $resourceId
     * @return DailyReservationSummary
     */
    function GetSummary(Date $date, $resourceId)
    {
        // TODO: Implement GetSummary() method.
    }

    /**
     * @param Date $date
     * @param int $resourceId
     * @param IReservationSlot[] $reservationSlots
     */
    public function _SetLayout(Date $date, $resourceId, $reservationSlots)
    {
        $this->_Layouts[$date->GetDate()->Timestamp() . $resourceId] = $reservationSlots;
    }

    public function Timezone()
    {
        return $this->_Timezone;
    }
}
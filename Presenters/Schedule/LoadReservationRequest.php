<?php
/**
 * Copyright 2020 Nick Korbel
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


class LoadReservationRequest
{
    /**
     * @var DateRange
     */
    private $dateRange;
    /**
     * @var int
     */
    private $scheduleId;
    /**
     * @var int[]
     */
    private $resourceIds;
    /**
     * @var Date[]
     */
    private $specificDates;

    /**
     * @param DateRange $dateRange
     * @param int $scheduleId
     * @param int[] $resourceIds
     * @param Date[] $specificDates
     */
    public function __construct($dateRange, $scheduleId, $resourceIds, $specificDates)
    {
        $this->dateRange = $dateRange;
        $this->scheduleId = $scheduleId;
        $this->resourceIds = $resourceIds;
        $this->specificDates = $specificDates;
    }

    /**
     * @return DateRange
     */
    public function DateRange()
    {
        return $this->dateRange;
    }

    /**
     * @return int
     */
    public function ScheduleId()
    {
        return $this->scheduleId;
    }

    /**
     * @return int[]
     */
    public function ResourceIds()
    {
        return $this->resourceIds;
    }

    /**
     * @return Date[]
     */
    public function SpecificDates()
    {
        return $this->specificDates;
    }
}

class LoadReservationRequestBuilder
{
    /**
     * @var Date
     */
    private $start;
    /**
     * @var Date
     */
    private $end;
    /**
     * @var int[]
     */
    private $resourceIds = [];
    /**
     * @var int
     */
    private $scheduleId;
    /**
     * @var Date[]
     */
    private $specificDates = [];

    public function WithRange(Date $start, Date $end): LoadReservationRequestBuilder
    {
        $this->start = $start;
        $this->end = $end->AddDays(1);
        return $this;
    }

    /**
     * @param $resourceIds int[]
     * @return LoadReservationRequestBuilder
     */
    public function WithResources($resourceIds): LoadReservationRequestBuilder
    {
        $this->resourceIds = $resourceIds;
        return $this;
    }


    public function WithScheduleId(int $scheduleId): LoadReservationRequestBuilder
    {
        $this->scheduleId = $scheduleId;
        return $this;
    }

    /**
     * @param Date[] $dates
     * @return LoadReservationRequestBuilder
     */
    public function WithSpecificDates($dates): LoadReservationRequestBuilder
    {
        $this->specificDates = $dates;
        return $this;
    }

    public function Build()
    {
        return new LoadReservationRequest(new DateRange($this->start, $this->end), $this->scheduleId, $this->resourceIds, $this->specificDates);
    }
}


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

class ReservationWaitlistRequest
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var int
     */
    private $userId;
    /**
     * @var Date
     */
    private $startDate;
    /**
     * @var Date
     */
    private $endDate;
    /**
     * @var int[]
     */
    private $resourceIds;

    /**
     * @param int $id
     * @param int $userId
     * @param Date $startDate
     * @param Date $endDate
     * @param int[] $resourceIds
     */
    public function __construct($id, $userId, $startDate, $endDate, $resourceIds)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->resourceIds = $resourceIds;
    }

    /**
     * @return int
     */
    public function Id()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function UserId()
    {
        return $this->userId;
    }

    /**
     * @return Date
     */
    public function StartDate()
    {
        return $this->startDate;
    }

    /**
     * @return Date
     */
    public function EndDate()
    {
        return $this->endDate;
    }

    /**
     * @return int[]
     */
    public function ResourceIds()
    {
        return $this->resourceIds;
    }

    /**
     * @param int $userId
     * @param Date $startDate
     * @param Date $endDate
     * @param int[] $resourceIds
     * @return ReservationWaitlistRequest
     */
    public static function Create($userId, $startDate, $endDate, $resourceIds)
    {
        return new ReservationWaitlistRequest(0, $userId, $startDate, $endDate, $resourceIds);
    }

    /**
     * @param int $id
     */
    public function WithId($id)
    {
        $this->id = $id;
    }
}
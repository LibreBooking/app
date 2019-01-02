<?php
/**
 * Copyright 2018-2019 Nick Korbel
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

class ReservationItemViewBuilder
{
    public $reservationId;
    public $startDate;
    public $endDate;
    public $summary;
    public $resourceId;
    public $userId;
    public $firstName;
    public $lastName;
    public $referenceNumber;

    public function __construct()
    {
        $this->reservationId = 1;
        $this->startDate = Date::Now();
        $this->endDate = Date::Now();
        $this->summary = 'summary';
        $this->resourceId = 10;
        $this->userId = 100;
        $this->firstName = 'first';
        $this->lastName = 'last';
        $this->referenceNumber = 'referenceNumber';
    }

    public function WithStartDate(Date $startDate)
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function WithEndDate(Date $endDate)
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * @return ReservationItemView
     */
    public function Build()
    {
        return new ReservationItemView(
            $this->referenceNumber,
            $this->startDate,
            $this->endDate,
            null,
            $this->resourceId,
            $this->reservationId,
            null,
            null,
            $this->summary,
            null,
            $this->firstName,
            $this->lastName,
            $this->userId
        );
    }
}
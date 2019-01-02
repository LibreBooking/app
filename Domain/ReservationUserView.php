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

class ReservationUserView
{
    public $UserId;
    public $FirstName;
    public $LastName;
    public $Email;
    public $LevelId;
    public $FullName;

    public function __construct($userId, $firstName, $lastName, $email, $levelId)
    {
        $this->UserId = $userId;
        $this->FirstName = $firstName;
        $this->LastName = $lastName;
        $this->FullName = $firstName . ' ' . $lastName;
        $this->Email = $email;
        $this->LevelId = $levelId;
    }

    public function IsOwner()
    {
        return $this->LevelId == ReservationUserLevel::OWNER;
    }

    public function __toString()
    {
        return $this->UserId;
    }
}
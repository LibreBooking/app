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

require_once(ROOT_DIR . 'Domain/BookableResource.php');

class ReservationResourceView implements IResource
{
    private $id;
    private $resourceName;
    private $adminGroupId;
    private $scheduleId;
    private $scheduleAdminGroupId;
    private $statusId;
    private $checkinEnabled;
    private $autoReleaseMinutes;
    private $color;

    public function __construct($resourceId, $resourceName, $adminGroupId, $scheduleId, $scheduleAdminGroupId,
                                $statusId = ResourceStatus::AVAILABLE, $enableCheckin, $autoReleaseMinutes)
    {
        $this->id = $resourceId;
        $this->resourceName = $resourceName;
        $this->adminGroupId = $adminGroupId;
        $this->scheduleId = $scheduleId;
        $this->scheduleAdminGroupId = $scheduleAdminGroupId;
        $this->statusId = $statusId;
        $this->checkinEnabled = $enableCheckin;
        $this->autoReleaseMinutes = $autoReleaseMinutes;
    }

    /**
     * @return int
     */
    public function Id()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function Name()
    {
        return $this->resourceName;
    }

    /**
     * @return int|null
     */
    public function GetAdminGroupId()
    {
        return $this->adminGroupId;
    }

    /**
     * alias of GetId()
     * @return int
     */
    public function GetResourceId()
    {
        return $this->Id();
    }

    /**
     * @return int
     */
    public function GetId()
    {
        return $this->Id();
    }

    /**
     * @return string
     */
    public function GetName()
    {
        return $this->Name();
    }

    /**
     * @return int
     */
    public function GetScheduleId()
    {
        return $this->scheduleId;
    }

    /**
     * @return int
     */
    public function GetScheduleAdminGroupId()
    {
        return $this->scheduleAdminGroupId;
    }

    /**
     * @return int
     */
    public function GetStatusId()
    {
        return $this->statusId;
    }

    /**
     * @return bool
     */
    public function IsCheckInEnabled()
    {
        return $this->checkinEnabled;
    }

    /**
     * @return bool
     */
    public function IsAutoReleased()
    {
        return !is_null($this->autoReleaseMinutes);
    }

    /**
     * @return int|null
     */
    public function GetAutoReleaseMinutes()
    {
        return $this->autoReleaseMinutes;
    }

    public function SetColor($color)
    {
        $this->color = $color;
    }

    public function GetColor()
    {
        return $this->color;
    }
}

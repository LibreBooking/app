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

class SchedulePermissionService implements IPermissionService
{
    /**
     * @var IPermissionService
     */
    private $permissionService;

    public function __construct(IPermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * @param IPermissibleResource $resource
     * @param UserSession $user
     * @return bool
     */
    public function CanAccessResource(IPermissibleResource $resource, UserSession $user)
    {
        return $this->permissionService->CanAccessResource($resource, $user);
    }

    /**
     * @param IPermissibleResource $resource
     * @param UserSession $user
     * @return bool
     */
    public function CanBookResource(IPermissibleResource $resource, UserSession $user)
    {
        return $this->permissionService->CanBookResource($resource, $user);
    }

    /**
     * @param IPermissibleResource $resource
     * @param UserSession $user
     * @return bool
     */
    public function CanViewResource(IPermissibleResource $resource, UserSession $user)
    {
        return $this->permissionService->CanViewResource($resource, $user);
    }
}
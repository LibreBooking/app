<?php
/**
Copyright 2013-2020 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

class ResourcePermissionFilter implements IResourceFilter
{
	/**
	 * @var IPermissionService $permissionService
	 */
	private $permissionService;

	/**
	 * @var UserSession $user
	 */
	private $user;

	public function __construct(IPermissionService $permissionService, UserSession $user)
	{
		$this->permissionService = $permissionService;
		$this->user = $user;
	}

	public function ShouldInclude($resource)
	{
		return $this->permissionService->CanAccessResource($resource, $this->user);
	}

	public function CanBook($resource)
	{
		return $this->permissionService->CanBookResource($resource, $this->user);
	}
}
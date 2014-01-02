<?php
/**
Copyright 2012-2014 Nick Korbel

This file is part of Booked SchedulerBooked SchedulereIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later versBooked SchedulerduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
alBooked SchedulercheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/Application/Authorization/PermissionService.php');
require_once(ROOT_DIR . 'lib/Application/Authorization/PermissionServiceFactory.php');

class ViewSchedulePermissionService implements IPermissionService
{
	/**
	 * @param IPermissibleResource $resource
	 * @param UserSession $user
	 * @return bool
	 */
	public function CanAccessResource(IPermissibleResource $resource, UserSession $user)
	{
		return true;
	}
}

class ViewSchedulePermissionServiceFactory implements IPermissionServiceFactory
{
	/**
	 * @return IPermissionService
	 */
	public function GetPermissionService()
	{
		return new ViewSchedulePermissionService();
	}
}

?>
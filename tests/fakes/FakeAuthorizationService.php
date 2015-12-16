<?php
/**
Copyright 2014-2015 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

class FakeAuthorizationService implements IAuthorizationService
{
	public $_IsApplicationAdministrator = false;
	public $_IsResourceAdministrator = false;
	public $_IsGroupAdministrator = false;
	public $_CanReserveForOthers = false;
	public $_CanReserveFor = false;
	public $_CanApproveFor = false;
	public $_CanEditForResource = false;
	public $_CanApproveForResource = false;

	public function __construct()
	{

	}

	/**
	 * @param User $user
	 * @return bool
	 */
	public function IsApplicationAdministrator(User $user)
	{
		return $this->_IsApplicationAdministrator;
	}

	/**
	 * @param User $user
	 * @return bool
	 */
	public function IsResourceAdministrator(User $user)
	{
		return $this->_IsResourceAdministrator;
	}

	/**
	 * @param User $user
	 * @return bool
	 */
	public function IsGroupAdministrator(User $user)
	{
		return $this->_IsGroupAdministrator;
	}

	/**
	 * @param User $user
	 * @return bool
	 */
	public function IsScheduleAdministrator(User $user)
	{
		return $this->_IsGroupAdministrator;
	}

	/**
	 * @param UserSession $reserver user who is requesting access to perform action
	 * @return bool
	 */
	public function CanReserveForOthers(UserSession $reserver)
	{
		return $this->_CanReserveForOthers;
	}

	/**
	 * @param UserSession $reserver user who is requesting access to perform action
	 * @param int $reserveForId user to reserve for
	 * @return bool
	 */
	public function CanReserveFor(UserSession $reserver, $reserveForId)
	{
		return $this->_CanReserveFor;
	}

	/**
	 * @param UserSession $approver user who is requesting access to perform action
	 * @param int $approveForId user to approve for
	 * @return bool
	 */
	public function CanApproveFor(UserSession $approver, $approveForId)
	{
		return $this->_CanApproveFor;
	}

	/**
	 * @param UserSession $user
	 * @param IResource $resource
	 * @return bool
	 */
	public function CanEditForResource(UserSession $user, IResource $resource)
	{
		return $this->_CanEditForResource;
	}

	/**
	 * @param UserSession $user
	 * @param IResource $resource
	 * @return bool
	 */
	public function CanApproveForResource(UserSession $user, IResource $resource)
	{
		return $this->_CanApproveForResource;
	}
}
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

class FakeReservationAuthorization implements IReservationAuthorization
{
	public $_CanChangeUsers = true;
	public $_CanEdit = true;
	public $_CanApprove = true;
	public $_CanViewDetails = true;

	/**
	 * @param UserSession $currentUser
	 * @return bool
	 */
	function CanChangeUsers(UserSession $currentUser)
	{
		return $this->_CanChangeUsers;
	}

	/**
	 * @param ReservationView $reservationView
	 * @param UserSession $currentUser
	 * @return bool
	 */
	function CanEdit(ReservationView $reservationView, UserSession $currentUser)
	{
		return $this->_CanEdit;
	}

	/**
	 * @param ReservationView $reservationView
	 * @param UserSession $currentUser
	 * @return bool
	 */
	function CanApprove(ReservationView $reservationView, UserSession $currentUser)
	{
		return $this->_CanApprove;
	}

	/**
	 * @param ReservationView $reservationView
	 * @param UserSession $currentUser
	 * @return bool
	 */
	function CanViewDetails(ReservationView $reservationView, UserSession $currentUser)
	{
		return $this->_CanViewDetails;
	}
}
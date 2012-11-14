<?php
/**
Copyright 2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/Application/Reservation/PrivacyFilter.php');

class FakePrivacyFilter implements IPrivacyFilter
{
	public $_CanViewUser = true;
	public $_CanViewDetails = true;

	/**
	 * @var UserSession
	 */
	public $_LastViewUserUserSession;

	/**
	 * @var ReservationView
	 */
	public $_LastViewUserReservation;

	/**
	 * @var UserSession
	 */
	public $_LastViewDetailsUserSession;

	/**
	 * @var ReservationView
	 */
	public $_LastViewDetailsReservation;

	public function CanViewUser(UserSession $userSession, $reservationView = null, $ownerId = null)
	{
		$this->_LastViewUserUserSession = $userSession;
		$this->_LastViewUserReservation = $reservationView;

		return $this->_CanViewUser;
	}


	public function CanViewDetails(UserSession $userSession, $reservationView = null, $ownerId = null)
	{
		$this->_LastViewDetailsUserSession = $userSession;
		$this->_LastViewDetailsReservation = $reservationView;

		return $this->_CanViewDetails;
	}
}

?>
<?php
/**
Copyright 2012-2020 Nick Korbel

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

require_once(ROOT_DIR . 'lib/WebService/namespace.php');
require_once(ROOT_DIR . 'WebServices/Responses/ReservationItemResponse.php');

class ReservationsResponse extends RestResponse
{
	/**
	 * @var array|ReservationItemResponse[]
	 */
	public $reservations = array();
	public $startDateTime;
	public $endDateTime;

	/**
	 * @param IRestServer $server
	 * @param array|ReservationItemView[] $reservations
	 * @param IPrivacyFilter $privacyFilter
	 * @param Date $minDate
	 * @param Date $maxDate
	 */
	public function __construct(IRestServer $server, $reservations, IPrivacyFilter $privacyFilter, Date $minDate, Date $maxDate)
	{
		$user = $server->GetSession();
		foreach ($reservations as $reservation)
		{
			$showUser = $privacyFilter->CanViewUser($user, null, $reservation->UserId);
			$showDetails = $privacyFilter->CanViewDetails($user, null, $reservation->UserId);

			$this->reservations[] = new ReservationItemResponse($reservation, $server, $showUser, $showDetails);
			$this->startDateTime = $minDate->ToIso();
			$this->endDateTime = $maxDate->ToIso();
		}
	}

	public static function Example()
	{
		return new ExampleReservationsResponse();
	}
}

class ExampleReservationsResponse extends ReservationsResponse
{
	public function __construct()
	{
		$this->reservations = array(ReservationItemResponse::Example());
	}
}
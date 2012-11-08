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

require_once(ROOT_DIR . 'lib/WebService/namespace.php');

class BookingsWebService
{
	/**
	 * @var IRestServer
	 */
	private $server;

	/**
	 * @var IReservationViewRepository
	 */
	private $reservationViewRepository;

	public function __construct(IRestServer $server, IReservationViewRepository $reservationViewRepository)
	{
		$this->server = $server;
		$this->reservationViewRepository = $reservationViewRepository;
	}

	/**
	 * @name GetBookings
	 * @description Gets a list of bookings for the specified parameters.
	 * Optional query string parameters: userId, resourceId, scheduleId, startDateTime, endDateTime.
	 * If no query string parameters are provided, the current user will be used.
	 * If no dates are provided, reservations for the next two weeks will be returned.
	 * If dates do not include the timezone offset, the timezone of the authenticated user will be assumed.
	 * @response BookingsResponse
	 * @return void
	 */
	public function GetBookings()
	{
		$startDate = $this->GetStartDate();
		$endDate = $this->GetEndDate();
		$userId = $this->GetUserId();
		$resourceId = $this->GetResourceId();
		$scheduleId = $this->GetScheduleId();

		if (!$this->FilterProvided($userId, $resourceId, $scheduleId))
		{
			$userId = $this->server->GetSession()->UserId;
		}

		Log::Debug('GetBookings called. userId=%s, startDate=%s, endDate=%s', $userId, $startDate, $endDate);

		$reservations = $this->reservationViewRepository->GetReservationList($startDate, $endDate, $userId, null,
																			 $scheduleId, $resourceId);
		$this->server->WriteResponse(new BookingsResponse($reservations));
	}

	/**
	 * @param int|null $userId
	 * @param int|null $resourceId
	 * @param int|null $scheduleId
	 * @return bool
	 */
	public function FilterProvided($userId, $resourceId, $scheduleId)
	{
		return !empty($userId) || !empty($resourceId) || !empty($scheduleId);
	}

	/**
	 * @return Date
	 */
	private function GetStartDate()
	{
		return $this->GetBaseDate(WebServiceQueryStringKeys::START_DATE_TIME);
	}

	/**
	 * @return Date
	 */
	private function GetEndDate()
	{
		return $this->GetBaseDate(WebServiceQueryStringKeys::END_DATE_TIME)->AddDays(14);
	}

	/**
	 * @param string $queryStringKey
	 * @return Date
	 */
	private function GetBaseDate($queryStringKey)
	{
		$dateQueryString = $this->server->GetQueryString($queryStringKey);
		if (empty($dateQueryString))
		{
			return Date::Now();
		}

		if (StringHelper::Contains($dateQueryString, 'T'))
		{
			return Date::ParseExact($dateQueryString);
		}

		return Date::Parse($dateQueryString, $this->server->GetSession()->Timezone);
	}

	/**
	 * @return int|null
	 */
	private function GetUserId()
	{
		$userIdQueryString = $this->server->GetQueryString(WebServiceQueryStringKeys::USER_ID);
		if (empty($userIdQueryString))
		{
			return null;
		}

		return $userIdQueryString;
	}

	/**
	 * @return int|null
	 */
	private function GetResourceId()
	{
		return $this->server->GetQueryString(WebServiceQueryStringKeys::RESOURCE_ID);
	}

	/**
	 * @return int|null
	 */
	private function GetScheduleId()
	{
		return $this->server->GetQueryString(WebServiceQueryStringKeys::SCHEDULE_ID);
	}
}

class BookingsResponse extends RestResponse
{
	/**
	 * @var array|ReservationItemResponse[]
	 */
	public $Reservations = array();

	/**
	 * @param array|ReservationItemView[] $reservations
	 * @param IRestServer $server
	 * @return void
	 */
	public function AddReservations($reservations, IRestServer $server)
	{
		foreach ($reservations as $reservation)
		{
			$this->Reservations[] = new ReservationItemResponse($reservation, $server);
		}
	}
}

class ReservationItemResponse extends RestResponse
{
	public $ReferenceNumber;
	public $StartDate;
	public $EndDate;
	public $FirstName;
	public $LastName;
	public $ResourceName;
	public $Title;
	public $Description;
	public $RequiresApproval;
	public $IsRecurring;
	public $ScheduleId;

	public function __construct(ReservationItemView $reservationItemView, IRestServer $server)
	{
		$this->ReferenceNumber = $reservationItemView->ReferenceNumber;
		$this->StartDate = $reservationItemView->StartDate->ToIso();
		$this->EndDate = $reservationItemView->EndDate->ToIso();
		$this->FirstName = $reservationItemView->FirstName;
		$this->LastName = $reservationItemView->LastName;
		$this->ResourceName = $reservationItemView->ResourceName;
		$this->Title = $reservationItemView->Title;
		$this->Description = $reservationItemView->Description;
		$this->RequiresApproval = $reservationItemView->RequiresApproval;
		$this->IsRecurring = $reservationItemView->IsRecurring;

		$this->ScheduleId = $reservationItemView->ScheduleId;
		$this->UserId = $reservationItemView->UserId;
		$this->ResourceId = $reservationItemView->ResourceId;

		// add services for resource, user, schedule
		$this->AddService($server, WebServices::GetResource, array($reservationItemView->ResourceId));

	}
}

?>
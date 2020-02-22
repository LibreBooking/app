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
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'WebServices/Responses/ReservationsResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/ReservationResponse.php');

class ReservationsWebService
{
	/**
	 * @var IRestServer
	 */
	private $server;

	/**
	 * @var IReservationViewRepository
	 */
	private $reservationViewRepository;

	/**
	 * @var IPrivacyFilter
	 */
	private $privacyFilter;

	/**
	 * @var IAttributeService
	 */
	private $attributeService;

	public function __construct(IRestServer $server,
								IReservationViewRepository $reservationViewRepository,
								IPrivacyFilter $privacyFilter,
								IAttributeService $attributeService)
	{
		$this->server = $server;
		$this->reservationViewRepository = $reservationViewRepository;
		$this->attributeService = $attributeService;
		$this->privacyFilter = $privacyFilter;
	}

	/**
	 * @name GetReservations
	 * @description Gets a list of reservations for the specified parameters.
	 * Optional query string parameters: userId, resourceId, scheduleId, startDateTime, endDateTime.
	 * If no dates are provided, reservations for the next two weeks will be returned.
	 * If dates do not include the timezone offset, the timezone of the authenticated user will be assumed.
	 * @response ReservationsResponse
	 * @return void
	 */
	public function GetReservations()
	{
		$startDate = $this->GetStartDate();
		$endDate = $this->GetEndDate();
		$userId = $this->GetUserId();
		$resourceId = $this->GetResourceId();
		$scheduleId = $this->GetScheduleId();

		Log::Debug('GetReservations called. userId=%s, startDate=%s, endDate=%s', $userId, $startDate, $endDate);

		$reservations = $this->reservationViewRepository->GetReservations($startDate, $endDate, $userId, null,
																			 $scheduleId, $resourceId);

		$response = new ReservationsResponse($this->server, $reservations, $this->privacyFilter, $startDate, $endDate);
		$this->server->WriteResponse($response);
	}

	/**
	 * @name GetReservation
	 * @param string $referenceNumber
	 * @description Loads a specific reservation by reference number
	 * @response ReservationResponse
	 * @return void
	 */
	public function GetReservation($referenceNumber)
	{
		Log::Debug('GetReservation called. $referenceNumber=%s', $referenceNumber);

		$reservation = $this->reservationViewRepository->GetReservationForEditing($referenceNumber);

		if (!empty($reservation->ReferenceNumber))
		{
			$attributes = $this->attributeService->GetByCategory(CustomAttributeCategory::RESERVATION);
			$response = new ReservationResponse($this->server, $reservation, $this->privacyFilter, $attributes);
			$this->server->WriteResponse($response);
		}
		else
		{
			$this->server->WriteResponse($response = RestResponse::NotFound(), RestResponse::NOT_FOUND_CODE);
		}
	}

	/**
	 * @param int|null $userId
	 * @param int|null $resourceId
	 * @param int|null $scheduleId
	 * @return bool
	 */
	private function FilterProvided($userId, $resourceId, $scheduleId)
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
		return $this->GetBaseDate(WebServiceQueryStringKeys::END_DATE_TIME, 14);
	}

	/**
	 * @param string $queryStringKey
	 * @return Date
	 */
	private function GetBaseDate($queryStringKey, $defaultNumberOfDays = 0)
	{
		$dateQueryString = $this->server->GetQueryString($queryStringKey);
		if (empty($dateQueryString))
		{
			return Date::Now()->AddDays($defaultNumberOfDays);
		}

		return WebServiceDate::GetDate($dateQueryString, $this->server->GetSession());
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
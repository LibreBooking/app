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
require_once(ROOT_DIR . 'WebServices/Controllers/ReservationSaveController.php');
require_once(ROOT_DIR . 'WebServices/Responses/ReservationCreatedResponse.php');
require_once(ROOT_DIR . 'WebServices/Requests/ReservationRequest.php');
require_once(ROOT_DIR . 'Presenters/Reservation/ReservationSavePresenter.php');
require_once(ROOT_DIR . 'Pages/Ajax/ReservationSavePage.php');

class ReservationWriteWebService
{
	/**
	 * @var IRestServer
	 */
	private $server;

	/**
	 * @var IReservationSaveController
	 */
	private $controller;

	public function __construct(IRestServer $server, IReservationSaveController $controller)
	{
		$this->server = $server;
		$this->controller = $controller;
	}

	/**
	 * @name CreateReservation
	 * @description Creates a new reservation
	 * @request ReservationRequest
	 * @response ReservationCreatedResponse
	 * @return void
	 */
	public function Create()
	{
		/** @var $request ReservationRequest */
		$request = $this->server->GetRequest();

		Log::Debug('ReservationWriteWebService.Create() User=%s, Request=%s', $this->server->GetSession()->UserId,
				   json_encode($request));

		$result = $this->controller->Create($request, $this->server->GetSession());

		if ($result->WasSuccessful())
		{
			Log::Debug('ReservationWriteWebService.Create() - Reservation Created. ReferenceNumber=%s',
					   $result->CreatedReferenceNumber());

			$this->server->WriteResponse(new ReservationCreatedResponse($this->server, $result->CreatedReferenceNumber()),
										 RestResponse::CREATED_CODE);
		}
		else
		{
			Log::Debug('ReservationWriteWebService.Create() - Reservation Failed.');

			$this->server->WriteResponse(new FailedResponse($this->server, $result->Errors()),
										 RestResponse::BAD_REQUEST_CODE);
		}
	}

	/**
	 * @name UpdateReservation
	 * @description Updates an existing reservation.
	 * Pass an optional updateScope query string parameter to restrict changes. Possible values for updateScope are this|full|future
	 * @request ReservationRequest
	 * @response ReservationUpdatedResponse
	 * @param string $referenceNumber
	 * @return void
	 */
	public function Update($referenceNumber)
	{
		/** @var $request ReservationRequest */
		$request = $this->server->GetRequest();

		Log::Debug('ReservationWriteWebService.Update() User=%s, ReferenceNumber=%s, Request=%s', $referenceNumber, $this->server->GetSession()->UserId,
				   json_encode($request));

		$updateScope = $this->server->GetQueryString(WebServiceQueryStringKeys::UPDATE_SCOPE);
		$result = $this->controller->Update($request, $this->server->GetSession(), $referenceNumber, $updateScope);

		if ($result->WasSuccessful())
		{
			Log::Debug('ReservationWriteWebService.Update() - Reservation Updated. ReferenceNumber=%s',
					   $result->CreatedReferenceNumber());

			$this->server->WriteResponse(new ReservationUpdatedResponse($this->server, $result->CreatedReferenceNumber()),
										 RestResponse::OK_CODE);
		}
		else
		{
			Log::Debug('ReservationWriteWebService.Update() - Reservation Failed.');

			$this->server->WriteResponse(new FailedResponse($this->server, $result->Errors()),
										 RestResponse::BAD_REQUEST_CODE);
		}
	}

	/**
	 * @name DeleteReservation
	 * @description Deletes an existing reservation.
	 * Pass an optional updateScope query string parameter to restrict changes. Possible values for updateScope are this|full|future
	 * @response DeletedResponse
	 * @param string $referenceNumber
	 * @return void
	 */
	public function Delete($referenceNumber)
	{
		Log::Debug('ReservationWriteWebService.Delete() User=%s, ReferenceNumber=%s, Request=%s', $referenceNumber, $this->server->GetSession()->UserId);

		$updateScope = $this->server->GetQueryString(WebServiceQueryStringKeys::UPDATE_SCOPE);
		$result = $this->controller->Delete($this->server->GetSession(), $referenceNumber, $updateScope);

		if ($result->WasSuccessful())
		{
			Log::Debug('ReservationWriteWebService.Delete() - Reservation Deleted. ReferenceNumber=%s',
					   $result->CreatedReferenceNumber());

			$this->server->WriteResponse(new DeletedResponse(), RestResponse::OK_CODE);
		}
		else
		{
			Log::Debug('ReservationWriteWebService.Delete() - Reservation Failed.');

			$this->server->WriteResponse(new FailedResponse($this->server, $result->Errors()),
										 RestResponse::BAD_REQUEST_CODE);
		}
	}
}

?>
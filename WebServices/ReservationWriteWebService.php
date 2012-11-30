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

require_once(ROOT_DIR . 'WebServices/Controllers/ReservationSaveController.php');
require_once(ROOT_DIR . 'WebServices/Responses/ReservationCreatedResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/ReservationFailedResponse.php');
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

	public function Create()
	{
		$request = $this->server->GetRequest();

		$result = $this->controller->Create($request, $this->server->GetSession());

		if ($result->WasSuccessful())
		{
			$this->server->WriteResponse(new ReservationCreatedResponse($this->server, $result->CreatedReferenceNumber()),
										 RestResponse::CREATED_CODE);
		}
		else
		{
			$this->server->WriteResponse(new ReservationFailedResponse($this->server, $result->Errors()),
										 RestResponse::BAD_REQUEST_CODE);
		}
	}
}

?>
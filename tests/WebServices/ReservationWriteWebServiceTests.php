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

require_once(ROOT_DIR . 'WebServices/ReservationWriteWebService.php');

class ReservationWriteWebServiceTests extends TestBase
{
	/**
	 * @var ReservationWriteWebService
	 */
	private $service;

	/**
	 * @var FakeRestServer
	 */
	private $server;

	/**
	 * @var PHPUnit_Framework_MockObject_MockObject|IReservationSaveController
	 */
	private $controller;

	public function setup()
	{
		parent::setup();

		$this->server = new FakeRestServer();
		$this->controller = $this->getMock('IReservationSaveController');

		$this->service = new ReservationWriteWebService($this->server, $this->controller);
	}

	public function testCreatesNewReservation()
	{
		$reservationRequest = new ReservationRequest();
		$this->server->SetRequest($reservationRequest);

		$referenceNumber = '12323';
		$controllerResult = new ReservationControllerResult($reservationRequest);
		$controllerResult->SetReferenceNumber($referenceNumber);

		$this->controller->expects($this->once())
				->method('Create')
				->with($this->equalTo($reservationRequest), $this->equalTo($this->server->GetSession()))
				->will($this->returnValue($controllerResult));

		$this->service->Create();

		$expectedResponse = new ReservationCreatedResponse($this->server, $referenceNumber);
		$this->assertEquals($expectedResponse, $this->server->_LastResponse);
		$this->assertEquals(RestResponse::CREATED_CODE, $this->server->_LastResponseCode);
	}

	public function testWhenCreationValidationFails()
	{
		$reservationRequest = new ReservationRequest();
		$this->server->SetRequest($reservationRequest);

		$errors = array('error');
		$controllerResult = new ReservationControllerResult($reservationRequest);
		$controllerResult->SetErrors($errors);

		$this->controller->expects($this->once())
				->method('Create')
				->with($this->equalTo($reservationRequest), $this->equalTo($this->server->GetSession()))
				->will($this->returnValue($controllerResult));

		$this->service->Create();

		$expectedResponse = new ReservationFailedResponse($this->server, $errors);
		$this->assertEquals($expectedResponse, $this->server->_LastResponse);
		$this->assertEquals(RestResponse::BAD_REQUEST_CODE, $this->server->_LastResponseCode);
	}
}

?>
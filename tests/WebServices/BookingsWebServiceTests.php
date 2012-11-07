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

require_once(ROOT_DIR . 'WebServices/BookingsWebService.php');

class BookingsWebServiceTests extends TestBase
{
	/**
	 * @var FakeRestServer
	 */
	private $server;

	/**
	 * @var BookingsWebService
	 */
	private $service;

	/**
	 * @var IReservationViewRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $reservationViewRepository;

	/**
	 * @var WebServiceUserSession
	 */
	private $userSession;

	public function setup()
	{
		parent::setup();

		$this->userSession = new WebServiceUserSession(123);

		$this->server = new FakeRestServer();
		$this->server->SetSession($this->userSession);

		$this->reservationViewRepository = $this->getMock('IReservationViewRepository');

		$this->service = new BookingsWebService($this->server, $this->reservationViewRepository);
	}

	public function testDefaultsToNextTwoWeeksAndCurrentUser()
	{
		$this->server->SetQueryString(WebServiceQueryStringKeys::USER_ID, null);
		$this->server->SetQueryString(WebServiceQueryStringKeys::START_DATE_TIME, null);
		$this->server->SetQueryString(WebServiceQueryStringKeys::END_DATE_TIME, null);

		$startDate = Date::Now();
		$endDate = Date::Now()->AddDays(14);
		$userId = $this->userSession->UserId;
		$reservations = array();

		$this->reservationViewRepository->expects($this->once())
					->method('GetReservationList')
					->with($this->equalTo($startDate), $this->equalTo($endDate), $this->equalTo($userId))
					->will($this->returnValue($reservations));

		$this->service->GetBookings();

		$this->assertEquals(new BookingsResponse($reservations), $this->server->_LastResponse);
	}
}

?>
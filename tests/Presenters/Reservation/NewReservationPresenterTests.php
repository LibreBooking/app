<?php
/**
Copyright 2011-2013 Nick Korbel

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

require_once(ROOT_DIR . 'Presenters/Reservation/ReservationPresenter.php');
require_once(ROOT_DIR . 'Pages/ReservationPage.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

class NewReservationPresenterTests extends TestBase
{
	/**
	 * @var UserSession
	 */
	private $_user;

	/**
	 * @var int
	 */
	private $_userId;

	public function setup()
	{
		parent::setup();

		$this->_user = $this->fakeServer->UserSession;
		$this->_userId = $this->_user->UserId;
	}

	public function teardown()
	{
		parent::teardown();
	}

	public function testPageLoadValidatesAllPreconditionsAndGetsReservationInitializerAndInitializes()
	{
		$page = $this->getMock('INewReservationPage');

		$reservationPreconditionService = $this->getMock('INewReservationPreconditionService');
		$reservationPreconditionService->expects($this->once())
			->method('CheckAll')
			->with($this->equalTo($page), $this->equalTo($this->_user));

		$reservationInitializerFactory = $this->getMock('IReservationInitializerFactory');
		$initializer = $this->getMock('IReservationInitializer');

		$reservationInitializerFactory->expects($this->once())
			->method('GetNewInitializer')
			->with($this->equalTo($page))
			->will($this->returnValue($initializer));

		$initializer->expects($this->once())
			->method('Initialize');

		$presenter = new ReservationPresenter($page, $reservationInitializerFactory, $reservationPreconditionService);
		$presenter->PageLoad();
	}
}
?>
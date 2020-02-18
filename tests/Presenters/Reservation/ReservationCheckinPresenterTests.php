<?php
/**
Copyright 2011-2019 Nick Korbel

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

require_once(ROOT_DIR . 'Pages/Ajax/ReservationApprovalPage.php');
require_once(ROOT_DIR . 'Presenters/Reservation/ReservationCheckinPresenter.php');

class ReservationCheckinPresenterTests extends TestBase
{
	/**
	 * @var FakeReservationCheckinPage
	 */
	private $page;

	/**
	 * @var IUpdateReservationPersistenceService|PHPUnit_Framework_MockObject_MockObject
	 */
	private $persistence;

	/**
	 * @var IReservationHandler|PHPUnit_Framework_MockObject_MockObject
	 */
	private $handler;

	/**
	 * @var ReservationCheckinPresenter
	 */
	private $presenter;

	public function setUp(): void
	{
		parent::setup();

		$this->page = new FakeReservationCheckinPage();
		$this->persistence = $this->createMock('IUpdateReservationPersistenceService');
		$this->handler = $this->createMock('IReservationHandler');

		$this->presenter = new ReservationCheckinPresenter($this->page, $this->persistence, $this->handler, $this->fakeUser);
	}

	public function testCheckin()
	{
		$this->page->_ReferenceNumber = 'rn';
		$this->page->_Action = ReservationAction::Checkin;

		$builder = new ExistingReservationSeriesBuilder();
		$reservation = $builder->Build();

		$this->persistence->expects($this->once())
			->method('LoadByReferenceNumber')
			->with($this->equalTo($this->page->_ReferenceNumber))
			->will($this->returnValue($reservation));

		$this->handler->expects($this->once())
			->method('Handle')
			->with($this->equalTo($reservation), $this->equalTo($this->page))
			->will($this->returnValue(true));

		$this->presenter->PageLoad();

		$this->assertEquals(Date::Now(), $reservation->CurrentInstance()->CheckinDate());
		$this->assertTrue(in_array(new InstanceUpdatedEvent($reservation->CurrentInstance(), $reservation), $reservation->GetEvents()));
	}

	public function testCheckout()
	{
		$this->page->_ReferenceNumber = 'rn';
		$this->page->_Action = ReservationAction::Checkout;

		$builder = new ExistingReservationSeriesBuilder();
		$reservation = $builder->Build();

		$this->persistence->expects($this->once())
			->method('LoadByReferenceNumber')
			->with($this->equalTo($this->page->_ReferenceNumber))
			->will($this->returnValue($reservation));

		$this->handler->expects($this->once())
			->method('Handle')
			->with($this->equalTo($reservation), $this->equalTo($this->page))
			->will($this->returnValue(true));

		$this->presenter->PageLoad();

		$this->assertEquals(Date::Now(), $reservation->CurrentInstance()->CheckoutDate());
		$this->assertTrue(in_array(new InstanceUpdatedEvent($reservation->CurrentInstance(), $reservation), $reservation->GetEvents()));
	}
}
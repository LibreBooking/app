<?php
/**
Copyright 2011-2016 Nick Korbel

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
require_once(ROOT_DIR . 'Presenters/Reservation/ReservationApprovalPresenter.php');

class ReservationApprovalPresenterTests extends TestBase
{
	/**
	 * @var IReservationApprovalPage|PHPUnit_Framework_MockObject_MockObject
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
	 * @var IReservationAuthorization|PHPUnit_Framework_MockObject_MockObject
	 */
	private $auth;

	/**
	 * @var ReservationApprovalPresenter
	 */
	private $presenter;

	public function setup()
	{
		parent::setup();

		$this->page = $this->getMock('IReservationApprovalPage');
		$this->persistence = $this->getMock('IUpdateReservationPersistenceService');
		$this->handler = $this->getMock('IReservationHandler');
		$this->auth = $this->getMock('IReservationAuthorization');

		$this->presenter = new ReservationApprovalPresenter($this->page, $this->persistence, $this->handler, $this->auth, $this->fakeUser);
	}

	public function testLoadAndApprovesReservationSendingNotifications()
	{
		$referenceNumber = 'rn';

		$builder = new ExistingReservationSeriesBuilder();
		$reservation = $builder->Build();

		$this->page->expects($this->once())
			->method('GetReferenceNumber')
			->will($this->returnValue($referenceNumber));

		$this->persistence->expects($this->once())
			->method('LoadByReferenceNumber')
			->with($this->equalTo($referenceNumber))
			->will($this->returnValue($reservation));

		$this->handler->expects($this->once())
			->method('Handle')
			->with($this->equalTo($reservation), $this->equalTo($this->page))
			->will($this->returnValue(true));

		$this->auth->expects($this->once())
					->method('CanApprove')
					->with($this->equalTo(new ReservationViewAdapter($reservation)), $this->equalTo($this->fakeUser))
					->will($this->returnValue(true));

		$this->presenter->PageLoad();

		$this->assertTrue(in_array(new SeriesApprovedEvent($reservation), $reservation->GetEvents()));
	}
}

?>
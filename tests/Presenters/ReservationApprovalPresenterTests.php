<?php
/**
Copyright 2011-2012 Nick Korbel

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

require_once(ROOT_DIR . 'Pages/Ajax/ReservationApprovalPage.php');
require_once(ROOT_DIR . 'Presenters/ReservationApprovalPresenter.php');

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
	 * @var ReservationApprovalPresenter
	 */
	private $presenter;

	public function setup()
	{
		parent::setup();

		$this->page = $this->getMock('IReservationApprovalPage');
		$this->persistence = $this->getMock('IUpdateReservationPersistenceService');
		$this->handler = $this->getMock('IReservationHandler');

		$this->presenter = new ReservationApprovalPresenter($this->page, $this->persistence, $this->handler);
	}
	
	public function testLoadAndApprovesReservationSendingNotifications()
	{
		$referenceNumber = 'rn';

		$reservation = $this->getMock('ExistingReservationSeries');
		
		$this->page->expects($this->once())
			->method('GetReferenceNumber')
			->will($this->returnValue($referenceNumber));
		
		$this->persistence->expects($this->once())
			->method('LoadByReferenceNumber')
			->with($this->equalTo($referenceNumber))
			->will($this->returnValue($reservation));

		$reservation->expects($this->once())
				->method('Approve')
				->with($this->equalTo($this->fakeUser));
					
		$this->handler->expects($this->once())
			->method('Handle')
			->with($this->equalTo($reservation), $this->equalTo($this->page))
			->will($this->returnValue(true));
		
		$this->presenter->PageLoad();
	}
}

?>
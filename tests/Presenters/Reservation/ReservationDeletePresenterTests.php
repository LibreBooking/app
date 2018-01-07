<?php
/**
Copyright 2011-2018 Nick Korbel

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

require_once(ROOT_DIR . 'Presenters/Reservation/ReservationDeletePresenter.php');
require_once(ROOT_DIR . 'Pages/Ajax/ReservationDeletePage.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

class ReservationDeletePresenterTests extends TestBase
{
	private $userId;

	/**
	 * @var UserSession
	 */
	private $user;

	/**
	 * @var IReservationDeletePage
	 */
	private $page;

	/**
	 * @var IDeleteReservationPersistenceService
	 */
	private $persistenceService;

	/**
	 * @var IReservationHandler
	 */
	private $handler;

	/**
	 * @var ReservationDeletePresenter
	 */
	private $presenter;

	public function setup()
	{
		parent::setup();

		$this->user = $this->fakeServer->UserSession;
		$this->userId = $this->user->UserId;

		$this->persistenceService = $this->getMock('IDeleteReservationPersistenceService');
		$this->handler = $this->getMock('IReservationHandler');

		$this->page = $this->getMock('IReservationDeletePage');

		$this->presenter = new ReservationDeletePresenter(
								$this->page,
								$this->persistenceService,
								$this->handler,
								$this->user);
	}

	public function teardown()
	{
		parent::teardown();
	}

	public function testLoadsExistingReservationAndDeletesIt()
	{
		$referenceNumber = '109809';
		$seriesUpdateScope = SeriesUpdateScope::ThisInstance;
		$reason = 'reason';

		$expectedSeries = $this->getMock('ExistingReservationSeries');

		$this->page->expects($this->once())
			->method('GetReferenceNumber')
			->will($this->returnValue($referenceNumber));

		$this->page->expects($this->once())
			->method('GetSeriesUpdateScope')
			->will($this->returnValue($seriesUpdateScope));

        $this->page->expects($this->once())
            ->method('GetReason')
            ->will($this->returnValue($reason));

		$this->persistenceService->expects($this->once())
			->method('LoadByReferenceNumber')
			->with($this->equalTo($referenceNumber))
			->will($this->returnValue($expectedSeries));

		$expectedSeries->expects($this->once())
			->method('Delete')
			->with($this->equalTo($this->user), $this->equalTo($reason));

		$expectedSeries->expects($this->once())
			->method('ApplyChangesTo')
			->with($this->equalTo($seriesUpdateScope));

		$existingSeries = $this->presenter->BuildReservation();
	}

	public function testHandlingReservationCreationDelegatesToServicesForValidationAndPersistenceAndNotification()
	{
		$builder = new ExistingReservationSeriesBuilder();
		$series = $builder->Build();
		$instance = new Reservation($series, NullDateRange::Instance());
		$series->WithCurrentInstance($instance);

		$this->handler->expects($this->once())
			->method('Handle')
			->with($this->equalTo($series), $this->equalTo($this->page))
			->will($this->returnValue(true));


		$this->presenter->HandleReservation($series);
	}
}
?>
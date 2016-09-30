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

require_once(ROOT_DIR . 'lib/Application/Admin/namespace.php');

class ManageReservationsServiceTests extends TestBase
{
	/**
	 * @var IReservationViewRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $reservationViewRepository;

	/**
	 * @var IReservationAuthorization|PHPUnit_Framework_MockObject_MockObject
	 */
	private $reservationAuthorization;

	/**
	 * @var IReservationHandler|PHPUnit_Framework_MockObject_MockObject
	 */
	private $reservationHandler;

	/**
	 * @var IUpdateReservationPersistenceService|PHPUnit_Framework_MockObject_MockObject
	 */
	private $persistenceService;

	/**
	 * @var ManageReservationsService
	 */
	private $service;

	public function setup()
	{
		parent::setup();

		$this->reservationViewRepository = $this->getMock('IReservationViewRepository');
		$this->reservationAuthorization = $this->getMock('IReservationAuthorization');
		$this->reservationHandler = $this->getMock('IReservationHandler');
		$this->persistenceService = $this->getMock('IUpdateReservationPersistenceService');

		$this->service = new ManageReservationsService($this->reservationViewRepository, $this->reservationAuthorization, $this->reservationHandler, $this->persistenceService);
	}

	public function testLoadsFilteredResultsAndChecksAuthorizationAgainstPendingReservations()
	{
		$pageNumber = 1;
		$pageSize = 40;

		$filter = new ReservationFilter();

		$data = new PageableData();
		$this->reservationViewRepository->expects($this->once())
				->method('GetList')
				->with($pageNumber, $pageSize, null, null, $filter->GetFilter())
				->will($this->returnValue($data));

		$actualData = $this->service->LoadFiltered($pageNumber, $pageSize, null, null, $filter, $this->fakeUser);

		$this->assertEquals($data, $actualData);
	}

	public function testLoadsReservationIfTheUserCanEdit()
	{
		$reservation = new ReservationView();
		$user = $this->fakeUser;
		$referenceNumber = 'rn';

		$this->reservationViewRepository->expects($this->once())
					->method('GetReservationForEditing')
					->with($this->equalTo($referenceNumber))
					->will($this->returnValue($reservation));

		$this->reservationAuthorization->expects($this->once())
					->method('CanEdit')
					->with($this->equalTo($reservation), $this->equalTo($user))
					->will($this->returnValue(true));

		$res = $this->service->LoadByReferenceNumber($referenceNumber, $user);

		$this->assertEquals($reservation, $res);
	}

	public function testUpdatesReservationAttributeIfTheUserCanEdit()
	{
		$referenceNumber = 'rn';
		$id = 111;
		$value = 'new attribute value';

		$user = $this->fakeUser;

		$resultCollector = new ManageReservationsUpdateAttributeResultCollector();

		$reservation = new ExistingReservationSeries();
		$reservation->UpdateBookedBy($user);
		$reservation->AddAttributeValue(new AttributeValue($id, $value));

		$this->persistenceService->expects($this->once())
					->method('LoadByReferenceNumber')
					->with($this->equalTo($referenceNumber))
					->will($this->returnValue($reservation));

		$this->reservationHandler->expects($this->once())
					->method('Handle')
					->with($this->equalTo($reservation), $this->equalTo($resultCollector));

		$result = $this->service->UpdateAttribute($referenceNumber, $id, $value, $user);
	}
}
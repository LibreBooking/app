<?php
/**
Copyright 2011-2014 Nick Korbel

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
	 * @var ManageReservationsService
	 */
	private $service;

	public function setup()
	{
		parent::setup();

		$this->reservationViewRepository = $this->getMock('IReservationViewRepository');

		$this->service = new ManageReservationsService($this->reservationViewRepository);
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

		$actualData = $this->service->LoadFiltered($pageNumber, $pageSize, $filter, $this->fakeUser);

		$this->assertEquals($data, $actualData);
	}
}
?>
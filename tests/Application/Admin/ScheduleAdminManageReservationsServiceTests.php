<?php
/**
Copyright 2011-2013 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Application/Admin/namespace.php');

class ScheduleAdminManageReservationsServiceTests extends TestBase
{
	/**
	 * @var IReservationViewRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $reservationViewRepository;
	/**
	 * @var IUserRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $userRepository;

	/**
	 * @var ManageReservationsService
	 */
	private $service;
	
	public function setup()
	{
		parent::setup();

		$this->reservationViewRepository = $this->getMock('IReservationViewRepository');
		$this->userRepository = $this->getMock('IUserRepository');

		$this->service = new ScheduleAdminManageReservationsService($this->reservationViewRepository, $this->userRepository);
	}

	public function testLoadsFilteredResultsAndChecksAuthorizationAgainstPendingReservations()
	{
		$pageNumber = 1;
		$pageSize = 40;

		$groups = array(
			new UserGroup(1, '1'),
			new UserGroup(5, '5'),
			new UserGroup(9, '9'),
			new UserGroup(22, '22'),
		);
		$myGroups = array(1, 5, 9, 22);
		
		$this->userRepository->expects($this->once())
					->method('LoadGroups')
					->with($this->equalTo($this->fakeUser->UserId), $this->equalTo(RoleLevel::SCHEDULE_ADMIN))
					->will($this->returnValue($groups));

		$filter = new ReservationFilter();
		$expectedFilter = $filter->GetFilter();
		$expectedFilter->_And(new SqlFilterIn(new SqlFilterColumn(TableNames::SCHEDULES, ColumnNames::SCHEDULE_ADMIN_GROUP_ID), $myGroups));
		
		$data = new PageableData();
		$this->reservationViewRepository->expects($this->once())
				->method('GetList')
				->with($pageNumber, $pageSize, null, null, $expectedFilter)
				->will($this->returnValue($data));

		$actualData = $this->service->LoadFiltered($pageNumber, $pageSize, $filter, $this->fakeUser);
		
		$this->assertEquals($data, $actualData);
	}
}
?>
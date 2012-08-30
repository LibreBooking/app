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

require_once(ROOT_DIR . 'lib/Application/Reservation/ManageBlackoutsService.php');

class BlackoutsServiceTests extends TestBase
{
	/**
	 * @var ManageBlackoutsService
	 */
	private $service;

	/**
	 * @var IReservationViewRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $reservationViewRepository;

	/**
	 * @var IUserRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $userRepository;

	/**
	 * @var IReservationConflictResolution|PHPUnit_Framework_MockObject_MockObject
	 */
	private $conflictHandler;

	/**
	 * @var IBlackoutRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $blackoutRepository;

	public function setup()
	{
		parent::setup();

		$this->reservationViewRepository = $this->getMock('IReservationViewRepository');
		$this->conflictHandler = $this->getMock('IReservationConflictResolution');
		$this->blackoutRepository = $this->getMock('IBlackoutRepository');
		$this->userRepository = $this->getMock('IUserRepository');

		$this->service = new ManageBlackoutsService($this->reservationViewRepository, $this->blackoutRepository, $this->userRepository);
	}

	public function testCreatesBlackoutForEachResourceWhenNoConflicts()
	{
		$userId = $this->fakeUser->UserId;
		$start = Date::Parse('2011-01-01 01:01:01');
		$end = Date::Parse('2011-02-02 02:02:02');
		$date = new DateRange($start, $end);
		$resourceIds = array(1, 2, 3);
		$title = 'title';

		$blackoutBefore = new TestBlackoutItemView(1, Date::Parse('2010-01-01'), $start, 3);
		$blackoutAfter = new TestBlackoutItemView(2, $end, Date::Parse('2012-01-01'), 1);
		$blackoutDuring = new TestBlackoutItemView(3, $start, $end, 4);
		$this->reservationViewRepository->expects($this->exactly(3))
				->method('GetBlackoutsWithin')
				->with($this->equalTo($date))
				->will($this->returnValue(array($blackoutBefore, $blackoutAfter, $blackoutDuring)));

		$reservationBefore = new TestReservationItemView(1, Date::Parse('2010-01-01'), $start, 1);
		$reservationAfter = new TestReservationItemView(2, $end, Date::Parse('2012-01-01'), 2);

		$this->reservationViewRepository->expects($this->at(3))
				->method('GetReservationList')
				->with($this->equalTo($start), $this->equalTo($end), $this->isNull(), $this->isNull(), $this->isNull(), $this->equalTo(1))
				->will($this->returnValue(array($reservationBefore)));
		$this->reservationViewRepository->expects($this->at(4))
				->method('GetReservationList')
				->with($this->equalTo($start), $this->equalTo($end), $this->isNull(), $this->isNull(), $this->isNull(), $this->equalTo(2))
				->will($this->returnValue(array()));
		$this->reservationViewRepository->expects($this->at(5))
				->method('GetReservationList')
				->with($this->equalTo($start), $this->equalTo($end), $this->isNull(), $this->isNull(), $this->isNull(), $this->equalTo(3))
				->will($this->returnValue(array($reservationAfter)));

		$blackout1 = Blackout::Create($userId, $resourceIds[0], $title, $date);
		$blackout2 = Blackout::Create($userId, $resourceIds[1], $title, $date);
		$blackout3 = Blackout::Create($userId, $resourceIds[2], $title, $date);

		$this->blackoutRepository->expects($this->at(0))
				->method('Add')
				->with($this->equalTo($blackout1));

		$this->blackoutRepository->expects($this->at(1))
				->method('Add')
				->with($this->equalTo($blackout2));

		$this->blackoutRepository->expects($this->at(2))
				->method('Add')
				->with($this->equalTo($blackout3));

		$result = $this->service->Add($date, $resourceIds, $title, $this->conflictHandler, new RepeatNone());

		$this->assertTrue($result->WasSuccessful());
	}

	public function testDoesNotAddAnyBlackoutsIfThereAreConflictingBlackoutTimes()
	{
		$start = Date::Parse('2011-01-01 01:01:01');
		$end = Date::Parse('2011-02-02 02:02:02');
		$date = new DateRange($start, $end);
		$resourceIds = array(2, 3);
		$title = 'title';

		$blackoutDuring = new TestBlackoutItemView(1, $start, $end, 3);
		$this->reservationViewRepository->expects($this->atLeastOnce())
				->method('GetBlackoutsWithin')
				->with($this->anything())
				->will($this->returnValue(array($blackoutDuring)));

		$this->blackoutRepository->expects($this->never())
				->method('Add');

		$result = $this->service->Add($date, $resourceIds, $title, $this->conflictHandler, new RepeatNone());

		$this->assertFalse($result->WasSuccessful());
	}

	public function testConflictHandlerActsOnEachConflictingReservationAndSavesBlackout()
	{
		$userId = $this->fakeUser->UserId;
		$start = Date::Parse('2011-01-01 01:01:01');
		$end = Date::Parse('2011-02-02 02:02:02');
		$date = new DateRange($start, $end);
		$resourceId = 2;
		$resourceIds = array($resourceId);
		$title = 'title';

		$this->reservationViewRepository->expects($this->once())
				->method('GetBlackoutsWithin')
				->with($this->equalTo($date))
				->will($this->returnValue(array()));

		$reservation1 = new TestReservationItemView(1, $start, $end, 2);
		$reservation2 = new TestReservationItemView(2, $start, $end, 2);
		$this->reservationViewRepository->expects($this->once())
				->method('GetReservationList')
				->with($this->equalTo($start), $this->equalTo($end), $this->isNull(), $this->isNull(), $this->isNull(), $this->equalTo($resourceId))
				->will($this->returnValue(array($reservation1, $reservation2)));

		$this->conflictHandler->expects($this->at(0))
				->method('Handle')
				->with($this->equalTo($reservation1))
				->will($this->returnValue(true));

		$this->conflictHandler->expects($this->at(1))
				->method('Handle')
				->with($this->equalTo($reservation2))
				->will($this->returnValue(true));

		$this->blackoutRepository->expects($this->once())
				->method('Add')
				->with($this->equalTo(Blackout::Create($userId, 2, $title, $date)));

		$result = $this->service->Add($date, $resourceIds, $title, $this->conflictHandler, new RepeatNone());

		$this->assertTrue($result->WasSuccessful());
	}

	public function testConflictHandlerReportsConflictingReservationAndDoesNotSaveBlackout()
	{
		$start = Date::Parse('2011-01-01 01:01:01');
		$end = Date::Parse('2011-02-02 02:02:02');
		$date = new DateRange($start, $end);
		$resourceId = 2;
		$resourceIds = array($resourceId);
		$title = 'title';

		$this->reservationViewRepository->expects($this->once())
				->method('GetBlackoutsWithin')
				->with($this->equalTo($date))
				->will($this->returnValue(array()));

		$reservation1 = new TestReservationItemView(1, $start, $end, 2);
		$reservation2 = new TestReservationItemView(2, $start, $end, 2);
		$this->reservationViewRepository->expects($this->once())
				->method('GetReservationList')
				->with($this->equalTo($start), $this->equalTo($end), $this->isNull(), $this->isNull(), $this->isNull(), $this->equalTo($resourceId))
				->will($this->returnValue(array($reservation1, $reservation2)));

		$this->conflictHandler->expects($this->at(0))
				->method('Handle')
				->with($this->equalTo($reservation1))
				->will($this->returnValue(false));

		$this->conflictHandler->expects($this->at(1))
				->method('Handle')
				->with($this->equalTo($reservation2))
				->will($this->returnValue(false));

		$this->blackoutRepository->expects($this->never())
				->method('Add');

		$result = $this->service->Add($date, $resourceIds, $title, $this->conflictHandler, new RepeatNone());

		$this->assertFalse($result->WasSuccessful());
	}

	public function testChecksAndCreatesForEachRecurringDate()
	{
		$userId = $this->fakeUser->UserId;
		$start = Date::Parse('2011-01-01 01:01:01');
		$end = Date::Parse('2011-01-01 02:02:02');
		$range = new DateRange($start, $end);
		$resourceId = 1;
		$resourceIds = array($resourceId);
		$title = 'title';
		$repeatEnd = $start->AddDays(3);

		$repeatDaily = new RepeatDaily(1, $repeatEnd);
		$repeatDates = $repeatDaily->GetDates($range);

		/** @var $allDates DateRange[] */
		$allDates = array_merge(array($range), $repeatDates);

		for ($i = 0; $i < count($allDates); $i++)
		{
			$date = $allDates[$i];
			$this->reservationViewRepository->expects($this->at($i))
					->method('GetBlackoutsWithin')
					->with($this->equalTo($date))
					->will($this->returnValue(array()));

			$this->reservationViewRepository->expects($this->at($i + 4)) // index is per mock, not per method
					->method('GetReservationList')
					->with($this->equalTo($date->GetBegin()), $this->equalTo($date->GetEnd()), $this->isNull(), $this->isNull(), $this->isNull(), $this->equalTo($resourceId))
					->will($this->returnValue(array()));

			$this->blackoutRepository->expects($this->at($i))
					->method('Add')
					->with($this->equalTo(Blackout::Create($userId, $resourceId, $title, $date)));
		}

		$this->assertEquals(4, $i, 'should create 4 blackouts');

		$result = $this->service->Add($range, $resourceIds, $title, $this->conflictHandler, $repeatDaily);
		$this->assertTrue($result->WasSuccessful());
	}

	public function testNothingIsCheckedIfTimesAreInvalid()
	{
		$date = DateRange::Create('2011-01-01 00:00:00', '2011-01-01 00:00:00', 'UTC');
		$result = $this->service->Add($date, array(1), 'title', $this->conflictHandler, new RepeatNone());

		$this->assertFalse($result->WasSuccessful());
		$this->assertNotEmpty($result->Message());
	}

	public function testDeletesBlackoutById()
	{
		$blackoutId = 123;
		$this->blackoutRepository->expects($this->once())
				->method('Delete')
				->with($this->equalTo($blackoutId));

		$this->service->Delete($blackoutId);
	}

	public function testGetsBlackoutsThatUserCanManageIfNotAdmin()
	{
		$userId = $this->fakeUser->UserId;
		$this->fakeUser->IsAdmin = false;
		$pageNumber = 10;
		$pageSize = 20;
		$filter = new BlackoutFilter();

		$groupIds = array(1,2,3);
		$groups = array(new UserGroup(1, null), new UserGroup(2, null), new UserGroup(3, null));

		$expectedFilter = $filter->GetFilter();
		$adminFilter = new SqlFilterIn(new SqlFilterColumn(TableNames::RESOURCES, ColumnNames::RESOURCE_ADMIN_GROUP_ID), $groupIds);
		$adminFilter->_Or(new SqlFilterIn(new SqlFilterColumn(TableNames::SCHEDULES, ColumnNames::SCHEDULE_ADMIN_GROUP_ID), $groupIds));
		$expectedFilter->_And($adminFilter);

		$date = Date::Now();
		$resourceId1 = 111;
		$resourceId2 = 222;

		$b1 = new TestBlackoutItemView(1, $date, $date, $resourceId1);
		$b2 = new TestBlackoutItemView(2, $date, $date, $resourceId2);
		$blackouts = array($b1, $b2);

		$roles = array(RoleLevel::RESOURCE_ADMIN, RoleLevel::SCHEDULE_ADMIN);
		$this->userRepository->expects($this->once())
				->method('LoadGroups')
				->with($this->equalTo($userId), $this->equalTo($roles))
				->will($this->returnValue($groups));

		$this->reservationViewRepository->expects($this->once())
				->method('GetBlackoutList')
				->with($this->equalTo($pageNumber), $this->equalTo($pageSize), $this->isNull(), $this->isNull(), $this->equalTo($expectedFilter))
				->will($this->returnValue(new PageableData($blackouts)));

		$this->service->LoadFiltered($pageNumber, $pageSize, $filter, $this->fakeUser);
	}
}

class TestBlackoutItemView extends BlackoutItemView
{
	public function __construct(
		$instanceId,
		Date $startDate,
		Date $endDate,
		$resourceId)
	{
		parent::__construct($instanceId, $startDate, $endDate, $resourceId, null, null, null, null, null, null, null, null);
	}

	public function WithScheduleId($scheduleId)
	{
		$this->ScheduleId = $scheduleId;
		return $this;
	}

}

?>
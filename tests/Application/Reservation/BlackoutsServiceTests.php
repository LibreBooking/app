<?php
/**
 * Copyright 2011-2019 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
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
		$this->reservationViewRepository->expects($this->once())
										->method('GetBlackoutsWithin')
										->with($this->equalTo($date))
										->will($this->returnValue(array($blackoutBefore, $blackoutAfter, $blackoutDuring)));

		$reservationBefore = new TestReservationItemView(1, Date::Parse('2010-01-01'), $start, 1);
		$reservationAfter = new TestReservationItemView(2, $end, Date::Parse('2012-01-01'), 2);

		$this->reservationViewRepository->expects($this->once())
										->method('GetReservations')
										->with($this->equalTo($start), $this->equalTo($end))
										->will($this->returnValue(array($reservationBefore, $reservationAfter)));

		$series = BlackoutSeries::Create($userId, $title, $date);
		$series->AddResourceId($resourceIds[0]);
		$series->AddResourceId($resourceIds[1]);
		$series->AddResourceId($resourceIds[2]);

		$this->blackoutRepository->expects($this->once())
								 ->method('Add')
								 ->with($this->equalTo($series, 1));

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

		$series = BlackoutSeries::Create($userId, $title, $date);
		$series->AddResourceId(2);

		$this->reservationViewRepository->expects($this->once())
										->method('GetBlackoutsWithin')
										->with($this->equalTo($date))
										->will($this->returnValue(array()));

		$reservation1 = new TestReservationItemView(1, $start, $end, 2);
		$reservation2 = new TestReservationItemView(2, $start, $end, 2);
		$this->reservationViewRepository->expects($this->once())
										->method('GetReservations')
										->with($this->equalTo($start), $this->equalTo($end))
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
								 ->with($this->equalTo($series, 1));

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
										->method('GetReservations')
										->with($this->equalTo($start), $this->equalTo($end))
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

		$series = BlackoutSeries::Create($userId, $title, $range);
		$series->Repeats($repeatDaily);
		$series->AddResourceId($resourceId);

		foreach ($repeatDates as $date)
		{
			$series->AddBlackout(new Blackout($date));
		}

		for ($i = 0; $i < count($allDates); $i++)
		{
			$date = $allDates[$i];
			$this->reservationViewRepository->expects($this->at($i))
											->method('GetBlackoutsWithin')
											->with($this->equalTo($date))
											->will($this->returnValue(array()));

			$this->reservationViewRepository->expects($this->at($i + count($allDates))) // index is per mock, not per method
											->method('GetReservations')
											->with($this->equalTo($date->GetBegin()), $this->equalTo($date->GetEnd()))
											->will($this->returnValue(array()));

		}

		$this->blackoutRepository->expects($this->at(0))
								 ->method('Add')
								 ->with($this->equalTo($series, 4));

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
		$scope = SeriesUpdateScope::ThisInstance;

		$this->blackoutRepository->expects($this->once())
								 ->method('Delete')
								 ->with($this->equalTo($blackoutId));

		$this->service->Delete($blackoutId, $scope);
	}

	public function testDeletesBlackoutSeriesByInstanceId()
	{
		$blackoutId = 123;
		$scope = SeriesUpdateScope::FullSeries;

		$this->blackoutRepository->expects($this->once())
								 ->method('DeleteSeries')
								 ->with($this->equalTo($blackoutId));

		$this->service->Delete($blackoutId, $scope);
	}

	public function testGetsBlackoutsThatUserCanManageIfNotAdmin()
	{
		$userId = $this->fakeUser->UserId;
		$this->fakeUser->IsAdmin = false;
		$pageNumber = 10;
		$pageSize = 20;
		$filter = new BlackoutFilter();

		$groupIds = array(1, 2, 3);
		$groups = array(new UserGroup(1, null), new UserGroup(2, null), new UserGroup(3, null));

		$expectedFilter = $filter->GetFilter();
		$adminFilter = new SqlFilterIn(new SqlFilterColumn('r', ColumnNames::RESOURCE_ADMIN_GROUP_ID), $groupIds);
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
										->with($this->equalTo($pageNumber), $this->equalTo($pageSize), $this->isNull(),
											   $this->isNull(), $this->equalTo($expectedFilter))
										->will($this->returnValue(new PageableData($blackouts)));

		$this->service->LoadFiltered($pageNumber, $pageSize, null, null, $filter, $this->fakeUser);
	}

	public function testLoadsBlackoutByInstanceId()
	{
		$id = 123231;
		$userId = 89191;
		$user = $this->getMock('User');
		$resource = new BlackoutResource(1, 'name', 3);

		$series = BlackoutSeries::Create(1, 'title', new TestDateRange());
		$series->AddResource($resource);

		$this->userRepository->expects($this->once())
							 ->method('LoadById')
							 ->with($this->equalTo($userId))
							 ->will($this->returnValue($user));

		$this->blackoutRepository->expects($this->once())
								 ->method('LoadByBlackoutId')
								 ->with($this->equalTo($id))
								 ->will($this->returnValue($series));

		$user->expects($this->once())
			 ->method('IsResourceAdminFor')
			 ->with($this->equalTo($resource))
			 ->will($this->returnValue(true));

		$actualSeries = $this->service->LoadBlackout($id, $userId);

		$this->assertEquals($series, $actualSeries);
	}

	public function testUpdatesBlackoutForEachResourceWhenNoConflicts()
	{
		$userId = $this->fakeUser->UserId;
		$start = Date::Parse('2011-01-01 01:01:01');
		$end = Date::Parse('2011-02-02 02:02:02');
		$date = new DateRange($start, $end);
		$resourceIds = array(1, 2, 3);
		$title = 'title';
		$seriesId = 111;
		$blackoutInstanceId = 10;

		$blackoutBefore = new TestBlackoutItemView(1, Date::Parse('2010-01-01'), $start, 3);
		$blackoutAfter = new TestBlackoutItemView(2, $end, Date::Parse('2012-01-01'), 1);
		$blackoutDuringDiffResource = new TestBlackoutItemView(3, $start, $end, 4);
		$blackoutDuringSameSeries = new TestBlackoutItemView(3, $start, $end, 1, $seriesId);

		$series = BlackoutSeries::Create(1, 'old title', new TestDateRange());
		$series->WithId($seriesId);
		$user = $this->getMock('User');

		$reservationBefore = new TestReservationItemView(1, Date::Parse('2010-01-01'), $start, 1);
		$reservationAfter = new TestReservationItemView(2, $end, Date::Parse('2012-01-01'), 2);

		$this->reservationViewRepository->expects($this->once())
										->method('GetBlackoutsWithin')
										->with($this->equalTo($date))
										->will($this->returnValue(array($blackoutBefore, $blackoutAfter, $blackoutDuringDiffResource, $blackoutDuringSameSeries)));

		$this->reservationViewRepository->expects($this->once())
										->method('GetReservations')
										->with($this->equalTo($start), $this->equalTo($end))
										->will($this->returnValue(array($reservationBefore, $reservationAfter)));

		$user->expects($this->any())
			 ->method('IsResourceAdminFor')
			 ->with($this->anything())
			 ->will($this->returnValue(true));

		$this->userRepository->expects($this->once())
							 ->method('LoadById')
							 ->with($this->equalTo($userId))
							 ->will($this->returnValue($user));

		$this->blackoutRepository->expects($this->once())
								 ->method('LoadByBlackoutId')
								 ->with($this->equalTo($blackoutInstanceId))
								 ->will($this->returnValue($series));

		$this->blackoutRepository->expects($this->once())
								 ->method('Update')
								 ->with($this->equalTo($series));

		$result = $this->service->Update($blackoutInstanceId, $date, $resourceIds, $title, $this->conflictHandler,
										 new RepeatNone(), SeriesUpdateScope::FullSeries);

		$this->assertTrue($result->WasSuccessful());

		$this->assertEquals($title, $series->Title());
	}

	public function testDoesNotUpdateAnyBlackoutsIfThereAreConflictingBlackoutTimes()
	{
		$userId = $this->fakeUser->UserId;
		$start = Date::Parse('2011-01-01 01:01:01');
		$end = Date::Parse('2011-02-02 02:02:02');
		$date = new DateRange($start, $end);
		$resourceIds = array(2, 3);
		$title = 'title';
		$blackoutInstanceId = 199;

		$user = $this->getMock('User');
		$series = BlackoutSeries::Create(1, 'old title', new TestDateRange());
		$series->WithId(1);

		$blackoutDuring = new TestBlackoutItemView(1, $start, $end, 3, 10);
		$this->reservationViewRepository->expects($this->atLeastOnce())
										->method('GetBlackoutsWithin')
										->with($this->anything())
										->will($this->returnValue(array($blackoutDuring)));

		$user->expects($this->any())
			 ->method('IsResourceAdminFor')
			 ->with($this->anything())
			 ->will($this->returnValue(true));

		$this->userRepository->expects($this->once())
							 ->method('LoadById')
							 ->with($this->equalTo($userId))
							 ->will($this->returnValue($user));

		$this->blackoutRepository->expects($this->once())
								 ->method('LoadByBlackoutId')
								 ->with($this->equalTo($blackoutInstanceId))
								 ->will($this->returnValue($series));

		$this->blackoutRepository->expects($this->never())
								 ->method('Update');

		$result = $this->service->Update($blackoutInstanceId, $date, $resourceIds, $title, $this->conflictHandler,
										 new RepeatNone(), SeriesUpdateScope::FullSeries);

		$this->assertFalse($result->WasSuccessful());
	}

	public function testConflictHandlerActsOnEachConflictingReservationAndUpdatesBlackout()
	{
		$userId = $this->fakeUser->UserId;
		$start = Date::Parse('2011-01-01 01:01:01');
		$end = Date::Parse('2011-02-02 02:02:02');
		$date = new DateRange($start, $end);
		$resourceId = 2;
		$resourceIds = array($resourceId);
		$title = 'title';

		$seriesId = 111;
		$blackoutInstanceId = 10;

		$series = BlackoutSeries::Create(1, 'old title', new TestDateRange());
		$series->WithId($seriesId);
		$user = $this->getMock('User');

		$user->expects($this->any())
			 ->method('IsResourceAdminFor')
			 ->with($this->anything())
			 ->will($this->returnValue(true));

		$this->userRepository->expects($this->once())
							 ->method('LoadById')
							 ->with($this->equalTo($userId))
							 ->will($this->returnValue($user));

		$this->reservationViewRepository->expects($this->once())
										->method('GetBlackoutsWithin')
										->with($this->equalTo($date))
										->will($this->returnValue(array()));

		$reservation1 = new TestReservationItemView(1, $start, $end, 2);
		$reservation2 = new TestReservationItemView(2, $start, $end, 2);
		$this->reservationViewRepository->expects($this->once())
										->method('GetReservations')
										->with($this->equalTo($start), $this->equalTo($end))
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
								 ->method('LoadByBlackoutId')
								 ->with($this->equalTo($blackoutInstanceId))
								 ->will($this->returnValue($series));

		$this->blackoutRepository->expects($this->once())
								 ->method('Update')
								 ->with($this->equalTo($series));

		$result = $this->service->Update($blackoutInstanceId, $date, $resourceIds, $title, $this->conflictHandler,
										 new RepeatNone(), SeriesUpdateScope::FullSeries);

		$this->assertTrue($result->WasSuccessful());
	}

	public function testConflictHandlerReportsConflictingReservationAndDoesNotUpdateBlackout()
	{
		$userId = $this->fakeUser->UserId;
		$start = Date::Parse('2011-01-01 01:01:01');
		$end = Date::Parse('2011-02-02 02:02:02');
		$date = new DateRange($start, $end);
		$resourceId = 2;
		$resourceIds = array($resourceId);
		$title = 'title';

		$seriesId = 111;
		$blackoutInstanceId = 10;

		$series = BlackoutSeries::Create(1, 'old title', new TestDateRange());
		$series->WithId($seriesId);
		$user = $this->getMock('User');

		$user->expects($this->any())
			 ->method('IsResourceAdminFor')
			 ->with($this->anything())
			 ->will($this->returnValue(true));

		$this->userRepository->expects($this->once())
							 ->method('LoadById')
							 ->with($this->equalTo($userId))
							 ->will($this->returnValue($user));

		$this->reservationViewRepository->expects($this->once())
										->method('GetBlackoutsWithin')
										->with($this->equalTo($date))
										->will($this->returnValue(array()));

		$reservation1 = new TestReservationItemView(1, $start, $end, 2);
		$reservation2 = new TestReservationItemView(2, $start, $end, 2);
		$this->reservationViewRepository->expects($this->once())
										->method('GetReservations')
										->with($this->equalTo($start), $this->equalTo($end))
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
								 ->method('Update');

		$this->blackoutRepository->expects($this->once())
								 ->method('LoadByBlackoutId')
								 ->with($this->equalTo($blackoutInstanceId))
								 ->will($this->returnValue($series));

		$result = $this->service->Update($blackoutInstanceId, $date, $resourceIds, $title, $this->conflictHandler,
										 new RepeatNone(), SeriesUpdateScope::FullSeries);

		$this->assertFalse($result->WasSuccessful());
	}
}
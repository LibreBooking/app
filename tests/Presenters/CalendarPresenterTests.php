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

require_once(ROOT_DIR . 'Pages/CalendarPage.php');
require_once(ROOT_DIR . 'Presenters/Calendar/CalendarPresenter.php');

class CalendarPresenterTests extends TestBase
{
	/**
	 * @var ICommonCalendarPage|PHPUnit_Framework_MockObject_MockObject
	 */
	private $page;

	/**
	 * @var CalendarPresenter
	 */
	private $presenter;

	/**
	 * @var IReservationViewRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $repository;

	/**
	 * @var ICalendarFactory|PHPUnit_Framework_MockObject_MockObject
	 */
	private $calendarFactory;

	/**
	 * @var IScheduleRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $scheduleRepository;

    /**
     * @var FakeUserRepository
     */
	private $userRepository;

	/**
	 * @var IResourceService|PHPUnit_Framework_MockObject_MockObject
	 */
	private $resourceService;

	/**
	 * @var ICalendarSubscriptionService|PHPUnit_Framework_MockObject_MockObject
	 */
	private $subscriptionService;

	/**
	 * @var FakePrivacyFilter
	 */
	private $privacyFilter;

	public function setup()
	{
		parent::setup();

		$this->page = $this->getMock('ICommonCalendarPage');
		$this->repository = $this->getMock('IReservationViewRepository');
		$this->scheduleRepository = $this->getMock('IScheduleRepository');
		$this->userRepository = new FakeUserRepository();
		$this->calendarFactory = $this->getMock('ICalendarFactory');
		$this->resourceService = $this->getMock('IResourceService');
		$this->subscriptionService = $this->getMock('ICalendarSubscriptionService');
		$this->privacyFilter = new FakePrivacyFilter();

		$this->presenter = new CalendarPresenter(
			$this->page,
			$this->calendarFactory,
			$this->repository,
			$this->scheduleRepository,
            $this->userRepository,
			$this->resourceService,
			$this->subscriptionService,
			$this->privacyFilter);
	}

	public function testBindsDefaultScheduleByMonthWhenNothingSelected()
	{
		$showInaccessible = true;
		$this->fakeConfig->SetSectionKey(ConfigSection::SCHEDULE, ConfigKeys::SCHEDULE_SHOW_INACCESSIBLE_RESOURCES, 'true');

		$userId = $this->fakeUser->UserId;
		$defaultScheduleId = 10;
		$userTimezone = "America/New_York";

		$calendarType = CalendarTypes::Month;

		$startDate = Date::Parse('2011-01-01', 'UTC');
		$endDate = Date::Parse('2011-01-02', 'UTC');
		$summary = 'foo summary';
		$resourceId = 3;
		$fname = 'fname';
		$lname = 'lname';
		$referenceNumber = 'refnum';
		$resourceName = 'resource name';

		//$res = new ScheduleReservation(1, $startDate, $endDate, null, $summary, $resourceId, $userId, $fname, $lname, $referenceNumber, ReservationStatus::Created);
		$res = new ReservationItemView($referenceNumber, $startDate, $endDate, 'resource name', $resourceId, 1, null, null, $summary, null, $fname, $lname, $userId);

		$r1 = new FakeBookableResource(1, 'dude1');
		$r2 = new FakeBookableResource($resourceId, $resourceName);

		$resources = array($r1, $r2);
		/** @var Schedule[] $schedules */
		$schedules = array(new Schedule(1, null, false, 2, null), new Schedule($defaultScheduleId, null, true, 3, null),);

		$this->scheduleRepository
				->expects($this->atLeastOnce())
				->method('GetAll')
				->will($this->returnValue($schedules));

		$this->resourceService
				->expects($this->atLeastOnce())
				->method('GetAllResources')
				->with($this->equalTo($showInaccessible), $this->equalTo($this->fakeUser))
				->will($this->returnValue($resources));

		$this->resourceService
				->expects($this->atLeastOnce())
				->method('GetResourceGroups')
				->with($this->isNull(), $this->equalTo($this->fakeUser))
				->will($this->returnValue(new ResourceGroupTree()));

		$this->page
				->expects($this->atLeastOnce())
				->method('GetScheduleId')
				->will($this->returnValue($defaultScheduleId));

		$this->page
				->expects($this->atLeastOnce())
				->method('GetResourceId')
				->will($this->returnValue(null));


		$this->page
				->expects($this->atLeastOnce())
				->method('GetCalendarType')
				->will($this->returnValue($calendarType));

		$this->page
				->expects($this->atLeastOnce())
				->method('SetFirstDay')
				->with($this->equalTo($schedules[1]->GetWeekdayStart()));

		$details = new CalendarSubscriptionDetails(true);
		$this->subscriptionService->expects($this->once())->method('ForSchedule')->with($this->equalTo($defaultScheduleId))->will($this->returnValue($details));

		$this->page->expects($this->atLeastOnce())->method('BindSubscription')->with($this->equalTo($details));

		$calendarFilters = new CalendarFilters($schedules, $resources, $defaultScheduleId, null, new ResourceGroupTree());
		$this->page->expects($this->atLeastOnce())->method('BindFilters')->with($this->equalTo($calendarFilters));

		$this->presenter->PageLoad($this->fakeUser, $userTimezone);
	}

	public function testSkipsReservationsForUnknownResources()
	{
		$res1 = new TestReservationItemView(1, Date::Now(), Date::Now(), 1);
		$res2 = new TestReservationItemView(2, Date::Now(), Date::Now(), 2);

		$r1 = new FakeBookableResource(1, 'dude1');

		$reservations = array($res1, $res2);
		$resources = array($r1);

		$actualReservations = CalendarReservation::FromScheduleReservationList($reservations,
																			   $resources,
																			   $this->fakeUser);

		$this->assertEquals(1, count($actualReservations));

	}

	public function testGroupsReservationsByResource()
	{
		$start = Date::Now();
		$end = Date::Now()->AddDays(1);

		$r1 = new TestReservationItemView(1, $start, $end, 1);
		$r1->SeriesId = 1;
		$r1->ReferenceNumber = 1;

		$r2 = new TestReservationItemView(2, $start, $end, 2);
		$r2->SeriesId = 1;
		$r2->ReferenceNumber = 2;

		$r3 = new TestReservationItemView(3, $start, $end, 1);
		$r3->SeriesId = 2;
		$r3->ReferenceNumber = 2;

		$reservations = array($r1, $r2, $r3);

		$resources = array(new FakeBookableResource(1, '1'), new FakeBookableResource(2, '2'));
		$calendarReservations = CalendarReservation::FromScheduleReservationList($reservations, $resources, $this->fakeUser, true);

		$this->assertEquals(2, count($calendarReservations));
	}
}

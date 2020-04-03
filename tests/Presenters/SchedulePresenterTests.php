<?php
/**
 * Copyright 2011-2020 Nick Korbel
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

require_once(ROOT_DIR . 'Presenters/SchedulePresenter.php');
require_once(ROOT_DIR . 'Pages/SchedulePage.php');

class SchedulePresenterTests extends TestBase
{
    private $scheduleId;
    private $currentSchedule;
    private $schedules;
    private $numDaysVisible;
    private $showInaccessibleResources = 'true';

    public function setUp(): void
    {
        parent::setup();

        $this->scheduleId = 1;
        $this->numDaysVisible = 10;
        $this->currentSchedule = new Schedule($this->scheduleId, 'default', 1, $this->numDaysVisible, 'America/New_York', 1);
        $otherSchedule = new Schedule(2, 'not default', 0, $this->numDaysVisible, 1, 'America/New_York', 1);

        $this->schedules = array($this->currentSchedule, $otherSchedule);
        $this->fakeConfig->SetSectionKey(ConfigSection::SCHEDULE, ConfigKeys::SCHEDULE_SHOW_INACCESSIBLE_RESOURCES,
            $this->showInaccessibleResources);
    }

    public function testPageLoadBindsAllSchedulesAndProperResourcesWhenNotPostingBack()
    {
        $user = $this->fakeServer->GetUserSession();
        $resources = array();
        $reservations = $this->createMock('IReservationListing');
        $bindingDates = new DateRange(Date::Now(), Date::Now());
        $groups = new ResourceGroupTree();
        $resourceTypes = array(new ResourceType(1, 'n', 'd'));
        $resourceAttributes = array(new FakeCustomAttribute());
        $resourceTypeAttributes = array(new FakeCustomAttribute());

        $page = $this->createMock('ISchedulePage');
        $scheduleService = $this->createMock('IScheduleService');
        $resourceService = $this->createMock('IResourceService');
        $pageBuilder = $this->createMock('ISchedulePageBuilder');
        $reservationService = $this->createMock('IReservationService');
        $dailyLayout = $this->createMock('IDailyLayout');

        $presenter = new SchedulePresenter($page, $scheduleService, $resourceService, $pageBuilder, $reservationService);

        $page
            ->expects($this->once())
            ->method('ShowInaccessibleResources')
            ->will($this->returnValue($this->showInaccessibleResources));

        $page
            ->expects($this->once())
            ->method('GetDisplayTimezone')
            ->will($this->returnValue($user->Timezone));

        $scheduleService
            ->expects($this->once())
            ->method('GetAll')
            ->with($this->equalTo($this->showInaccessibleResources), $this->equalTo($this->fakeUser))
            ->will($this->returnValue($this->schedules));

        $pageBuilder
            ->expects($this->once())
            ->method('GetCurrentSchedule')
            ->with($this->equalTo($page), $this->equalTo($this->schedules), $this->equalTo($user))
            ->will($this->returnValue($this->currentSchedule));

        $pageBuilder
            ->expects($this->once())
            ->method('BindSchedules')
            ->with($this->equalTo($page), $this->equalTo($this->schedules), $this->equalTo($this->currentSchedule));

        $resourceFilter = new ScheduleResourceFilter();

        $pageBuilder
            ->expects($this->once())
            ->method('GetResourceFilter')
            ->with($this->equalTo($this->scheduleId), $this->equalTo($page))
            ->will($this->returnValue($resourceFilter));

        $pageBuilder
            ->expects($this->once())
            ->method('BindResourceFilter')
            ->with($this->equalTo($page), $this->equalTo($resourceFilter), $this->equalTo($resourceAttributes),
                $this->equalTo($resourceTypeAttributes));

        $resourceService
            ->expects($this->once())
            ->method('GetScheduleResources')
            ->with($this->equalTo($this->scheduleId),
                $this->equalTo($this->showInaccessibleResources),
                $this->equalTo($user),
                $this->equalTo($resourceFilter))
            ->will($this->returnValue($resources));

        $resourceService
            ->expects($this->once())
            ->method('GetResourceGroups')
            ->with($this->equalTo($this->scheduleId))
            ->will($this->returnValue($groups));

        $pageBuilder
            ->expects($this->once())
            ->method('BindResourceGroups')
            ->with($this->equalTo($page), $this->equalTo($groups));

        $pageBuilder
            ->expects($this->once())
            ->method('GetScheduleDates')
            ->with($this->equalTo($user), $this->equalTo($this->currentSchedule), $this->equalTo($page))
            ->will($this->returnValue($bindingDates));

        $pageBuilder
            ->expects($this->once())
            ->method('BindDisplayDates')
            ->with($this->equalTo($page), $this->equalTo($bindingDates), $this->equalTo($this->schedules[0]));

//        $reservationService
//            ->expects($this->once())
//            ->method('GetReservations')
//            ->with($this->equalTo($bindingDates), $this->equalTo($this->scheduleId),
//                $this->equalTo($user->Timezone))
//            ->will($this->returnValue($reservations));

        $scheduleService
            ->expects($this->once())
            ->method('GetDailyLayout')
            ->with($this->equalTo($this->scheduleId), new ScheduleLayoutFactory($user->Timezone), new EmptyReservationListing())
            ->will($this->returnValue($dailyLayout));

        $pageBuilder
            ->expects($this->once())
            ->method('BindReservations')
            ->with($this->equalTo($page), $this->equalTo($resources), $this->equalTo($dailyLayout));

        $resourceService
            ->expects($this->once())
            ->method('GetResourceTypes')
            ->will($this->returnValue($resourceTypes));

        $pageBuilder
            ->expects($this->once())
            ->method('BindResourceTypes')
            ->with($this->equalTo($page), $this->equalTo($resourceTypes));

        $resourceService
            ->expects($this->once())
            ->method('GetResourceAttributes')
            ->will($this->returnValue($resourceAttributes));

        $resourceService
            ->expects($this->once())
            ->method('GetResourceTypeAttributes')
            ->will($this->returnValue($resourceTypeAttributes));

        $presenter->PageLoad($this->fakeUser);
    }


    public function testGetsReservationsForDateRange()
    {
        $page = new FakeSchedulePage();
        $scheduleService = new FakeScheduleService();
        $resourceService = new FakeResourceService();
        $builder = $this->createMock("ISchedulePageBuilder");
        $reservationService = new FakeReservationService();

        $start = Date::Parse('2020-02-20 05:30');
        $end = Date::Parse('2020-02-27 12:00');
        $scheduleId = 1;

        $page->_LoadReservationRequest = (new LoadReservationRequestBuilder())
            ->WithRange($start, $end)
            ->WithResources([1, 2])
            ->WithScheduleId($scheduleId)
            ->Build();

        $presenter = new SchedulePresenter($page, $scheduleService, $resourceService, $builder, $reservationService);

        $presenter->LoadReservations();

        $reservationsAndBlackouts = [new TestReservationListItem(Date::Now(), Date::Now(), 1), new TestBlackoutListItem(Date::Now(), Date::Now(), 1)];
        $reservationService->_ReservationsAndBlackouts = $reservationsAndBlackouts;

        $dtos = [];

        array_walk($reservationsAndBlackouts, function($i) {
            /** @param $i ReservationListItem */
            $dtos[] = $i->AsDto($this->fakeUser->UserId, $this->fakeUser->Timezone);
        });
        $this->assertEquals($page->_BoundReservations, $dtos);
    }
}

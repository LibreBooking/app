<?php
/**
 * Copyright 2020 Nick Korbel
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

require_once(ROOT_DIR . 'Pages/SchedulePage.php');
require_once(ROOT_DIR . 'Presenters/Schedule/SchedulePageBuilder.php');

class SchedulePageBuilderTests extends TestBase
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

    public function testScheduleBuilderBindsAllSchedulesAndSetsActive()
    {
        $activeId = 100;
        $activeName = 'super active';
        $weekdayStart = 4;

        $schedule = new FakeSchedule($activeId, $activeName, true, $weekdayStart);
        $schedule->SetAllowConcurrentReservations(true);

        $page = $this->createMock('ISchedulePage');

        $page
            ->expects($this->once())
            ->method('SetSchedules')
            ->with($this->equalTo($this->schedules));

        $page
            ->expects($this->once())
            ->method('SetScheduleId')
            ->with($this->equalTo($activeId));

        $page
            ->expects($this->once())
            ->method('SetScheduleName')
            ->with($this->equalTo($activeName));

        $page
            ->expects($this->once())
            ->method('SetFirstWeekday')
            ->with($this->equalTo($weekdayStart));

        $page
            ->expects($this->once())
            ->method('GetScheduleStyle')
            ->with($this->equalTo($activeId))
            ->will($this->returnValue(ScheduleStyle::Tall));

        $page
            ->expects($this->once())
            ->method('SetScheduleStyle')
            ->with($this->equalTo(ScheduleStyle::Tall));

        $page
            ->expects($this->once())
            ->method('SetAllowConcurrent')
            ->with($this->equalTo($schedule->GetAllowConcurrentReservations()));

        $pageBuilder = new SchedulePageBuilder();
        $pageBuilder->BindSchedules($page, $this->schedules, $schedule);
    }

    public function testScheduleBuilderGetCurrentScheduleReturnsSelectedScheduleOnPostBack()
    {
        $s1 = $this->createMock('ISchedule');
        $s2 = $this->createMock('ISchedule');

        $s1
            ->expects($this->once())
            ->method('GetId')
            ->will($this->returnValue(11));

        $s2
            ->expects($this->once())
            ->method('GetId')
            ->will($this->returnValue(10));

        $schedules = array($s1, $s2);

        $page = $this->createMock('ISchedulePage');

        $page
            ->expects($this->atLeastOnce())
            ->method('GetScheduleId')
            ->will($this->returnValue(10));

        $pageBuilder = new SchedulePageBuilder();
        $actual = $pageBuilder->GetCurrentSchedule($page, $schedules, $this->fakeUser);

        $this->assertEquals($s2, $actual);
    }

    public function testScheduleBuilderGetCurrentScheduleReturnsDefaultScheduleWhenInitialLoad()
    {
        $s1 = new FakeSchedule(1, '', false);
        $s2 = new FakeSchedule(2, '', true);

        $schedules = array($s1, $s2);

        $page = $this->createMock('ISchedulePage');

        $pageBuilder = new SchedulePageBuilder();
        $actual = $pageBuilder->GetCurrentSchedule($page, $schedules, $this->fakeUser);

        $this->assertEquals($s2, $actual);
    }

    public function testSetsDefaultScheduleWhenSetForUserProfile()
    {
        $session = $this->fakeUser;
        $s1 = new FakeSchedule(1, '1', false);
        $s2 = new FakeSchedule(2, '2', true);
        $s3 = new FakeSchedule($session->ScheduleId, 'should be default', false);

        $schedules = array($s1, $s2, $s3);

        $page = $this->createMock('ISchedulePage');

        $pageBuilder = new SchedulePageBuilder();
        $actual = $pageBuilder->GetCurrentSchedule($page, $schedules, $session);

        $this->assertEquals($s3, $actual);
    }

    public function testStartsOnCurrentDateIfShowingLessThanAWeekOfData()
    {
        $timezone = 'America/Chicago';
        $this->fakeConfig->SetTimezone($timezone);

        // saturday
        $currentServerDate = Date::Create(2009, 07, 18, 11, 00, 00, $timezone);
        Date::_SetNow($currentServerDate);

        $startDay = 0;
        $daysVisible = 6;

        // previous sunday
        $expectedStart = Date::Create(2009, 07, 12, 00, 00, 00, $timezone);
        $expectedEnd = $expectedStart->AddDays($daysVisible);
        $expectedScheduleDates = new DateRange($expectedStart, $expectedEnd);

        $user = new UserSession(1);
        $user->Timezone = $timezone;

        $schedule = $this->createMock('ISchedule');
        $schedulePage = $this->createMock('ISchedulePage');

        $schedulePage
            ->expects($this->once())
            ->method('GetSelectedDate')
            ->will($this->returnValue(null));

        $schedule
            ->expects($this->once())
            ->method('GetWeekdayStart')
            ->will($this->returnValue($startDay));

        $schedule
            ->expects($this->once())
            ->method('GetDaysVisible')
            ->will($this->returnValue($daysVisible));

        $pageBuilder = new SchedulePageBuilder();
        $dates = $pageBuilder->GetScheduleDates($user, $schedule, $schedulePage);

        $this->assertEquals($expectedScheduleDates, $dates);
    }

    public function testStartsToday()
    {
        $timezone = 'America/Chicago';
        $this->fakeConfig->SetTimezone($timezone);

        $currentServerDate = Date::Create(2009, 07, 18, 11, 00, 00, $timezone);
        Date::_SetNow($currentServerDate);

        $startDay = Schedule::Today;
        $daysVisible = 6;

        $expectedStart = $currentServerDate->GetDate();
        $expectedEnd = $expectedStart->AddDays($daysVisible);
        $expectedScheduleDates = new DateRange($expectedStart, $expectedEnd);

        $user = new UserSession(1);
        $user->Timezone = $timezone;

        $schedule = $this->createMock('ISchedule');
        $schedulePage = $this->createMock('ISchedulePage');

        $schedulePage
            ->expects($this->once())
            ->method('GetSelectedDate')
            ->will($this->returnValue(null));

        $schedule
            ->expects($this->once())
            ->method('GetWeekdayStart')
            ->will($this->returnValue($startDay));

        $schedule
            ->expects($this->once())
            ->method('GetDaysVisible')
            ->will($this->returnValue($daysVisible));

        $pageBuilder = new SchedulePageBuilder();
        $dates = $pageBuilder->GetScheduleDates($user, $schedule, $schedulePage);

        $this->assertEquals($expectedScheduleDates, $dates);
    }

    public function testGetScheduleDatesStartsOnConfiguredDayOfWeekWhenStartDayIsPriorToToday()
    {
        $timezone = 'CST';

        // saturday
        $currentServerDate = Date::Create(2009, 07, 18, 11, 00, 00, 'CST');
        Date::_SetNow($currentServerDate);

        $startDay = 0;
        $daysVisible = 7;

        // previous sunday
        $expectedStart = Date::Create(2009, 07, 12, 00, 00, 00, $timezone);
        $expectedEnd = $expectedStart->AddDays($daysVisible);
        $expectedScheduleDates = new DateRange($expectedStart, $expectedEnd);

        $user = new UserSession(1);
        $user->Timezone = $timezone;
        $this->fakeConfig->SetTimezone('CST');

        $schedule = $this->createMock('ISchedule');
        $schedulePage = $this->createMock('ISchedulePage');

        $schedulePage
            ->expects($this->once())
            ->method('GetSelectedDate')
            ->will($this->returnValue(null));

        $schedule
            ->expects($this->once())
            ->method('GetWeekdayStart')
            ->will($this->returnValue($startDay));

        $schedule
            ->expects($this->once())
            ->method('GetDaysVisible')
            ->will($this->returnValue($daysVisible));

        $pageBuilder = new SchedulePageBuilder();
        $dates = $pageBuilder->GetScheduleDates($user, $schedule, $schedulePage);

        $this->assertEquals($expectedScheduleDates, $dates);
    }

    public function testGetScheduleDatesStartsOnConfiguredDayOfWeekWhenStartDayIsAfterToday()
    {
        $timezone = 'CST';
        // tuesday
        $currentServerDate = Date::Create(2009, 07, 14, 11, 00, 00, 'CST');
        Date::_SetNow($currentServerDate);

        $startDay = 3;
        $daysVisible = 7;

        // previous wednesday
        $expectedStart = Date::Create(2009, 07, 8, 00, 00, 00, $timezone);
        $expectedEnd = $expectedStart->AddDays($daysVisible);
        $expectedScheduleDates = new DateRange($expectedStart, $expectedEnd);

        $user = new UserSession(1);
        $user->Timezone = $timezone;
        $this->fakeConfig->SetTimezone('CST');

        $schedule = $this->createMock('ISchedule');
        $schedulePage = $this->createMock('ISchedulePage');

        $schedulePage
            ->expects($this->once())
            ->method('GetSelectedDate')
            ->will($this->returnValue(null));

        $schedule
            ->expects($this->once())
            ->method('GetWeekdayStart')
            ->will($this->returnValue($startDay));

        $schedule
            ->expects($this->once())
            ->method('GetDaysVisible')
            ->will($this->returnValue($daysVisible));

        $pageBuilder = new SchedulePageBuilder();
        $dates = $pageBuilder->GetScheduleDates($user, $schedule, $schedulePage);

        //echo $expectedScheduleDates->ToString();
        //echo $utcDates->ToString();

        $this->assertEquals($expectedScheduleDates, $dates);
    }

    public function testCorrectDatesAreUsedWhenTheUsersTimezoneIsAheadByAWeek()
    {
        $timezone = 'EST';
        // saturday
        $currentServerDate = Date::Create(2009, 07, 18, 23, 00, 00, 'CST');
        Date::_SetNow($currentServerDate);

        $startDay = 0;
        $daysVisible = 7;

        // sunday of next week
        $expectedStart = Date::Create(2009, 07, 19, 00, 00, 00, $timezone);
        $expectedEnd = $expectedStart->AddDays($daysVisible);
        $expectedScheduleDates = new DateRange($expectedStart, $expectedEnd);

        $user = new UserSession(1);
        $user->Timezone = $timezone;
        $this->fakeConfig->SetTimezone('CST');

        $schedule = $this->createMock('ISchedule');
        $schedulePage = $this->createMock('ISchedulePage');

        $schedulePage
            ->expects($this->once())
            ->method('GetSelectedDate')
            ->will($this->returnValue(null));

        $schedule
            ->expects($this->once())
            ->method('GetWeekdayStart')
            ->will($this->returnValue($startDay));

        $schedule
            ->expects($this->once())
            ->method('GetDaysVisible')
            ->will($this->returnValue($daysVisible));

        $pageBuilder = new SchedulePageBuilder();
        $dates = $pageBuilder->GetScheduleDates($user, $schedule, $schedulePage);

        //echo $expectedScheduleDates->ToString();
        //echo $utcDates->ToString();

        $this->assertEquals($expectedScheduleDates, $dates);
    }

    public function testCorrectDatesAreUsedWhenTheUsersTimezoneIsBehindByAWeek()
    {
        $timezone = 'PST';
        // sunday
        $currentServerDate = Date::Create(2009, 07, 19, 00, 30, 00, 'CST');
        Date::_SetNow($currentServerDate);

        $startDay = 0;
        $daysVisible = 7;

        // previous sunday
        $expectedStart = Date::Create(2009, 07, 12, 00, 00, 00, $timezone);
        $expectedEnd = $expectedStart->AddDays($daysVisible);
        $expectedScheduleDates = new DateRange($expectedStart, $expectedEnd);

        $user = new UserSession(1);
        $user->Timezone = $timezone;
        $this->fakeConfig->SetTimezone('CST');

        $schedule = $this->createMock('ISchedule');
        $schedulePage = $this->createMock('ISchedulePage');

        $schedulePage
            ->expects($this->once())
            ->method('GetSelectedDate')
            ->will($this->returnValue(null));

        $schedule
            ->expects($this->once())
            ->method('GetWeekdayStart')
            ->will($this->returnValue($startDay));

        $schedule
            ->expects($this->once())
            ->method('GetDaysVisible')
            ->will($this->returnValue($daysVisible));

        $pageBuilder = new SchedulePageBuilder();
        $dates = $pageBuilder->GetScheduleDates($user, $schedule, $schedulePage);

        $this->assertEquals($expectedScheduleDates, $dates);
    }

    public function testProvidedStartDateIsUsedIfSpecified()
    {
        $timezone = 'CST';
        // saturday
        $selectedDate = Date::Create(2009, 07, 18, 00, 00, 00, 'CST');

        $startDay = 0;
        $daysVisible = 7;

        // previous sunday
        $expectedStart = Date::Create(2009, 07, 12, 00, 00, 00, $timezone);
        $expectedEnd = $expectedStart->AddDays($daysVisible);
        $expectedScheduleDates = new DateRange($expectedStart, $expectedEnd);

        $user = new UserSession(1);
        $user->Timezone = $timezone;
        $this->fakeConfig->SetTimezone('CST');

        $schedule = $this->createMock('ISchedule');
        $schedulePage = $this->createMock('ISchedulePage');

        $schedulePage
            ->expects($this->once())
            ->method('GetSelectedDate')
            ->will($this->returnValue($selectedDate->Format("Y-m-d")));

        $schedule
            ->expects($this->once())
            ->method('GetWeekdayStart')
            ->will($this->returnValue($startDay));

        $schedule
            ->expects($this->once())
            ->method('GetDaysVisible')
            ->will($this->returnValue($daysVisible));

        $pageBuilder = new SchedulePageBuilder();
        $dates = $pageBuilder->GetScheduleDates($user, $schedule, $schedulePage);

        //echo $expectedScheduleDates->ToString();
        //echo $utcDates->ToString();

        $this->assertEquals($expectedScheduleDates, $dates);
    }

    public function testBindReservationsSetsReservationsAndResourcesOnPage()
    {
        $page = $this->createMock('ISchedulePage');
        $dailyLayout = $this->createMock('IDailyLayout');
        $resources = array();

        $page
            ->expects($this->once())
            ->method('SetResources')
            ->with($this->equalTo($resources));

        $page
            ->expects($this->once())
            ->method('SetDailyLayout')
            ->with($this->equalTo($dailyLayout));

        $pageBuilder = new SchedulePageBuilder();
        $pageBuilder->BindReservations($page, $resources, $dailyLayout);
    }

    public function testBindDisplayDatesSetsPageToArrayOfDatesInGivenTimezoneForRange()
    {
        $tz = 'America/New_York';
        $daysVisible = 7;
        $schedule = new Schedule(1, '', false, 4, $daysVisible);
        $page = $this->createMock('ISchedulePage');

        $start = Date::Now();
        $end = Date::Now()->AddDays(10);

        $expectedRange = new DateRange($start, $end);

        $expectedPrev = $expectedRange
            ->GetBegin()
            ->AddDays(-$daysVisible);
        $expectedNext = $expectedRange
            ->GetBegin()
            ->AddDays($daysVisible);

        $page
            ->expects($this->once())
            ->method('SetDisplayDates')
            ->with($this->equalTo($expectedRange));

        $page
            ->expects($this->once())
            ->method('SetPreviousNextDates')
            ->with($this->equalTo($expectedPrev), $this->equalTo($expectedNext));

        $pageBuilder = new SchedulePageBuilder();
        $pageBuilder->BindDisplayDates($page, $expectedRange, $schedule);
    }

    public function testPreviousAndNextLinksWhenStartingOnMondayShowingFiveDays()
    {
        $tz = 'America/Chicago';
        $start = Date::Parse('2011-04-04', $tz);
        $end = Date::Parse('2011-04-08', $tz);

        $session = new UserSession(1);
        $session->Timezone = $tz;

        $schedule = new Schedule(1, null, true, 1, 5);

        $expectedPrevious = Date::Parse('2011-03-28', $tz);
        $expectedNext = Date::Parse('2011-04-11', $tz);

        $page = $this->createMock('ISchedulePage');
        $page
            ->expects($this->once())
            ->method('SetPreviousNextDates')
            ->with($this->equalTo($expectedPrevious), $this->equalTo($expectedNext));

        $page
            ->expects($this->once())
            ->method('ShowFullWeekToggle')
            ->with($this->equalTo(true));

        $builder = new SchedulePageBuilder();
        $builder->BindDisplayDates($page, new DateRange($start, $end), $schedule);
    }

    public function testPreviousAndNextLinksWhenStartingOnMondayShowingTenDays()
    {
        $tz = 'America/Chicago';
        $start = Date::Parse('2011-04-04', $tz);
        $end = Date::Parse('2011-04-13', $tz);

        $session = new UserSession(1);
        $session->Timezone = $tz;

        $schedule = new Schedule(1, null, true, 1, 10);

        $expectedPrevious = Date::Parse('2011-03-28', $tz);
        $expectedNext = Date::Parse('2011-04-14', $tz);

        $page = $this->createMock('ISchedulePage');
        $page
            ->expects($this->once())
            ->method('SetPreviousNextDates')
            ->with($this->equalTo($expectedPrevious), $this->equalTo($expectedNext));

        $builder = new SchedulePageBuilder();
        $builder->BindDisplayDates($page, new DateRange($start, $end), $schedule);
    }

    public function testIfCurrentDateIsBeforeAvailability_ShowFirstAvailableMessage()
    {
        $tz = 'America/Chicago';
        $start = Date::Parse('2011-04-04', $tz);
        $end = Date::Parse('2011-04-13', $tz);

        $session = new UserSession(1);
        $session->Timezone = $tz;

        $schedule = new Schedule(1, null, true, 1, 10);
        $schedule->SetAvailability($end->AddDays(20), $end->AddDays(30));

        $page = new FakeSchedulePage();

        $builder = new SchedulePageBuilder();
        $builder->BindDisplayDates($page, new DateRange($start, $end), $schedule);

        $this->assertEquals($page->_ScheduleAvailability, $schedule->GetAvailability());
        $this->assertTrue($page->_ScheduleTooEarly);
    }

    public function testIfCurrentDateIsAfterAvailability_ShowNoLongerAvailableMessage()
    {
        $tz = 'America/Chicago';
        $start = Date::Parse('2011-04-04', $tz);
        $end = Date::Parse('2011-04-13', $tz);

        $session = new UserSession(1);
        $session->Timezone = $tz;

        $schedule = new Schedule(1, null, true, 1, 10);
        $schedule->SetAvailability($start->AddDays(-30), $start->AddDays(-20));

        $page = new FakeSchedulePage();

        $builder = new SchedulePageBuilder();
        $builder->BindDisplayDates($page, new DateRange($start, $end), $schedule);

        $this->assertEquals($page->_ScheduleAvailability, $schedule->GetAvailability());
        $this->assertTrue($page->_ScheduleTooLate);
    }

    public function testShowsSevenDaysIfWeAreShowingFullWeek()
    {
        $timezone = 'America/Chicago';
        // saturday
        $selectedDate = Date::Parse('2009-07-18', $timezone);

        $startDay = 0;
        $daysVisible = 100;

        // previous sunday
        $expectedStart = Date::Parse('2009-07-12', $timezone);
        $expectedEnd = $expectedStart->AddDays(7);
        $expectedScheduleDates = new DateRange($expectedStart, $expectedEnd);

        $user = new UserSession(1);
        $user->Timezone = $timezone;
        $this->fakeConfig->SetTimezone($timezone);

        $schedule = $this->createMock('ISchedule');
        $schedulePage = $this->createMock('ISchedulePage');

        $schedulePage
            ->expects($this->once())
            ->method('GetSelectedDate')
            ->will($this->returnValue($selectedDate->Format("Y-m-d")));

        $schedulePage
            ->expects($this->once())
            ->method('GetShowFullWeek')
            ->will($this->returnValue(true));

        $schedule
            ->expects($this->once())
            ->method('GetWeekdayStart')
            ->will($this->returnValue($startDay));

        $schedule
            ->expects($this->once())
            ->method('GetDaysVisible')
            ->will($this->returnValue($daysVisible));

        $pageBuilder = new SchedulePageBuilder();
        $dates = $pageBuilder->GetScheduleDates($user, $schedule, $schedulePage);

        $this->assertEquals($expectedScheduleDates, $dates);
    }

    public function testCanGetLayoutForScheduleOnDate()
    {
        $user = $this->fakeUser;
        $page = $this->createMock('ISchedulePage');
        $scheduleService = $this->createMock('IScheduleService');
        $resourceService = $this->createMock('IResourceService');
        $pageBuilder = $this->createMock('ISchedulePageBuilder');
        $reservationService = $this->createMock('IReservationService');
        $dailyLayoutFactory = $this->createMock('IDailyLayoutFactory');

        $layout = $this->createMock('IScheduleLayout');

        $dateString = '2013-01-07';
        $date = Date::Parse($dateString, $user->Timezone);

        $periods = array();
        $scheduleId = 1928;

        $expectedLayoutResponse = new ScheduleLayoutSerializable($periods);

        $page
            ->expects($this->once())
            ->method('GetScheduleId')
            ->will($this->returnValue($scheduleId));

        $page
            ->expects($this->once())
            ->method('GetLayoutDate')
            ->will($this->returnValue($dateString));

        $scheduleService
            ->expects($this->once())
            ->method('GetLayout')
            ->with($this->equalTo($scheduleId), $this->equalTo(new ScheduleLayoutFactory($user->Timezone)))
            ->will($this->returnValue($layout));

        $layout
            ->expects($this->once())
            ->method('GetLayout')
            ->with($this->equalTo($date))
            ->will($this->returnValue($periods));

        $page
            ->expects($this->once())
            ->method('SetLayoutResponse')
            ->with($this->equalTo($expectedLayoutResponse));

        $presenter = new SchedulePresenter($page, $scheduleService, $resourceService, $pageBuilder, $reservationService);

        $presenter->GetLayout($user);
    }

    public function testGetsResourceFilterWhenSubmitted()
    {
        $scheduleId = 1;
        $page = new FakeSchedulePage();
        $page->_FilterSubmitted = true;
        $page->_ResourceTypeId = 1;
        $page->_MaxParticipants = 10;
        $page->_ResourceAttributes = array(new AttributeFormElement(2, 2));
        $page->_ResourceTypeAttributes = array(new AttributeFormElement(1, 1));
        $page->_ResourceIds = array(1, 2, 3);
        $builder = new SchedulePageBuilder();

        $filter = $builder->GetResourceFilter($scheduleId, $page);

        $this->assertEquals($page->_ResourceIds, $filter->ResourceIds);
        $this->assertEquals(array(new AttributeValue(2, 2)), $filter->ResourceAttributes);
        $this->assertEquals(array(new AttributeValue(1, 1)), $filter->ResourceTypeAttributes);
    }

    public function testGetsResourceFilterFromCookie()
    {
        $scheduleId = 1;
        $page = new FakeSchedulePage();

        $filter = new ScheduleResourceFilter(1, 2, 3, array(new AttributeValue(1, 1)), array(new AttributeValue(2, 2)), array(1, 2, 3));
        $this->fakeServer->SetCookie(new Cookie('resource_filter' . $scheduleId, json_encode($filter)));
        $page->_FilterSubmitted = false;
        $builder = new SchedulePageBuilder();

        $builtFilter = $builder->GetResourceFilter($scheduleId, $page);

        $this->assertEquals($filter->ScheduleId, $builtFilter->ScheduleId);
        $this->assertEquals($filter->ResourceIds, $builtFilter->ResourceIds);
    }

    public function testGetsRangeForSpecificDates()
    {
        $d1 = Date::Parse('2015-10-31', $this->fakeUser->Timezone);
        $d2 = Date::Parse('2015-12-25', $this->fakeUser->Timezone);

        $page = new FakeSchedulePage();
        $page->_SelectedDates = array($d1, $d2);

        $builder = new SchedulePageBuilder();

        $dates = $builder->GetScheduleDates($this->fakeUser, new FakeSchedule(), $page);

        $this->assertEquals(new DateRange($d1, $d2->AddDays(1)), $dates);
    }
}
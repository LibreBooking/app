<?php
/**
 * Copyright 2016 Nick Korbel
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

require_once(ROOT_DIR . 'Presenters/SearchAvailabilityPresenter.php');

class SearchAvailabilityPresenterTests extends TestBase
{
    /**
     * @var SearchAvailabilityPresenter
     */
    private $presenter;

    /**
     * @var FakeSearchAvailabilityPage
     */
    private $page;

    /**
     * @var FakeResourceService
     */
    private $resourceService;

    /**
     * @var FakeReservationService
     */
    private $reservationService;
    /**
     * @var FakeScheduleService
     */
    private $scheduleService;

    public function setup()
    {
        parent::setup();

        $this->page = new FakeSearchAvailabilityPage();
        $this->resourceService = new FakeResourceService();
        $this->reservationService = new FakeReservationService();
        $this->scheduleService = new FakeScheduleService();

        $this->presenter = new SearchAvailabilityPresenter($this->page,
            $this->fakeUser, $this->resourceService, $this->reservationService, $this->scheduleService);

        $this->resourceService->_AllResources = array(new TestResourceDto(1, '', true, 1), new TestResourceDto(3, '', true, 2));
    }

    public function testWhenNoResourcesSelected()
    {
        $this->page->_Resources = array();
        $this->page->_Hours = 1;
        $this->page->_Minutes = 0;
        $this->page->_Range = 'tomorrow';

        $resourceId = 1;

        $resource = new TestResourceDto($resourceId);
        $this->resourceService->_AllResources = array($resource);

        $date = Date::Now()->AddDays(1)->ToTimezone($this->fakeUser->Timezone)->GetDate();

        $tooShort1 = $this->GetEmpty($date, '00:00', '00:15');
        $tooShort1a = $this->GetEmpty($date, '00:15', '00:30');
        $oneHour1 = $this->GetEmpty($date, '00:30', '01:00');
        $oneHour2 = $this->GetEmpty($date, '01:00', '02:30');
        $reservation1 = $this->GetReservation($date, '02:30', '12:30');
        $reservation2 = $this->GetReservation($date, '12:30', '16:00');
        $twoHours1 = $this->GetEmpty($date, '16:00', '18:00');
        $reservation3 = $this->GetReservation($date, '18:30', '19:30');
        $tooShort2 = $this->GetEmpty($date, '19:30', '20:00');
        $blackout1 = $this->GetBlackout($date, '20:00', '21:00');
        $blackout2 = $this->GetBlackout($date, '21:00', '22:00');
        $twoHours2 = $this->GetEmpty($date, '22:00', '00:00');

        $reservations = array(
            $tooShort1,
            $tooShort1a,
            $oneHour1,
            $oneHour2,
            $reservation1,
            $reservation2,
            $twoHours1,
            $reservation3,
            $tooShort2,
            $blackout1,
            $blackout2,
            $twoHours2,
        );
        $dailyLayout = new FakeDailyLayout();
        $dailyLayout->_SetLayout($date, $resourceId, $reservations);
        $this->scheduleService->_DailyLayout = $dailyLayout;

        $this->presenter->SearchAvailability();

        $expectedOpenings = array(
            new AvailableOpeningView($resource, $tooShort1->BeginDate(), $oneHour1->EndDate()),
            new AvailableOpeningView($resource, $tooShort1a->BeginDate(), $oneHour2->EndDate()),
            new AvailableOpeningView($resource, $oneHour1->BeginDate(), $oneHour2->EndDate()),
            new AvailableOpeningView($resource, $oneHour2->BeginDate(), $oneHour2->EndDate()),
            new AvailableOpeningView($resource, $twoHours1->BeginDate(), $twoHours1->EndDate()),
            new AvailableOpeningView($resource, $twoHours2->BeginDate(), $twoHours2->EndDate()),
        );
        $expectedSearchRange = new DateRange($date->ToTimezone($this->fakeUser->Timezone), $date->ToTimezone($this->fakeUser->Timezone)->GetDate()->AddDays(1), $this->fakeUser->Timezone);

        $this->assertEquals(count($expectedOpenings), count($this->page->_Openings));
        $this->assertEquals($expectedOpenings, $this->page->_Openings);
        $this->assertEquals($expectedSearchRange, $this->reservationService->_LastDateRange);
    }

    public function testWhenThisWeekSelected()
    {
        $resourceId = 1;

        $tz = $this->fakeUser->Timezone;

        $resource = new FakeBookableResource($resourceId);
        $this->resourceService->_AllResources = array($resource);

        Date::_SetNow(Date::Parse('2016-07-09 12:00'));
        $this->page->_Range = 'thisweek';

        $dailyLayout = new FakeDailyLayout();
        $dailyLayout->_SetLayout(Date::Parse('2016-07-03', $tz), $resourceId, array());
        $dailyLayout->_SetLayout(Date::Parse('2016-07-04', $tz), $resourceId, array());
        $dailyLayout->_SetLayout(Date::Parse('2016-07-05', $tz), $resourceId, array());
        $dailyLayout->_SetLayout(Date::Parse('2016-07-06', $tz), $resourceId, array());
        $dailyLayout->_SetLayout(Date::Parse('2016-07-07', $tz), $resourceId, array());
        $dailyLayout->_SetLayout(Date::Parse('2016-07-08', $tz), $resourceId, array());
        $dailyLayout->_SetLayout(Date::Parse('2016-07-09', $tz), $resourceId, array());
        $this->scheduleService->_DailyLayout = $dailyLayout;

        $this->presenter->SearchAvailability();

        $expectedSearchRange = new DateRange(Date::Parse('2016-07-03', $this->fakeUser->Timezone), Date::Parse('2016-07-09', $this->fakeUser->Timezone));
        $this->assertEquals($expectedSearchRange, $this->reservationService->_LastDateRange);
    }

    /**
     * @param Date $date
     * @param string $start
     * @param string $end
     * @return EmptyReservationSlot
     */
    private function GetEmpty(Date $date, $start, $end)
    {
        return new EmptyReservationSlot(new SchedulePeriod($date->SetTimeString($start), $date->SetTimeString($end, true)), new SchedulePeriod($date->SetTimeString($start), $date->SetTimeString($end, true)), $date, true);
    }

    /**
     * @param Date $date
     * @param string $start
     * @param string $end
     * @return ReservationSlot
     */
    private function GetReservation(Date $date, $start, $end)
    {
        return new ReservationSlot(new SchedulePeriod($date->SetTimeString($start), $date->SetTimeString($end, true)),
            new SchedulePeriod($date->SetTimeString($start), $date->SetTimeString($end, true)),
            $date, 6, new TestReservationItemView(1, Date::Now(), Date::Now()));
    }

    /**
     * @param Date $date
     * @param string $start
     * @param string $end
     * @return ReservationSlot
     */
    private function GetBlackout(Date $date, $start, $end)
    {
        return new BlackoutSlot(new SchedulePeriod($date->SetTimeString($start), $date->SetTimeString($end, true)),
            new SchedulePeriod($date->SetTimeString($start), $date->SetTimeString($end, true)),
            $date, 6, new TestBlackoutItemView(1, Date::Now(), Date::Now(), 1));
    }
}

class FakeSearchAvailabilityPage extends SearchAvailabilityPage
{
    /**
     * @var int[]
     */
    public $_Resources = array();

    public $_Openings;

    /**
     * @var int
     */
    public $_Hours;

    /**
     * @var int
     */
    public $_Minutes;

    /**
     * @var string
     */
    public $_Range;

    public function SetResources($resources)
    {
    }

    public function SetResourceTypes($resourceTypes)
    {
    }

    public function ShowOpenings($openings)
    {
        $this->_Openings = $openings;
    }

    public function GetRequestedHours()
    {
        return $this->_Hours;
    }

    public function GetRequestedMinutes()
    {
        return $this->_Minutes;
    }

    public function GetRequestedRange()
    {
        return $this->_Range;
    }
}
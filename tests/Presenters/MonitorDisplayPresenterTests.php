<?php
/**
 * Copyright 2018 Nick Korbel
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

require_once(ROOT_DIR . 'Presenters/MonitorDisplayPresenter.php');

class MonitorDisplayPresenterTests extends TestBase
{
    /**
     * @var TestMonitorDisplayPage
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
     * @var MonitorDisplayPresenter
     */
    private $presenter;

    /**
     * @var FakeScheduleService
     */
    private $scheduleService;

    public function setup()
    {
        parent::setup();

        $this->page = new TestMonitorDisplayPage();
        $this->resourceService = new FakeResourceService();
        $this->scheduleService = new FakeScheduleService();
        $this->reservationService = new FakeReservationService();

        $this->presenter = new MonitorDisplayPresenter($this->page,
            $this->resourceService,
            $this->reservationService,
            $this->scheduleService,
            new ScheduleLayoutFactory());
    }

    public function testBindsConfigurationOptions()
    {
        $this->scheduleService->_AllSchedules = array(new FakeSchedule(1, '1', false), new FakeSchedule(2, '2', true));
        $this->resourceService->_ScheduleResources = array(new TestResourceDto(1), new TestResourceDto(2));

        $this->presenter->PageLoad();

        $this->assertEquals($this->scheduleService->_AllSchedules, $this->page->_Schedules);
        $this->assertEquals($this->resourceService->_ScheduleResources, $this->page->_Resources);
    }

    public function testRebindsResourcesForSchedule()
    {
        $this->page->_ScheduleId = 1;
        $this->resourceService->_ScheduleResources = array(new TestResourceDto(1, '1'), new TestResourceDto(2, '2'));

        $this->presenter->ProcessDataRequest('resources');

        $this->assertEquals(array(array('id' => 1, 'name' => '1'), array('id' => 2, 'name' => '2')), $this->page->_ReBoundResources);
    }

    public function testShowsSchedule()
    {
        $timezone = 'America/Chicago';
        $this->page->_ScheduleId = 1;
        $this->page->_ResourceId = 2;
        $this->page->_DaysToView = 5;
        $this->page->_Format = 1;

        $this->scheduleService->_Layout = new FakeScheduleLayout();

        $this->scheduleService->_DailyLayout = new FakeDailyLayout();
        $this->scheduleService->_DailyLayout->_Timezone = $timezone;

        $range = new DateRange(Date::Now()->ToTimezone($timezone)->GetDate(), Date::Now()->ToTimezone($timezone)->GetDate()->AddDays(5));

        $this->presenter->ProcessDataRequest('schedule');

        $this->assertEquals($range, $this->reservationService->_LastDateRange);
        $this->assertEquals($range, $this->page->_DateRange);
        $this->assertEquals($this->scheduleService->_DailyLayout, $this->page->_DailyLayout);
        $this->assertEquals($this->resourceService->_ScheduleResources, $this->page->_Resources);
    }
}

class TestMonitorDisplayPage extends MonitorDisplayPage
{
    /**
     * @var Schedule[]
     */
    public $_Schedules;

    /**
     * @var ResourceDto[]
     */
    public $_Resources;

    /**
     * @var int
     */
    public $_ScheduleId;

    /**
     * @var ResourceDto[]
     */
    public $_ReBoundResources;

    /**
     * @var int
     */
    public $_ResourceId;

    /**
     * @var int
     */
    public $_DaysToView;

    /**
     * @var int
     */
    public $_Format;

    /**
     * @var IDailyLayout
     */
    public $_DailyLayout;

    /**
     * @var DateRange
     */
    public $_DateRange;

    public function BindSchedules($schedules)
    {
        $this->_Schedules = $schedules;
    }

    public function BindResources($resources)
    {
        $this->_Resources = $resources;
    }

    public function RebindResources($resources)
    {
        $this->_ReBoundResources = $resources;
    }

    public function RebindSchedule(DateRange $range, IDailyLayout $layout, $resources)
    {
       $this->_DateRange = $range;
       $this->_DailyLayout = $layout;
       $this->_Resources = $resources;
    }

    public function GetDaysToView()
    {
        return $this->_DaysToView;
    }
}
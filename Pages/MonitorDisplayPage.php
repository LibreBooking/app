<?php

/**
 * Copyright 2017-2019 Nick Korbel
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

interface IMonitorDisplayPage extends IPage, IActionPage
{
    /**
     * @param Schedule[] $schedules
     */
    public function BindSchedules($schedules);

    /**
     * @param ResourceDto[] $resources
     */
    public function BindResources($resources);

    /**
     * @return int
     */
    public function GetScheduleId();

    /**
     * @return int
     */
    public function GetDaysToView();

    /**
     * @return int
     */
    public function GetResourceId();

    /**
     * @return string
     */
    public function GetFormat();

    /**
     * @param ResourceDto[] $resources
     */
    public function RebindResources($resources);

    /**
     * @param DateRange $range
     * @param IDailyLayout $layout
     * @param ResourceDto[] $resources
     * @param int $format
     */
    public function RebindSchedule(DateRange $range, IDailyLayout $layout, $resources, $format);

}

class MonitorDisplayPage extends ActionPage implements IMonitorDisplayPage
{
    /**
     * @var MonitorDisplayPresenter
     */
    private $presenter;

    public function __construct()
    {
        parent::__construct('Schedule');
        $resourceService = new ResourceService(new ResourceRepository(), new GuestPermissionService(), new AttributeService(new AttributeRepository()), new UserRepository(), new AccessoryRepository());
        $this->presenter = new MonitorDisplayPresenter($this,
            $resourceService,
            new ReservationService(new ReservationViewRepository(), new ReservationListingFactory()),
            new ScheduleService(new ScheduleRepository(), $resourceService, new DailyLayoutFactory()),
            new ScheduleLayoutFactory());

        $this->Set('PopupMonths', $this->IsMobile ? 1 : 3);
        $this->Set('Enabled', $this->IsEnabled());
    }

    public function ProcessAction()
    {
        if ($this->IsEnabled()) {
            $this->presenter->ProcessAction();
        }
    }

    public function ProcessDataRequest($dataRequest)
    {
        if ($this->IsEnabled()) {
            $this->presenter->ProcessDataRequest($dataRequest);
        }
    }

    public function ProcessPageLoad()
    {
        $this->presenter->PageLoad();
        $this->Display('MonitorDisplay/monitor-display.tpl');
    }

    public function BindSchedules($schedules)
    {
        $this->Set('Schedules', $schedules);
    }

    public function BindResources($resources)
    {
        $this->Set('Resources', $resources);
    }

    public function RebindResources($resources)
    {
        $this->SetJson($resources);
    }

    public function RebindSchedule(DateRange $range, IDailyLayout $layout, $resources, $format)
    {
        $this->Set('DisplaySlotFactory', new DisplaySlotFactory());
        $this->Set('BoundDates', $range->Dates());
        $this->Set('DailyLayout', $layout);
        $this->Set('Resources', $resources);
        $this->Set('Format', $format);
        $this->Display('MonitorDisplay/monitor-display-schedule.tpl');
    }

    public function GetScheduleId()
    {
        $id = $this->GetQuerystring(QueryStringKeys::SCHEDULE_ID);
        if (empty($id)) {
            $id = $this->GetForm(FormKeys::SCHEDULE_ID);
        }

        return $id;
    }

    public function GetDaysToView()
    {
        return $this->GetQuerystring(QueryStringKeys::DAY);
    }

    public function GetResourceId()
    {
        return $this->GetQuerystring(QueryStringKeys::RESOURCE_ID);
    }

    public function GetFormat()
    {
        return $this->GetQuerystring(QueryStringKeys::FORMAT);
    }

    /**
     * @return mixed|string
     */
    private function IsEnabled()
    {
        return Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY, ConfigKeys::PRIVACY_VIEW_SCHEDULES, new BooleanConverter());
    }
}
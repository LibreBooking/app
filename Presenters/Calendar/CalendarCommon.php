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

interface ICommonCalendarPage
{
    public function GetDay();

    public function GetMonth();

    public function GetYear();

    public function GetCalendarType();

    /**
     * @param CalendarReservation[] $reservationList
     */
    public function BindEvents($reservationList);

    /**
     * @return string
     */
    public function GetStartDate();

    /**
     * @return string
     */
    public function GetEndDate();
}

class CalendarCommon
{
    /**
     * @var ICommonCalendarPage
     */
    private $page;
    /**
     * @var ICalendarFactory
     */
    private $calendarFactory;
    /**
     * @var IReservationViewRepository
     */
    private $reservationRepository;
    /**
     * @var IScheduleRepository
     */
    private $scheduleRepository;
    /**
     * @var IResourceService
     */
    private $resourceService;

    public function __construct(ICommonCalendarPage $page,
                                IReservationViewRepository $reservationRepository,
                                IScheduleRepository $scheduleRepository,
                                IResourceService $resourceService,
                                ICalendarFactory $calendarFactory)
    {
        $this->page = $page;
        $this->calendarFactory = $calendarFactory;
        $this->reservationRepository = $reservationRepository;
        $this->scheduleRepository = $scheduleRepository;
        $this->resourceService = $resourceService;
    }

    public function GetAllResources($userSession)
    {
        $showInaccessible = Configuration::Instance()->GetSectionKey(ConfigSection::SCHEDULE, ConfigKeys::SCHEDULE_SHOW_INACCESSIBLE_RESOURCES, new BooleanConverter());
        $resources = $this->resourceService->GetAllResources($showInaccessible, $userSession);
        return $resources;
    }

    /**
     * @param array|Schedule[] $schedules
     * @return Schedule
     */
    public function GetSelectedSchedule($schedules)
    {
        if (empty($schedules))
        {
            $schedules = $this->scheduleRepository->GetAll();
        }

        $default = new NullSchedule();
        $scheduleId = $this->page->GetScheduleId();

        /** @var $schedule Schedule */
        foreach ($schedules as $schedule)
        {
            if (!empty($scheduleId) && $schedule->GetId() == $scheduleId)
            {
                return $schedule;
            }
        }

        return $default;
    }

    public function GetStartDate()
    {
        $timezone = ServiceLocator::GetServer()->GetUserSession()->Timezone;

        $startDate = $this->page->GetStartDate();

        if (empty($startDate))
        {
            return Date::Now()->ToTimezone($timezone);
        }
        return Date::Parse($startDate, $timezone);
    }

    public function GetEndDate()
    {
        $timezone = ServiceLocator::GetServer()->GetUserSession()->Timezone;

        $endDate = $this->page->GetEndDate();

        return Date::Parse($endDate, $timezone);
    }
}
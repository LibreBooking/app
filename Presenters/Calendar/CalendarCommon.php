<?php
/**
 * Copyright 2017 Nick Korbel
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

interface ICommonCalendarPage extends IActionPage
{
    /**
     * @return string
     */
    public function GetDay();

    /**
     * @return string
     */
    public function GetMonth();

    /**
     * @return string
     */
    public function GetYear();

    /**
     * @return string
     */
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

    /**
     * @param ResourceGroup $selectedGroup
     */
    public function BindSelectedGroup($selectedGroup);

    /**
     * @param int $firstDay
     */
    public function SetFirstDay($firstDay);

    /**
     * @param CalendarSubscriptionDetails $subscriptionDetails
     */
    public function BindSubscription(CalendarSubscriptionDetails $subscriptionDetails);

    /**
     * @param Date $displayDate
     */
    public function SetDisplayDate($displayDate);

    /**
     * @param string $calendarType
     */
    public function BindCalendarType($calendarType);

    /**
     * @param CalendarFilters $filters
     */
    public function BindFilters($filters);

    /**
     * @return null|int
     */
    public function GetScheduleId();

    /**
     * @return null|int
     */
    public function GetResourceId();

    /**
     * @return null|int
     */
    public function GetGroupId();

    /**
     * @param $scheduleId null|int
     */
    public function SetScheduleId($scheduleId);

    /**
     * @param $resourceId null|int
     */
    public function SetResourceId($resourceId);

    public function RenderSubscriptionDetails();
}

abstract class CommonCalendarPage extends ActionPage implements ICommonCalendarPage
{

    public function GetDay()
    {
        return $this->GetQuerystring(QueryStringKeys::DAY);
    }

    public function GetMonth()
    {
        return $this->GetQuerystring(QueryStringKeys::MONTH);
    }

    public function GetYear()
    {
        return $this->GetQuerystring(QueryStringKeys::YEAR);
    }

    public function GetCalendarType()
    {
        return $this->GetQuerystring(QueryStringKeys::CALENDAR_TYPE);
    }

    public function BindCalendarType($calendarType)
    {
        $calendarType = empty($calendarType) ? 'month' : $calendarType;
        $this->Set('CalendarType', $calendarType);
    }

    /**
     * @param Date $displayDate
     * @return void
     */
    public function SetDisplayDate($displayDate)
    {
        $this->Set('DisplayDate', $displayDate);

        $months = Resources::GetInstance()->GetMonths('full');
        $this->Set('MonthName', $months[$displayDate->Month() - 1]);
        $this->Set('MonthNames', $months);
        $this->Set('MonthNamesShort', Resources::GetInstance()->GetMonths('abbr'));

        $days = Resources::GetInstance()->GetDays('full');
        $this->Set('DayName', $days[$displayDate->Weekday()]);
        $this->Set('DayNames', $days);
        $this->Set('DayNamesShort', Resources::GetInstance()->GetDays('abbr'));
    }

    /**
     * @param CalendarFilters $filters
     * @return void
     */
    public function BindFilters($filters)
    {
        $this->Set('filters', $filters);
        $this->Set('IsAccessible', !$filters->IsEmpty());
        $this->Set('ResourceGroupsAsJson', json_encode($filters->GetResourceGroupTree()->GetGroups(false)));;
    }

    public function GetScheduleId()
    {
        return $this->GetQuerystring(QueryStringKeys::SCHEDULE_ID);
    }

    public function GetResourceId()
    {
        return $this->GetQuerystring(QueryStringKeys::RESOURCE_ID);
    }

    public function GetGroupId()
    {
        return $this->GetQuerystring(QueryStringKeys::GROUP_ID);
    }

    /**
     * @param $scheduleId null|int
     * @return void
     */
    public function SetScheduleId($scheduleId)
    {
        $this->Set('ScheduleId', $scheduleId);
    }

    /**
     * @param $resourceId null|int
     * @return void
     */
    public function SetResourceId($resourceId)
    {
        $this->Set('ResourceId', $resourceId);
    }

    /**
     * @param CalendarSubscriptionDetails $details
     */
    public function BindSubscription(CalendarSubscriptionDetails $details)
    {
        $this->Set('IsSubscriptionAllowed', $details->IsAllowed());
        $this->Set('IsSubscriptionEnabled', $details->IsEnabled());
        $this->Set('SubscriptionUrl', $details->Url());
    }

    /**
     * @param int $firstDay
     */
    public function SetFirstDay($firstDay)
    {
        $this->Set('FirstDay', $firstDay == Schedule::Today ? 0 : $firstDay);
    }

    /**
     * @param ResourceGroup $selectedGroup
     */
    public function BindSelectedGroup($selectedGroup)
    {
        $this->Set('GroupName', $selectedGroup->name);
        $this->Set('SelectedGroupNode', $selectedGroup->id);
        $this->Set('GroupId', $selectedGroup->id);
    }

    public function BindEvents($reservationList)
    {
        $events = array();
        foreach ($reservationList as $r) {
            $events[] = $r->AsFullCalendarEvent();
        }

        $this->SetJson($events);
    }


    public function GetStartDate()
    {
        return $this->GetQuerystring(QueryStringKeys::START);
    }

    public function GetEndDate()
    {
        return $this->GetQuerystring(QueryStringKeys::END);
    }
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
     * @param int $scheduleId
     * @return Schedule
     */
    public function GetSelectedSchedule($schedules, $scheduleId)
    {
        if (empty($schedules))
        {
            $schedules = $this->scheduleRepository->GetAll();
        }

        $default = new NullSchedule();

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

class UserCalendarFilter
{
    public $ResourceId;
    public $ScheduleId;
    public $GroupId;

    public function __construct($resourceId, $scheduleId, $groupId)
    {

        $this->ResourceId = $resourceId;
        $this->ScheduleId = $scheduleId;
        $this->GroupId = $groupId;
    }

    /**
     * @return string
     */
    public function Serialize()
    {
       return "{$this->ResourceId}|{$this->ScheduleId}|{$this->GroupId}";
    }

    /**
     * @param string $string
     * @return UserCalendarFilter
     */
    public static function Deserialize($string)
    {
        $parts = explode('|', $string);
        return new UserCalendarFilter($parts[0], $parts[1], $parts[2]);
    }
}
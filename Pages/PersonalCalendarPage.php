<?php
/**
 * Copyright 2011-2016 Nick Korbel
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

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/Calendar/PersonalCalendarPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/CalendarSubscriptionService.php');

interface IPersonalCalendarPage extends IActionPage, ICommonCalendarPage
{
	public function BindSubscription(CalendarSubscriptionDetails $details);

	public function SetDisplayDate($displayDate);

	/**
	 * @param CalendarFilters $filters
	 * @return void
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
	 * @param $scheduleId null|int
	 * @return void
	 */
	public function SetScheduleId($scheduleId);

	/**
	 * @param $resourceId null|int
	 * @return void
	 */
	public function SetResourceId($resourceId);

	/**
	 * @param int $firstDay
	 */
	public function SetFirstDay($firstDay);

	/**
	 * @param ResourceGroup $selectedGroup
	 */
	public function BindSelectedGroup($selectedGroup);

    public function BindCalendarType($calendarType);

    public function RenderSubscriptionDetails();

    /**
     * @return null|int
     */
    public function GetGroupId();
}

class PersonalCalendarPage extends ActionPage implements IPersonalCalendarPage
{
	/**
	 * @var string
	 */
	private $template;

	/**
	 * @var PersonalCalendarPresenter
	 */
	private $presenter;

	public function __construct()
	{
		parent::__construct('MyCalendar', 0);

		$userRepository = new UserRepository();
		$subscriptionService = new CalendarSubscriptionService($userRepository, new ResourceRepository(), new ScheduleRepository());
		$resourceRepository = new ResourceRepository();
		$resourceService = new ResourceService($resourceRepository,
											   PluginManager::Instance()->LoadPermission(),
											   new AttributeService(new AttributeRepository()),
											   $userRepository,
											   new AccessoryRepository());

		$this->presenter = new PersonalCalendarPresenter(
				$this,
				new ReservationViewRepository(),
				new CalendarFactory(),
				$subscriptionService,
				$userRepository,
				$resourceService,
				new ScheduleRepository());
	}

	public function ProcessPageLoad()
	{
		$user = ServiceLocator::GetServer()->GetUserSession();
		$this->presenter->PageLoad($user);

		$this->Set('HeaderLabels', Resources::GetInstance()->GetDays('full'));
		$this->Set('Today', Date::Now()->ToTimezone($user->Timezone));
		$this->Set('TimeFormat', Resources::GetInstance()->GetDateFormat('calendar_time'));
		$this->Set('DateFormat', Resources::GetInstance()->GetDateFormat('calendar_dates'));

		$this->Display('Calendar/mycalendar.tpl');
	}

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
        $this->Set('CalendarType',$calendarType);
    }

    public function GetGroupId()
    {
        return $this->GetQuerystring(QueryStringKeys::GROUP_ID);
    }

	/**
	 * @param $displayDate Date
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
	 * @return void
	 */
	public function ProcessAction()
	{
		$this->presenter->ProcessAction();
	}

	public function ProcessDataRequest($dataRequest)
	{
		$this->presenter->ProcessDataRequest($dataRequest);
	}

	public function BindSubscription(CalendarSubscriptionDetails $details)
	{
		$this->Set('IsSubscriptionAllowed', $details->IsAllowed());
		$this->Set('IsSubscriptionEnabled', $details->IsEnabled());
		$this->Set('SubscriptionUrl', $details->Url());
	}

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

	public function SetScheduleId($scheduleId)
	{
		$this->Set('ScheduleId', $scheduleId);
	}

	public function SetResourceId($resourceId)
	{
		$this->Set('ResourceId', $resourceId);
	}

	public function SetFirstDay($firstDay)
	{
		$this->Set('FirstDay', $firstDay == Schedule::Today ? 0 : $firstDay);
	}

	public function BindSelectedGroup($selectedGroup)
	{
		$this->Set('GroupName', $selectedGroup->name);
		$this->Set('SelectedGroupNode', $selectedGroup->id);
	}

    public function BindEvents($reservationList)
    {
        $events = array();
        foreach ($reservationList as $r)
        {
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

    public function RenderSubscriptionDetails()
    {
        $this->Display('Calendar/mycalendar.subscription.tpl');
    }
}

class PersonalCalendarUrl
{
	private $url;

	private function __construct($year, $month, $day, $type)
	{
		$resourceId = ServiceLocator::GetServer()->GetQuerystring(QueryStringKeys::RESOURCE_ID);
		$scheduleId = ServiceLocator::GetServer()->GetQuerystring(QueryStringKeys::SCHEDULE_ID);

		$format = Pages::MY_CALENDAR . '?'
				. QueryStringKeys::DAY . '=%d&'
				. QueryStringKeys::MONTH . '=%d&'
				. QueryStringKeys::YEAR
				. '=%d&'
				. QueryStringKeys::CALENDAR_TYPE . '=%s&'
				. QueryStringKeys::RESOURCE_ID . '=%s&'
				. QueryStringKeys::SCHEDULE_ID . '=%s';

		$this->url = sprintf($format, $day, $month, $year, $type, $resourceId, $scheduleId);
	}

	/**
	 * @static
	 * @param $date Date
	 * @param $type string
	 * @return PersonalCalendarUrl
	 */
	public static function Create($date, $type)
	{
		return new PersonalCalendarUrl($date->Year(), $date->Month(), $date->Day(), $type);
	}

	public function __toString()
	{
		return $this->url;
	}
}
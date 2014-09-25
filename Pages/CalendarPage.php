<?php
/**
Copyright 2011-2014 Nick Korbel

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

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/Calendar/CalendarPresenter.php');


interface ICalendarPage extends IPage
{
	public function GetDay();

	public function GetMonth();

	public function GetYear();

	public function GetCalendarType();

	public function BindCalendar(ICalendarSegment $calendar);

	/**
	 * @param CalendarFilters $filters
	 * @return void
	 */
	public function BindFilters($filters);

	/**
	 * @param Date $displayDate
	 * @return void
	 */
	public function SetDisplayDate($displayDate);

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
	 * @return void
	 */
	public function SetScheduleId($scheduleId);

	/**
	 * @param $resourceId null|int
	 * @return void
	 */
	public function SetResourceId($resourceId);

	/**
	 * @param CalendarSubscriptionDetails $subscriptionDetails
	 */
	public function BindSubscription($subscriptionDetails);

	/**
	 * @param int $firstDay
	 */
	public function SetFirstDay($firstDay);

	/**
	 * @param ResourceGroup $selectedGroup
	 */
	public function BindSelectedGroup($selectedGroup);
}

class CalendarPage extends SecurePage implements ICalendarPage
{
	/**
	 * @var string
	 */
	private $template;

	public function __construct()
	{
		parent::__construct('ResourceCalendar');
		$resourceRepository = new ResourceRepository();
		$scheduleRepository = new ScheduleRepository();
		$userRepository = new UserRepository();
		$resourceService = new ResourceService($resourceRepository, PluginManager::Instance()->LoadPermission(), new AttributeService(new AttributeRepository()), $userRepository);
		$subscriptionService = new CalendarSubscriptionService($userRepository, $resourceRepository, $scheduleRepository);
		$privacyFilter = new PrivacyFilter(new ReservationAuthorization(PluginManager::Instance()->LoadAuthorization()));
		$this->_presenter = new CalendarPresenter($this,
												  new CalendarFactory(),
												  new ReservationViewRepository(),
												  $scheduleRepository,
												  $resourceService,
												  $subscriptionService,
												  $privacyFilter);
	}

	public function PageLoad()
	{
		$user = ServiceLocator::GetServer()->GetUserSession();
		$this->_presenter->PageLoad($user, $user->Timezone);

		$this->Set('HeaderLabels', Resources::GetInstance()->GetDays('full'));
		$this->Set('Today', Date::Now()->ToTimezone($user->Timezone));
		$this->Set('TimeFormat', Resources::GetInstance()->GetDateFormat('calendar_time'));
		$this->Set('DateFormat', Resources::GetInstance()->GetDateFormat('calendar_dates'));

		$this->Display('Calendar/' . $this->template);
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

	public function BindCalendar(ICalendarSegment $calendar)
	{
		$this->Set('Calendar', $calendar);

		$prev = $calendar->GetPreviousDate();
		$next = $calendar->GetNextDate();

		$calendarType = $calendar->GetType();

		$this->Set('PrevLink', CalendarUrl::Create($prev, $calendarType));
		$this->Set('NextLink', CalendarUrl::Create($next, $calendarType));

		$this->template = sprintf('calendar.%s.tpl', strtolower($calendarType));
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
	public function BindSubscription($details)
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
	}
}

class CalendarUrl
{
	private $url;

	private function __construct($year, $month, $day, $type)
	{
		// TODO: figure out how to get these values without coupling to the query string
		$resourceId = ServiceLocator::GetServer()->GetQuerystring(QueryStringKeys::RESOURCE_ID);
		$scheduleId = ServiceLocator::GetServer()->GetQuerystring(QueryStringKeys::SCHEDULE_ID);

		$format = Pages::CALENDAR . '?'
				. QueryStringKeys::DAY . '=%d&'
				. QueryStringKeys::MONTH . '=%d&'
				. QueryStringKeys::YEAR . '=%d&'
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
		return new CalendarUrl($date->Year(), $date->Month(), $date->Day(), $type);
	}

	public function __toString()
	{
		return $this->url;
	}
}
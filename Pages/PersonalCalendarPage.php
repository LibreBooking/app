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
require_once(ROOT_DIR . 'Presenters/PersonalCalendarPresenter.php');

interface IPersonalCalendarPage extends IActionPage
{
	public function GetDay();
	public function GetMonth();
	public function GetYear();
	public function GetCalendarType();

	public function BindCalendar(ICalendarSegment $calendar);
    public function BindSubscription(CalendarSubscriptionDetails $details);

	public function SetDisplayDate($displayDate);
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
        $this->presenter = new PersonalCalendarPresenter($this, new ReservationViewRepository(), new CalendarFactory(), $subscriptionService, $userRepository);
	}

	public function ProcessPageLoad()
	{
		$user = ServiceLocator::GetServer()->GetUserSession();
		$this->presenter->PageLoad($user->UserId, $user->Timezone);

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

		$this->Set('PrevLink', PersonalCalendarUrl::Create($prev, $calendarType));
		$this->Set('NextLink', PersonalCalendarUrl::Create($next, $calendarType));

		$this->template = sprintf('mycalendar.%s.tpl', strtolower($calendarType));
	}

	/**
	 * @param $displayDate Date
	 * @return void
	 */
	public function SetDisplayDate($displayDate)
	{
		$this->Set('DisplayDate', $displayDate);

		$months = Resources::GetInstance()->GetMonths('full');
		$this->Set('MonthName', $months[$displayDate->Month()-1]);
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
        // no-op
    }

    public function BindSubscription(CalendarSubscriptionDetails $details)
    {
        $this->Set('IsSubscriptionAllowed', $details->IsAllowed());
        $this->Set('IsSubscriptionEnabled', $details->IsEnabled());
        $this->Set('SubscriptionUrl', $details->Url());
    }
}

class PersonalCalendarUrl
{
	private $url;

	private function __construct($year, $month, $day, $type)
	{
		$format = Pages::MY_CALENDAR . '?' . QueryStringKeys::DAY . '=%d&' . QueryStringKeys::MONTH . '=%d&' . QueryStringKeys::YEAR . '=%d&' . QueryStringKeys::CALENDAR_TYPE . '=%s';

		$this->url = sprintf($format, $day, $month, $year, $type);
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
?>
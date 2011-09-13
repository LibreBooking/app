<?php
require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/CalendarPresenter.php');


interface ICalendarPage extends IPage
{
	public function GetDay();
	public function GetMonth();
	public function GetYear();
	public function GetCalendarType();

	public function BindCalendar(ICalendarSegment $calendar);

	/**
	 * @abstract
	 * @param CalendarFilters $filters
	 * @return void
	 */
	public function BindFilters($filters);

	/**
	 * @abstract
	 * @param Date $displayDate
	 * @return void
	 */
	public function SetDisplayDate($displayDate);

	/**
	 * @abstract
	 * @return null|int
	 */
	public function GetScheduleId();

	/**
	 * @abstract
	 * @return null|int
	 */
	public function GetResourceId();

	/**
	 * @abstract
	 * @param $scheduleId null|int
	 * @return void
	 */
	public function SetScheduleId($scheduleId);

	/**
	 * @abstract
	 * @param $resourceId null|int
	 * @return void
	 */
	public function SetResourceId($resourceId);
}

class CalendarPage extends SecurePage implements ICalendarPage
{
	/**
	 * @var string
	 */
	private $template;

	public function __construct()
	{
		parent::__construct('Calendar');
		
		$this->_presenter = new CalendarPresenter($this, new CalendarFactory(),  new ReservationRepository(), new ScheduleRepository(), new ResourceRepository());
	}
	
	public function PageLoad()
	{
		$user = ServiceLocator::GetServer()->GetUserSession();
		$this->_presenter->PageLoad($user->UserId, $user->Timezone);

		$this->Set('HeaderLabels', Resources::GetInstance()->GetDays('full'));
		$this->Set('Today', Date::Now()->ToTimezone($user->Timezone));
		
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
		$this->Set('MonthName', $months[$displayDate->Month()-1]);
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
	}

	public function GetScheduleId()
	{
		return $this->GetQuerystring(QueryStringKeys::SCHEDULE_ID);
	}

	public function GetResourceId()
	{
		return $this->GetQuerystring(QueryStringKeys::RESOURCE_ID);
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
?>
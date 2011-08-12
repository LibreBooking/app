<?php
require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/PersonalCalendarPresenter.php');

interface IPersonalCalendarPage
{
	public function GetDay();
	public function GetMonth();
	public function GetYear();

	public function BindCalendar(ICalendarSegment $calendar);

	public function SetDay($day);
	public function SetMonth($month);
	public function SetYear($year);

	public function GetCalendarType();
}

class PersonalCalendarPage extends SecurePage implements IPersonalCalendarPage
{
	/**
	 * @var string
	 */
	private $template;

	public function __construct()
	{
	    parent::__construct('MyCalendar');
	}

	public function PageLoad()
	{
		$presenter = new PersonalCalendarPresenter($this, new ReservationViewRepository(), new CalendarFactory());
		$user = ServiceLocator::GetServer()->GetUserSession();
		$presenter->PageLoad($user->UserId, $user->Timezone);

		$this->Set('HeaderLabels', Resources::GetInstance()->GetDays('full'));

		$this->Display($this->template);
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

	public function BindCalendar(ICalendarSegment $calendar)
	{
		$this->Set('Calendar', $calendar);

		$prev = $calendar->GetPreviousDate();
		$next = $calendar->GetNextDate();

		$this->Set('PrevLink', CalendarUrl::Create($prev, $calendar->GetType())->__toString());
		$this->Set('NextLink',CalendarUrl::Create($next, $calendar->GetType())->__toString());

		$this->template = sprintf('mycalendar.%s.tpl', strtolower($calendar->GetType()));
	}

	public function SetDay($day)
	{
		$this->Set('Day', $day);
	}
	
	public function SetMonth($month)
	{
		$months = Resources::GetInstance()->GetMonths('full');
		$this->Set('MonthName', $months[$month-1]);
	}

	public function SetYear($year)
	{
		$this->Set('Year', $year);
	}

	public function GetCalendarType()
	{
		return $this->GetQuerystring(QueryStringKeys::CALENDAR_TYPE);
	}
}


class CalendarUrl
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
	 * @return CalendarUrl
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

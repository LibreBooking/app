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

	public function SetPreviousDay($day);
	public function SetPreviousMonth($month);
	public function SetPreviousYear($year);

	public function SetNextDay($day);
	public function SetNextMonth($month);
	public function SetNextYear($year);

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

	public function SetPreviousDay($day)
	{
		$this->Set('PrevDay', $day);
	}

	public function SetPreviousMonth($month)
	{
		$this->Set('PrevMonth', $month);
	}

	public function SetPreviousYear($year)
	{
		$this->Set('PrevYear', $year);
	}

	public function SetNextDay($day)
	{
		$this->Set('NextDay', $day);
	}
	
	public function SetNextMonth($month)
	{
		$this->Set('NextMonth', $month);
	}

	public function SetNextYear($year)
	{
		$this->Set('NextYear', $year);
	}

	public function GetCalendarType()
	{
		return $this->GetQuerystring(QueryStringKeys::CALENDAR_TYPE);
	}
}

?>

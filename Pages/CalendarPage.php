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
	 * @param array|CalendarFilters[] $filters
	 * @return void
	 */
	public function BindFilters($filters);

	public function SetDisplayDate($displayDate);

	public function GetScheduleId();
	public function GetResourceId();
}

class CalendarPage extends SecurePage implements ICalendarPage
{
	public function __construct()
	{
		parent::__construct('Calendar');
		
		$this->_presenter = new CalendarPresenter($this);			
	}
	
	public function PageLoad()
	{
		$user = ServiceLocator::GetServer()->GetUserSession();
		$this->_presenter->PageLoad($user->UserId, $user->Timezone);
	}

	public function GetDay()
	{
		// TODO: Implement GetDay() method.
	}

	public function GetMonth()
	{
		// TODO: Implement GetMonth() method.
	}

	public function GetYear()
	{
		// TODO: Implement GetYear() method.
	}

	public function GetCalendarType()
	{
		// TODO: Implement GetCalendarType() method.
	}

	public function BindCalendar(ICalendarSegment $calendar)
	{
		// TODO: Implement BindCalendar() method.
	}

	public function SetDisplayDate($displayDate)
	{
		// TODO: Implement SetDisplayDate() method.
	}

	/**
	 * @param array|CalendarFilters[] $filters
	 * @return void
	 */
	public function BindFilters($filters)
	{
		// TODO: Implement BindFilters() method.
	}

	public function GetScheduleId()
	{
		// TODO: Implement GetScheduleId() method.
	}

	public function GetResourceId()
	{
		// TODO: Implement GetResourceId() method.
	}
}
?>
<?php
require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/PersonalCalendarPresenter.php');

interface IPersonalCalendarPage
{
	function GetMonth();
	function GetYear();

	function Bind(CalendarMonth $month);
}

class PersonalCalendarPage extends SecurePage implements IPersonalCalendarPage
{
	public function __construct()
	{
	    parent::__construct('MyCalendar');
	}

	public function PageLoad()
	{
		$presenter = new PersonalCalendarPresenter($this);
		$user = ServiceLocator::GetServer()->GetUserSession();
		$presenter->PageLoad($user->UserId, $user->Timezone);

		$this->Set('HeaderLabels', Resources::GetInstance()->GetDays('full'));
		$this->Display('mycalendar.tpl');
	}



	public function GetMonth()
	{
		return 8;
	}

	public function GetYear()
	{
		return 2011;
	}

	public function Bind(CalendarMonth $month)
	{
		$this->Set('Month', $month);
	}
}

?>

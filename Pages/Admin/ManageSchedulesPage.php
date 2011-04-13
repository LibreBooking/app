<?php 
require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageSchedulesPresenter.php');
require_once(ROOT_DIR . 'Domain/Access/ScheduleRepository.php');

interface IUpdateSchedulePage
{	
	/**
	 * @return int
	 */
	function GetScheduleId();
	
	/**
	 * @return string
	 */
	function GetScheduleName();
	
	/**
	 * @return string
	 */
	function GetStartDay();
	
	/**
	 * @return string
	 */
	function GetDaysVisible();
	
	/**
	 * @return string
	 */
	function GetReservableSlots();
	
	/**
	 * @return string
	 */
	function GetBlockedSlots();
	
	/**
	 * @return string
	 */
	function GetLayoutTimezone();
	
	/**
	 * @return string
	 */
	function GetSourceScheduleId();
}


interface IManageSchedulesPage extends IUpdateSchedulePage
{
	/**
	 * @param Schedule[] $schedules 
	 * @param array $layouts 
	 */
	function BindSchedules($schedules, $layouts);
	
	function SetTimezones($timezoneValues, $timezoneOutput);
}

class ManageSchedulesPage extends AdminPage implements IManageSchedulesPage
{
	public function __construct()
	{
		parent::__construct('ManageSchedules');
		$this->_presenter = new ManageSchedulesPresenter($this, new ScheduleRepository());
	}
	
	public function PageLoad()
	{
		$this->_presenter->PageLoad();
		
		$daynames = Resources::GetInstance()->GetDays('full');
		$this->Set('DayNames', $daynames);
		$this->Display('manage_schedules.tpl');		
	}
	
	public function ProcessAction()
	{
		$this->_presenter->ProcessAction();
	}
	
	public function SetTimezones($timezoneValues, $timezoneOutput)
	{
		$this->Set('TimezoneValues', $timezoneValues);
		$this->Set('TimezoneOutput', $timezoneOutput);
	}
	
	public function BindSchedules($schedules, $layouts)
	{
		$this->Set('Schedules', $schedules);
		$this->Set('Layouts', $layouts);
	}
	
	public function GetScheduleId()
	{
		return $this->server->GetQuerystring(QueryStringKeys::SCHEDULE_ID);
	}
	
	public function GetScheduleName()
	{
		return $this->server->GetForm(FormKeys::SCHEDULE_NAME);
	}
	
	function GetStartDay()
	{
		return $this->server->GetForm(FormKeys::SCHEDULE_WEEKDAY_START);
	}
	
	function GetDaysVisible()
	{
		return $this->server->GetForm(FormKeys::SCHEDULE_DAYS_VISIBLE);
	}
	
	public function GetReservableSlots()
	{
		return $this->server->GetForm(FormKeys::SLOTS_RESERVABLE);
	}
	
	public function GetBlockedSlots()
	{
		return $this->server->GetForm(FormKeys::SLOTS_BLOCKED);
	}
	
	public function GetLayoutTimezone()
	{
		return $this->server->GetForm(FormKeys::TIMEZONE);
	}
	
	public function GetSourceScheduleId()
	{
		return $this->server->GetForm(FormKeys::SCHEDULE_ID);
	}
}

?>
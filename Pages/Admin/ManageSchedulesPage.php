<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/
 
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
	 * @return int
	 */
	function GetSourceScheduleId();

    /**
     * @return int
     */
    function GetTargetScheduleId();
}


interface IManageSchedulesPage extends IUpdateSchedulePage, IActionPage
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
		$this->_presenter = new ManageSchedulesPresenter($this, new ManageScheduleService(new ScheduleRepository(), new ResourceRepository()));
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

    public function GetTargetScheduleId()
    {
        return $this->server->GetForm(FormKeys::SCHEDULE_ID);
    }
}

?>
<?php
require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/SchedulePresenter.php');

class SchedulePage extends SecurePage implements ISchedulePage
{
	public function __construct()
	{
		parent::__construct('Schedule');
		$this->_presenter = new SchedulePresenter($this);
	}
	
	public function PageLoad()
	{
		$this->_presenter->PageLoad();
		$this->smarty->display('schedule.tpl');		
	}
	
	public function GetScheduleId()
	{
		return $this->server->GetForm(FormKeys::SCHEDULE_ID);
	}
	
	public function SetSchedules($schedules)
	{
		$this->smarty->assign('Schedules', $schedules);
	}
	
	public function SetResources($resources)
	{
		$this->smarty->assign('Resources', $resources);
	}
	
	public function SetReservations($reservations)
	{
		$this->smarty->assign('Reservations', $reservations);
	}
	
	public function SetDisplayDates($dates)
	{
		$this->smarty->assign('DisplayDates', $dates);
	}
}

interface ISchedulePage
{
	/**
	 * Bind schedules to the page
	 *
	 * @param array[]Schedule $schedules
	 */
	public function SetSchedules($schedules);
	
	/**
	 * Bind resources to the page
	 *
	 * @param array[]Resource $resources
	 */
	public function SetResources($resources);
	
	/**
	 * Bind reservations to the page
	 *
	 * @param array[]ScheduleReservation $reservations
	 */
	public function SetReservations($reservations);
	
	/**
	 * Returns the currently selected scheduleId
	 * @return int
	 */
	public function GetScheduleId();
	
	/**
	 * Sets the dates to be displayed for the schedule, adjusted for timezone if necessary
	 *
	 * @param array[]Date $dates
	 */
	public function SetDisplayDates($dates);
}
?>
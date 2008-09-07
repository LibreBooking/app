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
}

interface ISchedulePage
{
	/**
	 * Bind schedules to the page
	 *
	 * @param array $schedules array of Schedule objects
	 */
	public function SetSchedules($schedules);
	
	/**
	 * Bind resources to the page
	 *
	 * @param array $resources array of Resource objects
	 */
	public function SetResources($resources);
	
	/**
	 * Bind reservations to the page
	 *
	 * @param array $reservations array of ScheduleReservation objects
	 */
	public function SetReservations($reservations);
	
	/**
	 * Returns the currently selected scheduleId
	 * @return int
	 */
	public function GetScheduleId();
}
?>
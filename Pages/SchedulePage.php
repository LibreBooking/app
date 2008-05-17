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
	
	public function SetSchedules($schedules)
	{
		$this->smarty->assign('Schedules', $schedules);
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
}
?>
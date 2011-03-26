<?php 
require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageSchedulesPresenter.php');
require_once(ROOT_DIR . 'Domain/Access/ScheduleRepository.php');

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
		
		$this->Display('manage_schedules.tpl');		
	}
	
	public function BindSchedules($schedules)
	{
		$this->Set('Schedules', $schedules);
	}
}

interface IManageSchedulesPage
{
	/**
	 * @param $schedules Schedule[]
	 */
	function BindSchedules($schedules);
}
?>
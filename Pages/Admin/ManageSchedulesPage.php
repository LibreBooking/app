<?php 
require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageSchedulesPresenter.php');
require_once(ROOT_DIR . 'Domain/Access/ScheduleRepository.php');

interface IUpdateSchedulePage
{
	/**
	 * @return string
	 */
	function GetAction();
	
	/**
	 * @return int
	 */
	function GetScheduleId();
	
	/**
	 * @return string
	 */
	function GetScheduleName();
}


interface IManageSchedulesPage extends IUpdateSchedulePage
{
	/**
	 * @param Schedule[] $schedules 
	 * @param array $layouts 
	 */
	function BindSchedules($schedules, $layouts);
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
		$this->Display('manage_schedules.tpl');		
	}
	
	public function TakingAction()
	{
		$action = $this->GetAction();
		return !empty($action);
	}
	
	public function ProcessAction()
	{
		$this->_presenter->ProcessAction();
	}
	
	public function BindSchedules($schedules, $layouts)
	{
		$this->Set('Schedules', $schedules);
		$this->Set('Layouts', $layouts);
	}
	
	public function GetAction()
	{
		return $this->server->GetQuerystring(QueryStringKeys::ACTION);
	}
	
	public function GetScheduleId()
	{
		return $this->server->GetQuerystring(QueryStringKeys::SCHEDULE_ID);
	}
	
	public function GetScheduleName()
	{
		return $this->server->GetForm(FormKeys::SCHEDULE_NAME);
	}
}

?>
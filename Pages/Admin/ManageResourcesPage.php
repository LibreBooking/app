<?php 
require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageSchedulesPresenter.php');
require_once(ROOT_DIR . 'Domain/Access/ScheduleRepository.php');

interface IUpdateResourcePage
{	
	/**
	 * @return int
	 */
	function GeResourceId();
	
	/**
	 * @return string
	 */
	function GetResourceName();
}


interface IManageResourcesPage// extends IUpdateResourcePage
{
	/**
	 * @param Resource[] $resources
	 */
	function BindResources($resources);
	
	/**
	 * @param array $scheduleList array of (id, schedule name)
	 */
	function BindSchedules($scheduleList);
}

class ManageResourcesPage extends AdminPage implements IManageResourcesPage
{
	public function __construct()
	{
		parent::__construct('ManageResources');
		$this->_presenter = new ManageResourcesPresenter(
								$this, 
								new ResourceRepository(),
								new ScheduleRepository()
								);
	}
	
	public function PageLoad()
	{
		$this->_presenter->PageLoad();
		
		$this->Display('manage_resources.tpl');		
	}
	
	public function BindResources($resources)
	{
		$this->Set('Resources', $resources);
	}
	
	public function BindSchedules($schedules)
	{
		$this->Set('Schedules', $schedules);
	}
	
	public function ProcessAction()
	{
		$this->_presenter->ProcessAction();
	}
}

?>
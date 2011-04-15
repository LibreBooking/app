<?php 
require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageSchedulesPresenter.php');
require_once(ROOT_DIR . 'Domain/Access/ScheduleRepository.php');

interface IUpdateResourcePage
{	
	/**
	 * @return int
	 */
	function GetResourceId();
	
	/**
	 * @return string
	 */
	function GetResourceName();
	
	/**
	 * @return UploadedFile
	 */
	function GetUploadedImage();
}


interface IManageResourcesPage extends IUpdateResourcePage
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
								new ScheduleRepository(),
								new ImageFactory()
								);
								
		$this->Set('ImageUploadPath', $this->path . Configuration::Instance()->GetKey(ConfigKeys::IMAGE_UPLOAD_DIRECTORY) . '/');
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
	
	public function GetResourceId()
	{
		return $this->server->GetQuerystring(QueryStringKeys::RESOURCE_ID);
	}
	
	public function GetResourceName()
	{
		return $this->server->GetForm(FormKeys::RESOURCE_NAME);
	}
	
	public function GetUploadedImage()
	{
		return $this->server->GetFile(FormKeys::RESOURCE_IMAGE);
	}
}

?>
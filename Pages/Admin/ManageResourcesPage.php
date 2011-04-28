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
	 * @return int
	 */
	function GetScheduleId();
	
	/**
	 * @return string
	 */
	function GetResourceName();
	
	/**
	 * @return UploadedFile
	 */
	function GetUploadedImage();
	
	/**
	 * @return string
	 */
	function GetLocation();
	
	/**
	 * @return string
	 */
	function GetContact();
	
	/**
	 * @return string
	 */
	function GetDescription();
	
	/**
	 * @return string
	 */
	function GetNotes();
	
	/**
	 * @return string
	 */
	function GetMinimumDuration();
	
	/**
	 * @return string
	 */
	function GetMaximumDuration();
	
	/**
	 * @return string
	 */
	function GetAllowMultiday();
		
	/**
	 * @return string
	 */
	function GetRequiresApproval();
		
	/**
	 * @return string
	 */
	function GetAutoAssign();
		
	/**
	 * @return string
	 */
	function GetStartNoticeMinutes();
		
	/**
	 * @return string
	 */
	function GetEndNoticeMinutes();
		
	/**
	 * @return string
	 */
	function GetMaxParticipants();
}


interface IManageResourcesPage extends IUpdateResourcePage
{
	/**
	 * @param BookableResource[] $resources
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
	
	public function GetScheduleId()
	{
		return $this->server->GetForm(FormKeys::SCHEDULE_ID);
	}
	
	public function GetResourceName()
	{
		return $this->server->GetForm(FormKeys::RESOURCE_NAME);
	}
	
	public function GetUploadedImage()
	{
		return $this->server->GetFile(FormKeys::RESOURCE_IMAGE);
	}
	
	public function GetLocation()
	{
		return $this->server->GetForm(FormKeys::RESOURCE_LOCATION);
	}

	public function GetContact()
	{
		return $this->server->GetForm(FormKeys::RESOURCE_CONTACT);
	}
	
	public function GetDescription()
	{
		return $this->server->GetForm(FormKeys::RESOURCE_DESCRIPTION);
	}
	
	public function GetNotes()
	{
		return $this->server->GetForm(FormKeys::RESOURCE_NOTES);
	}
	
	/**
	 * @return string
	 */
	public function GetMinimumDuration()
	{
		return $this->server->GetForm(FormKeys::MIN_DURATION);
	}
	
	/**
	 * @return string
	 */
	public function GetMaximumDuration()
	{
		return $this->server->GetForm(FormKeys::MAX_DURATION);
	}
	
	/**
	 * @return string
	 */
	public function GetAllowMultiday()
	{
		return $this->server->GetForm(FormKeys::ALLOW_MULTIDAY);
	}
		
	/**
	 * @return string
	 */
	public function GetRequiresApproval()
	{
		return $this->server->GetForm(FormKeys::REQUIRES_APPROVAL);
	}
		
	/**
	 * @return string
	 */
	public function GetAutoAssign()
	{
		return $this->server->GetForm(FormKeys::AUTO_ASSIGN);
	}
		
	/**
	 * @return string
	 */
	public function GetStartNoticeMinutes()
	{
		return $this->server->GetForm(FormKeys::MIN_NOTICE);
	}
		
	/**
	 * @return string
	 */
	public function GetEndNoticeMinutes()
	{
		return $this->server->GetForm(FormKeys::MAX_NOTICE);
	}
		
	/**
	 * @return string
	 */
	public function GetMaxParticipants()
	{
		return $this->server->GetForm(FormKeys::MAX_PARTICIPANTS);
	}
}

?>
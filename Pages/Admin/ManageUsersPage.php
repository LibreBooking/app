<?php 
require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageUsersPresenter.php');
require_once(ROOT_DIR . 'Domain/Access/UserRepository.php');


class ManageUsersPage extends AdminPage
{
	public function __construct()
	{
		parent::__construct('ManageUsers');
//		$this->_presenter = new ManageUsersPresenter(
//								$this,
//								new UserRepository()
//								);
	}
	
	public function PageLoad()
	{
		//$this->_presenter->PageLoad();
		
		$r = new PageableDataService();
		$users = $r->GetAll($command, $pageNumber, $pageSize);
		$rowCount = $r->GetList();
		
		$this->Display('manage_users.tpl');
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
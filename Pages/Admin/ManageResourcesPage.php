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

	/**
	 * @abstract
	 * @return int
	 */
	function GetAdminGroupId();
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

	/**
	 * @abstract
	 * @param $adminGroups GroupItemView[]|array
	 * @return void
	 */
	function BindAdminGroups($adminGroups);
}

class ManageResourcesPage extends ActionPage implements IManageResourcesPage
{
	/**
	 * @var ManageResourcesPresenter
	 */
	protected $_presenter;

	public function __construct()
	{
		parent::__construct('ManageResources', 1);
		$this->_presenter = new ManageResourcesPresenter(
								$this, 
								new ResourceRepository(),
								new ScheduleRepository(),
								new ImageFactory(),
								new GroupRepository()
								);
								
		$this->Set('ImageUploadPath', $this->path . Configuration::Instance()->GetKey(ConfigKeys::IMAGE_UPLOAD_URL) . '/');
	}
	
	public function PageLoad()
	{
		$this->_presenter->PageLoad();
		
		$this->Display('Admin/manage_resources.tpl');
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
		return $this->GetQuerystring(QueryStringKeys::RESOURCE_ID);
	}
	
	public function GetScheduleId()
	{
		return $this->GetForm(FormKeys::SCHEDULE_ID);
	}
	
	public function GetResourceName()
	{
		return $this->GetForm(FormKeys::RESOURCE_NAME);
	}
	
	public function GetUploadedImage()
	{
		return $this->server->GetFile(FormKeys::RESOURCE_IMAGE);
	}
	
	public function GetLocation()
	{
		return $this->GetForm(FormKeys::RESOURCE_LOCATION);
	}

	public function GetContact()
	{
		return $this->GetForm(FormKeys::RESOURCE_CONTACT);
	}
	
	public function GetDescription()
	{
		return $this->GetForm(FormKeys::RESOURCE_DESCRIPTION);
	}
	
	public function GetNotes()
	{
		return $this->GetForm(FormKeys::RESOURCE_NOTES);
	}
	
	/**
	 * @return string
	 */
	public function GetMinimumDuration()
	{
		return $this->GetForm(FormKeys::MIN_DURATION);
	}
	
	/**
	 * @return string
	 */
	public function GetMaximumDuration()
	{
		return $this->GetForm(FormKeys::MAX_DURATION);
	}
	
	/**
	 * @return string
	 */
	public function GetAllowMultiday()
	{
		return $this->GetForm(FormKeys::ALLOW_MULTIDAY);
	}
		
	/**
	 * @return string
	 */
	public function GetRequiresApproval()
	{
		return $this->GetForm(FormKeys::REQUIRES_APPROVAL);
	}
		
	/**
	 * @return string
	 */
	public function GetAutoAssign()
	{
		return $this->GetForm(FormKeys::AUTO_ASSIGN);
	}
		
	/**
	 * @return string
	 */
	public function GetStartNoticeMinutes()
	{
		return $this->GetForm(FormKeys::MIN_NOTICE);
	}
		
	/**
	 * @return string
	 */
	public function GetEndNoticeMinutes()
	{
		return $this->GetForm(FormKeys::MAX_NOTICE);
	}
		
	/**
	 * @return string
	 */
	public function GetMaxParticipants()
	{
		return $this->GetForm(FormKeys::MAX_PARTICIPANTS);
	}

	/**
	 * @return int
	 */
	public function GetAdminGroupId()
	{
		return $this->GetForm(FormKeys::RESOURCE_ADMIN_GROUP_ID);
	}

	/**
	 * @param $adminGroups GroupItemView[]|array
	 * @return void
	 */
	function BindAdminGroups($adminGroups)
	{
		$this->Set('AdminGroups', $adminGroups);
		$groupLookup = array();
		foreach ($adminGroups as $group)
		{
			$groupLookup[$group->Id] = $group;
		}
		$this->Set('GroupLookup', $groupLookup);
	}

	public function ProcessDataRequest()
	{
		// noop
	}
}

?>
<?php
/**
Copyright 2011-2013 Nick Korbel

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
require_once(ROOT_DIR . 'lib/Application/Attributes/namespace.php');

interface IUpdateResourcePage
{
	/**
	 * @return int
	 */
	public function GetResourceId();

	/**
	 * @return int
	 */
	public function GetScheduleId();

	/**
	 * @return string
	 */
	public function GetResourceName();

	/**
	 * @return UploadedFile
	 */
	public function GetUploadedImage();

	/**
	 * @return string
	 */
	public function GetLocation();

	/**
	 * @return string
	 */
	public function GetContact();

	/**
	 * @return string
	 */
	public function GetDescription();

	/**
	 * @return string
	 */
	public function GetNotes();

	/**
	 * @return string
	 */
	public function GetMinimumDuration();

	/**
	 * @return string
	 */
	public function GetMaximumDuration();

	/**
	 * @return string
	 */
	public function GetAllowMultiday();

	/**
	 * @return string
	 */
	public function GetRequiresApproval();

	/**
	 * @return string
	 */
	public function GetAutoAssign();

	/**
	 * @return string
	 */
	public function GetStartNoticeMinutes();

	/**
	 * @return string
	 */
	public function GetEndNoticeMinutes();

	/**
	 * @return string
	 */
	public function GetMaxParticipants();

	/**
	 * @abstract
	 * @return int
	 */
	public function GetAdminGroupId();

	/**
	 * @abstract
	 * @return int
	 */
	public function GetSortOrder();
}

interface IManageResourcesPage extends IUpdateResourcePage, IActionPage
{
	/**
	 * @param BookableResource[] $resources
	 */
	public function BindResources($resources);

	/**
	 * @param array $scheduleList array of (id, schedule name)
	 */
	public function BindSchedules($scheduleList);

	/**
	 * @abstract
	 * @param $adminGroups GroupItemView[]|array
	 * @return void
	 */
	public function BindAdminGroups($adminGroups);

	/**
	 * @abstract
	 * @param $attributeList IEntityAttributeList
	 */
	public function BindAttributeList($attributeList);

	/**
	 * @abstract
	 * @return AttributeFormElement[]|array
	 */
	public function GetAttributes();
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
			new GroupRepository(),
			new AttributeService(new AttributeRepository())
		);
	}

	public function ProcessPageLoad()
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

	public function ProcessDataRequest($dataRequest)
	{
		// no-op
	}

	/**
	 * @param $attributeList IEntityAttributeList
	 */
	public function BindAttributeList($attributeList)
	{
		// should bind labels and values per entity
		$defList = array();
		foreach ($attributeList->GetDefinitions() as $def)
		{
			$defList[] = new Attribute($def);
		}
		$this->Set('Definitions', $defList);
		$this->Set('AttributeList', $attributeList);
	}

	/**
	 * @return AttributeFormElement[]|array
	 */
	public function GetAttributes()
	{
		return AttributeFormParser::GetAttributes($this->GetForm(FormKeys::ATTRIBUTE_PREFIX));
	}

	/**
	 * @return int
	 */
	public function GetSortOrder()
	{
		return $this->GetForm(FormKeys::RESOURCE_SORT_ORDER);
	}
}

?>
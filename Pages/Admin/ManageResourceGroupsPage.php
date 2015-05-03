<?php
/**
Copyright 2011-2015 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'lib/Application/Attributes/namespace.php');

interface IManageResourceGroupsPage extends IActionPage
{
	/**
	 * @param ResourceGroupTree $resourceGroups
	 */
	public function BindResourceGroups(ResourceGroupTree $resourceGroups);

	/**
	 * @param BookableResource[] $resources
	 */
	public function BindResources($resources);

	/**
	 * @return int
	 */
	public function GetResourceId();

	/**
	 * @return int
	 */
	public function GetGroupId();

	/**
	 * @return string
	 */
	public function GetGroupName();

	/**
	 * @return int
	 */
	public function GetParentId();

	/**
	 * @param ResourceGroup $newGroup
	 */
	public function BindNewGroup(ResourceGroup $newGroup);

	/**
	 * @return int
	 */
	public function GetNodeId();

	/**
	 * @return string
	 */
	public function GetNodeType();

	/**
	 * @return int
	 */
	public function GetTargetNodeId();

	/**
	 * @return int
	 */
	public function GetPreviousNodeId();
}

class ManageResourceGroupsPage extends ActionPage implements IManageResourceGroupsPage
{
	/**
	 * @var ManageResourcesPresenter
	 */
	protected $_presenter;

	public function __construct()
	{
		parent::__construct('ManageResourceGroups', 1);
		$this->_presenter = new ManageResourceGroupsPresenter($this, ServiceLocator::GetServer()
																	 ->GetUserSession(), new ResourceRepository());
	}

	public function ProcessPageLoad()
	{
		$this->_presenter->PageLoad();

		$this->Display('Admin/Resources/manage_resource_groups.tpl');
	}

	/**
	 * @return void
	 */
	public function ProcessAction()
	{
		$this->_presenter->ProcessAction();
	}

	/**
	 * @param $dataRequest string
	 * @return void
	 */
	public function ProcessDataRequest($dataRequest)
	{
	}

	public function BindResourceGroups(ResourceGroupTree $resourceGroups)
	{
		$this->Set('ResourceGroups', json_encode($resourceGroups->GetGroups(false)));
	}

	/**
	 * @param BookableResource[] $resources
	 */
	public function BindResources($resources)
	{
		$this->Set('Resources', $resources);
	}

	/**
	 * @return int
	 */
	public function GetResourceId()
	{
		return $this->GetQuerystring(QueryStringKeys::RESOURCE_ID);
	}

	/**
	 * @return int
	 */
	public function GetGroupId()
	{
		return $this->GetQuerystring(QueryStringKeys::GROUP_ID);
	}

	/**
	 * @return string
	 */
	public function GetGroupName()
	{
		return $this->GetForm(FormKeys::GROUP_NAME);
	}

	/**
	 * @return int
	 */
	public function GetParentId()
	{
		return $this->GetForm(FormKeys::PARENT_ID);
	}

	public function BindNewGroup(ResourceGroup $newGroup)
	{
		$this->SetJson(json_encode($newGroup));
	}

	/**
	 * @return int
	 */
	public function GetNodeId()
	{
		return $this->GetQuerystring(QueryStringKeys::NODE_ID);
	}

	/**
	 * @return string
	 */
	public function GetNodeType()
	{
		return $this->GetQuerystring(QueryStringKeys::TYPE);
	}

	/**
	 * @return int
	 */
	public function GetTargetNodeId()
	{
		$groupId = $this->GetQuerystring(QueryStringKeys::GROUP_ID);

		if (empty($groupId) || strtolower($groupId) == 'null')
		{
			return null;
		}
		return $groupId;
	}

	/**
	 * @return int
	 */
	public function GetPreviousNodeId()
	{
		return $this->GetQuerystring(QueryStringKeys::PREVIOUS_ID);
	}
}

?>
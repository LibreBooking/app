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

require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');
require_once(ROOT_DIR . 'Pages/Admin/ManageResourceGroupsPage.php');

class ManageResourceGroupsActions
{
	const AddGroup = 'AddGroup';
	const AddResource = 'AddResource';
	const RemoveResource = 'RemoveResource';
}

class ManageResourceGroupsPresenter extends ActionPresenter
{
	/**
	 * @var IManageResourceGroupsPage
	 */
	private $page;

	/**
	 * @var IResourceRepository
	 */
	private $resourceRepository;

	public function __construct(
		IManageResourceGroupsPage $page,
		UserSession $user,
		IResourceRepository $resourceRepository)
	{
		parent::__construct($page);

		$this->page = $page;
		$this->resourceRepository = $resourceRepository;

		$this->AddAction(ManageResourceGroupsActions::AddResource, 'AddResource');
		$this->AddAction(ManageResourceGroupsActions::RemoveResource, 'RemoveResource');
		$this->AddAction(ManageResourceGroupsActions::AddGroup, 'AddGroup');

	}

	public function PageLoad()
	{
		$this->page->BindResourceGroups($this->resourceRepository->GetResourceGroups());
		$this->page->BindResources($this->resourceRepository->GetResourceList());
	}

	/**
	 * @internal should only be used for testing
	 */
	public function AddResource()
	{
		$resourceId = $this->page->GetResourceId();
		$groupId = $this->page->GetGroupId();

		Log::Debug('Adding resource to group. ResourceId=%s, GroupId=%s', $resourceId, $groupId);

		$this->resourceRepository->AddResourceToGroup($resourceId, $groupId);
	}

	/**
	 * @internal should only be used for testing
	 */
	public function RemoveResource()
	{
		$resourceId = $this->page->GetResourceId();
		$groupId = $this->page->GetGroupId();

		Log::Debug('Removing resource from group. ResourceId=%s, GroupId=%s', $resourceId, $groupId);

		$this->resourceRepository->RemoveResourceFromGroup($resourceId, $groupId);
	}

	/**
	 * @internal should only be used for testing
	 */
	public function AddGroup()
	{
		$groupName = $this->page->GetGroupName();
		$parentId = $this->page->GetParentId();
		Log::Debug('Adding new group. GroupName=%s, ParentId=%s', $groupName, $parentId);
		$addedGroup = $this->resourceRepository->AddResourceGroup(ResourceGroup::Create($groupName,$parentId));
		$this->page->BindNewGroup($addedGroup);
	}

	/**
	 * @internal should only be used for testing
	 */
	public function Rename()
	{

	}
}

?>
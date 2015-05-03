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

require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');

class ManageGroupsActions
{
	const Activate = 'activate';
	const Deactivate = 'deactivate';
	const Password = 'password';
	const Permissions = 'permissions';
	const RemoveUser = 'removeUser';
	const AddUser = 'addUser';
	const AddGroup = 'addGroup';
	const RenameGroup = 'renameGroup';
	const DeleteGroup = 'deleteGroup';
	const Roles = 'roles';
	const GroupAdmin = 'groupAdmin';
}

class ManageGroupsPresenter extends ActionPresenter
{
	/**
	 * @var IManageGroupsPage
	 */
	private $page;

	/**
	 * @var GroupRepository
	 */
	private $groupRepository;

	/**
	 * @var ResourceRepository
	 */
	private $resourceRepository;

	/**
	 * @param IManageGroupsPage $page
	 * @param GroupRepository $groupRepository
	 * @param ResourceRepository $resourceRepository
	 */
	public function __construct(IManageGroupsPage $page, GroupRepository $groupRepository, ResourceRepository $resourceRepository)
	{
		parent::__construct($page);

		$this->page = $page;
		$this->groupRepository = $groupRepository;
		$this->resourceRepository = $resourceRepository;

		$this->AddAction(ManageGroupsActions::AddUser, 'AddUser');
		$this->AddAction(ManageGroupsActions::RemoveUser, 'RemoveUser');
		$this->AddAction(ManageGroupsActions::Permissions, 'ChangePermissions');
		$this->AddAction(ManageGroupsActions::AddGroup, 'AddGroup');
		$this->AddAction(ManageGroupsActions::RenameGroup, 'RenameGroup');
		$this->AddAction(ManageGroupsActions::DeleteGroup, 'DeleteGroup');
		$this->AddAction(ManageGroupsActions::Roles, 'ChangeRoles');
		$this->AddAction(ManageGroupsActions::GroupAdmin, 'ChangeGroupAdmin');
	}

	public function PageLoad()
	{
		if ($this->page->GetGroupId() != null)
		{
			$groupList = $this->groupRepository->GetList(1, 1, null, null, new SqlFilterEquals(new SqlFilterColumn(TableNames::GROUPS_ALIAS, ColumnNames::GROUP_ID), $this->page->GetGroupId()));
		}
		else
		{
			$groupList = $this->groupRepository->GetList($this->page->GetPageNumber(), $this->page->GetPageSize());
		}

		$this->page->BindGroups($groupList->Results());
		$this->page->BindPageInfo($groupList->PageInfo());

		$this->page->BindResources($this->resourceRepository->GetResourceList());

		$this->page->BindRoles(array(
                                   new RoleDto(1,'Group Admin', RoleLevel::GROUP_ADMIN),
                                   new RoleDto(2, 'Application Admin', RoleLevel::APPLICATION_ADMIN),
                                   new RoleDto(3, 'Resource Admin', RoleLevel::RESOURCE_ADMIN),
                                   new RoleDto(4, 'Schedule Admin', RoleLevel::SCHEDULE_ADMIN)
                                ));
		$this->page->BindAdminGroups($this->groupRepository->GetGroupsByRole(RoleLevel::GROUP_ADMIN));
	}

	public function ChangePermissions()
	{
		$group = $this->groupRepository->LoadById($this->page->GetGroupId());
		$allowedResources = array();

		if (is_array($this->page->GetAllowedResourceIds())) {
			$allowedResources = $this->page->GetAllowedResourceIds();
		}
		$group->ChangePermissions($allowedResources);
		$this->groupRepository->Update($group);
	}

	public function ChangeRoles()
	{
		$groupId = $this->page->GetGroupId();
		Log::Debug("Changing roles for groupId: %s", $groupId);

		$group = $this->groupRepository->LoadById($groupId);
		$roles = array();

		if (is_array($this->page->GetRoleIds())) {
			$roles = $this->page->GetRoleIds();
		}
		$group->ChangeRoles($roles);
		$this->groupRepository->Update($group);
	}

	public function ProcessDataRequest()
	{
		$response = '';
		$request = $this->page->GetDataRequest();
		switch($request)
		{
			case 'groupMembers' :
				$users = $this->groupRepository->GetUsersInGroup($this->page->GetGroupId(), 1, 100);
				$response = new UserGroupResults($users->Results(), $users->PageInfo()->Total);
				break;
			case 'permissions' :
				$response = $this->GetGroupResourcePermissions();
				break;
			case 'roles' :
				$response = $this->GetGroupRoles();
				break;
		}

		$this->page->SetJsonResponse($response);
	}

	/**
	 * @return int[] all resource ids the user has permission to
	 */
	public function GetGroupResourcePermissions()
	{
		$group = $this->groupRepository->LoadById($this->page->GetGroupId());
		return $group->AllowedResourceIds();
	}

	protected function AddUser()
	{
		$groupId = $this->page->GetGroupId();
		$userId = $this->page->GetUserId();

		Log::Debug("Adding userId: %s to groupId: %s", $userId, $groupId);

		$group = $this->groupRepository->LoadById($groupId);
		$group->AddUser($userId);
		$this->groupRepository->Update($group);
	}

	protected function RemoveUser()
	{
		$groupId = $this->page->GetGroupId();
		$userId = $this->page->GetUserId();

		Log::Debug('Removing userId: %s from groupId: %s', $userId, $groupId);

		$group = $this->groupRepository->LoadById($groupId);
		$group->RemoveUser($userId);
		$this->groupRepository->Update($group);
	}

	protected function AddGroup()
	{
		$groupName = $this->page->GetGroupName();
		Log::Debug('Adding new group with name: %s', $groupName);

		$group = new Group(0, $groupName);
		$this->groupRepository->Add($group);
	}

	protected function RenameGroup()
	{
		$groupId = $this->page->GetGroupId();
		$groupName = $this->page->GetGroupName();
		Log::Debug('Renaming group id: %s to: %s', $groupId, $groupName);

		$group = $this->groupRepository->LoadById($groupId);
		$group->Rename($groupName);

		$this->groupRepository->Update($group);
	}

	protected function DeleteGroup()
	{
		$groupId = $this->page->GetGroupId();

		Log::Debug("Deleting groupId: %s", $groupId);

		$group = $this->groupRepository->LoadById($groupId);
		$this->groupRepository->Remove($group);
	}

	protected function ChangeGroupAdmin()
	{
		$groupId = $this->page->GetGroupId();
		$adminGroupId = $this->page->GetAdminGroupId();

		Log::Debug("Changing admin for groupId: %s to %s", $groupId, $adminGroupId);

		$group = $this->groupRepository->LoadById($groupId);

		$group->ChangeAdmin($adminGroupId);

		$this->groupRepository->Update($group);
	}
	/**
	 * @return array|int[]
	 */
	protected function GetGroupRoles()
	{
		$groupId = $this->page->GetGroupId();
		$group = $this->groupRepository->LoadById($groupId);

		$ids = $group->RoleIds();

		return $ids;
	}
}

class UserGroupResults
{
	/**
	 * @param UserItemView[] $users
	 * @param int $totalUsers
	 */
	public function __construct($users, $totalUsers)
	{
		foreach ($users as $user)
		{
			$this->Users[] = new AutocompleteUser($user->Id, $user->First, $user->Last, $user->Email, $user->Username);
		}
		$this->Total = $totalUsers;
	}

	/**
	 * @var int
	 */
	public $Total;

	/**
	 * @var AutocompleteUser[]
	 */
	public $Users;
}

?>
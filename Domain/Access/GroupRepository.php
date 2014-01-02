<?php
/**
Copyright 2011-2014 Nick Korbel

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

interface IGroupRepository
{
	/**
	 * @abstract
	 * @param int $groupId
	 * @return Group
	 */
	public function LoadById($groupId);

	/**
	 * @abstract
	 * @param Group $group
	 * @return int newly inserted group id
	 */
	public function Add(Group $group);

	/**
	 * @abstract
	 * @param Group $group
	 * @return void
	 */
	public function Update(Group $group);

	/**
	 * @abstract
	 * @param Group $group
	 * @return void
	 */
	public function Remove(Group $group);
}

interface IGroupViewRepository
{
	/**
	 * @param int $pageNumber
	 * @param int $pageSize
	 * @param string $sortField
	 * @param string $sortDirection
	 * @param ISqlFilter $filter
	 * @return PageableData|GroupItemView[]
	 */
	public function GetList($pageNumber = null, $pageSize = null, $sortField = null, $sortDirection = null,
							$filter = null);

	/**
	 * @abstract
	 * @param int|array|int[] $groupIds
	 * @param int $pageNumber
	 * @param int $pageSize
	 * @param ISqlFilter $filter
	 * @param AccountStatus|int $accountStatus
	 * @return PageableData|GroupUserView[]
	 */
	public function GetUsersInGroup($groupIds, $pageNumber = null, $pageSize = null, $filter = null,
									$accountStatus = AccountStatus::ALL);

	/**
	 * @abstract
	 * @param $roleLevel int|RoleLevel
	 * @return GroupItemView[]|array
	 */
	public function GetGroupsByRole($roleLevel);
}

class GroupRepository implements IGroupRepository, IGroupViewRepository
{
	/**
	 * @var DomainCache
	 */
	private $_cache;

	public function __construct()
	{
		$this->_cache = new DomainCache();
	}

	/**
	 * @param int $pageNumber
	 * @param int $pageSize
	 * @param string $sortField
	 * @param string $sortDirection
	 * @param ISqlFilter $filter
	 * @return PageableData|GroupItemView[]
	 */
	public function GetList($pageNumber = null, $pageSize = null, $sortField = null, $sortDirection = null,
							$filter = null)
	{
		$command = new GetAllGroupsCommand();

		if ($filter != null)
		{
			$command = new FilterCommand($command, $filter);
		}

		$builder = array('GroupItemView', 'Create');
		return PageableDataStore::GetList($command, $builder, $pageNumber, $pageSize);
	}

	/**
	 * @param array|int|int[] $groupIds
	 * @param null $pageNumber
	 * @param null $pageSize
	 * @param null $filter
	 * @param AccountStatus|int $accountStatus
	 * @return PageableData|UserItemView[]
	 */
	public function GetUsersInGroup($groupIds, $pageNumber = null, $pageSize = null, $filter = null,
									$accountStatus = AccountStatus::ACTIVE)
	{
		$command = new GetAllGroupUsersCommand($groupIds, $accountStatus);

		if ($filter != null)
		{
			$command = new FilterCommand($command, $filter);
		}

		$builder = array('UserItemView', 'Create');
		return PageableDataStore::GetList($command, $builder, $pageNumber, $pageSize);
	}

	public function LoadById($groupId)
	{
		if ($this->_cache->Exists($groupId))
		{
			return $this->_cache->Get($groupId);
		}

		$group = null;
		$db = ServiceLocator::GetDatabase();

		$reader = $db->Query(new GetGroupByIdCommand($groupId));
		if ($row = $reader->GetRow())
		{
			$group = new Group($row[ColumnNames::GROUP_ID], $row[ColumnNames::GROUP_NAME]);
			$group->WithGroupAdmin($row[ColumnNames::GROUP_ADMIN_GROUP_ID]);
		}
		$reader->Free();

		$reader = $db->Query(new GetAllGroupUsersCommand($groupId, AccountStatus::ACTIVE));
		while ($row = $reader->GetRow())
		{
			$group->WithUser($row[ColumnNames::USER_ID]);
		}
		$reader->Free();

		$reader = $db->Query(new GetAllGroupPermissionsCommand($groupId));
		while ($row = $reader->GetRow())
		{
			$group->WithPermission($row[ColumnNames::RESOURCE_ID]);
		}
		$reader->Free();

		$reader = $db->Query(new GetAllGroupRolesCommand($groupId));
		while ($row = $reader->GetRow())
		{
			$group->WithRole($row[ColumnNames::ROLE_ID]);
		}
		$reader->Free();

		$this->_cache->Add($groupId, $group);
		return $group;
	}

	/**
	 * @param Group $group
	 * @return void
	 */
	public function Update(Group $group)
	{
		$db = ServiceLocator::GetDatabase();

		foreach ($group->RemovedUsers() as $userId)
		{
			$db->Execute(new DeleteUserGroupCommand($userId, $group->Id()));
		}

		foreach ($group->AddedUsers() as $userId)
		{
			$db->Execute(new AddUserGroupCommand($userId, $group->Id()));
		}

		foreach ($group->RemovedPermissions() as $resourceId)
		{
			$db->Execute(new DeleteGroupResourcePermission($group->Id(), $resourceId));
		}

		foreach ($group->AddedPermissions() as $resourceId)
		{
			$db->Execute(new AddGroupResourcePermission($group->Id(), $resourceId));
		}

		foreach ($group->RemovedRoles() as $roleId)
		{
			$db->Execute(new DeleteGroupRoleCommand($group->Id(), $roleId));
		}

		foreach ($group->AddedRoles() as $roleId)
		{
			$db->Execute(new AddGroupRoleCommand($group->Id(), $roleId));
		}

		$db->Execute(new UpdateGroupCommand($group->Id(), $group->Name(), $group->AdminGroupId()));
	}

	public function Remove(Group $group)
	{
		ServiceLocator::GetDatabase()->Execute(new DeleteGroupCommand($group->Id()));
	}

	public function Add(Group $group)
	{
		$groupId = ServiceLocator::GetDatabase()->ExecuteInsert(new AddGroupCommand($group->Name()));
		$group->WithId($groupId);

		return $groupId;
	}

	/**
	 * @param $roleLevel int|RoleLevel
	 * @return GroupItemView[]|array
	 */
	public function GetGroupsByRole($roleLevel)
	{
		$reader = ServiceLocator::GetDatabase()->Query(new GetAllGroupsByRoleCommand($roleLevel));
		$groups = array();
		while ($row = $reader->GetRow())
		{
			$groups[] = GroupItemView::Create($row);
		}
		$reader->Free();

		return $groups;
	}
}

class GroupUserView
{
	public static function Create($row)
	{
		return new GroupUserView(
			$row[ColumnNames::USER_ID],
			$row[ColumnNames::FIRST_NAME],
			$row[ColumnNames::LAST_NAME]);
	}

	public $UserId;
	public $FirstName;
	public $LastName;
	public $GroupId;

	public function __construct($userId, $firstName, $lastName)
	{
		$this->UserId = $userId;
		$this->FirstName = $firstName;
		$this->LastName = $lastName;
	}
}

class GroupItemView
{
	public static function Create($row)
	{
		$adminName = isset($row[ColumnNames::GROUP_ADMIN_GROUP_NAME]) ? $row[ColumnNames::GROUP_ADMIN_GROUP_NAME] : null;

		return new GroupItemView($row[ColumnNames::GROUP_ID], $row[ColumnNames::GROUP_NAME], $adminName);
	}

	/**
	 * @var int
	 */
	public $Id;

	/**
	 * @return int
	 */
	public function Id()
	{
		return $this->Id;
	}

	/**
	 * @var string
	 */
	public $Name;

	/**
	 * @return string
	 */
	public function Name()
	{
		return $this->Name;
	}

	/**
	 * @var string
	 */
	public $AdminGroupName;

	public function __construct($groupId, $groupName, $adminGroupName = null)
	{
		$this->Id = $groupId;
		$this->Name = $groupName;
		$this->AdminGroupName = $adminGroupName;
	}
}

class RoleDto
{
	/**
	 * @var int
	 */
	public $Id;

	/**
	 * @var string
	 */
	public $Name;

	/**
	 * @var int|RoleLevel
	 */
	public $Level;

	/**
	 * @param $id int
	 * @param $name string
	 * @param $level RoleLevel|int
	 */
	public function __construct($id, $name, $level)
	{
		$this->Id = $id;
		$this->Name = $name;
		$this->Level = $level;
	}
}

?>
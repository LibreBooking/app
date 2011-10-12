<?php

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
	 * @return void
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
	 * @return PageableData of GroupItemView
	 */
	public function GetList($pageNumber = null, $pageSize = null, $sortField = null, $sortDirection = null, $filter = null);

	/**
	 * @abstract
	 * @param int|array|int[] $groupIds
	 * @param int $pageNumber
	 * @param int $pageSize
	 * @param ISqlFilter $filter
	 * @return PageableData of GroupUserView
	 */
	public function GetUsersInGroup($groupIds, $pageNumber = null, $pageSize = null, $filter = null);
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
	 * @return PageableData of GroupItemView
	 */
	public function GetList($pageNumber = null, $pageSize = null, $sortField = null, $sortDirection = null, $filter = null)
	{
		$command = new GetAllGroupsCommand();

		if ($filter != null)
		{
			$command = new FilterCommand($command, $filter);
		}

		$builder = array('GroupItemView', 'Create');
		return PageableDataStore::GetList($command, $builder, $pageNumber, $pageSize);
	}

	public function GetUsersInGroup($groupIds, $pageNumber = null, $pageSize = null, $filter = null)
	{
		$command = new GetAllGroupUsersCommand($groupIds);

		if ($filter != null)
		{
			$command = new FilterCommand($command, $filter);
		}

		$builder = array('GroupUserView', 'Create');
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
		}
		$reader->Free();

		$reader = $db->Query(new GetAllGroupUsersCommand($groupId));
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
			$group->WithRole(new RoleDto($row[ColumnNames::ROLE_ID], $row[ColumnNames::ROLE_NAME], $row[ColumnNames::ROLE_LEVEL]));
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

		$db->Execute(new UpdateGroupCommand($group->Id(), $group->Name()));
	}

	public function Remove(Group $group)
	{
		ServiceLocator::GetDatabase()->Execute(new DeleteGroupCommand($group->Id()));
	}

	public function Add(Group $group)
	{
		$groupId = ServiceLocator::GetDatabase()->ExecuteInsert(new AddGroupCommand($group->Name()));
		$group->WithId($groupId);
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
		return new GroupItemView($row[ColumnNames::GROUP_ID], $row[ColumnNames::GROUP_NAME], $row[ColumnNames::GROUP_ADMIN_GROUP_NAME]);
	}

	/**
	 * @var int
	 */
	public $Id;

	/**
	 * @var string
	 */
	public $Name;

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
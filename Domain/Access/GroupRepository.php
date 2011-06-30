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
	public function Update($group);
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
	public function GetList($pageNumber, $pageSize, $sortField = null, $sortDirection = null, $filter = null);

	/**
	 * @abstract
	 * @param int $groupId
	 * @param int $pageNumber
	 * @param int $pageSize
	 * @return PageableData of GroupUserView
	 */
	public function GetUsersInGroup($groupId, $pageNumber = null, $pageSize = null);
}

class GroupRepository implements IGroupRepository, IGroupViewRepository
{
	/**
	 * @param int $pageNumber
	 * @param int $pageSize
	 * @param string $sortField
	 * @param string $sortDirection
	 * @param ISqlFilter $filter
	 * @return PageableData of GroupItemView
	 */
	public function GetList($pageNumber, $pageSize, $sortField = null, $sortDirection = null, $filter = null)
	{
		$command = new GetAllGroupsCommand();

		if ($filter != null)
		{
			$command = new FilterCommand($command, $filter);
		}

		$builder = array('GroupItemView', 'Create');
		return PageableDataStore::GetList($command, $builder, $pageNumber, $pageSize);
	}

	public function GetUsersInGroup($groupId, $pageNumber = null, $pageSize = null)
	{
		$command = new GetAllGroupUsersCommand($groupId);

		$builder = array('GroupUserView', 'Create');
		return PageableDataStore::GetList($command, $builder, $pageNumber, $pageSize);
	}

	public function LoadById($groupId)
	{
		$command = new GetGroupByIdCommand($groupId);

		$db = ServiceLocator::GetDatabase();
		$reader = $db->Query($command);
		$group = null;
		
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

		return $group;
	}

	/**
	 * @param Group $group
	 * @return void
	 */
	public function Update($group)
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
	}
}

class GroupRoles
{
	const User = 1;
	const Admin = 2;
}

class GroupUserView
{
	public static function Create($row)
	{
		return new GroupUserView(
			$row[ColumnNames::USER_ID],
			$row[ColumnNames::FIRST_NAME],
			$row[ColumnNames::LAST_NAME],
			$row[ColumnNames::ROLE_ID]);
	}

	public $UserId;
	public $FirstName;
	public $LastName;
	public $IsAdmin;
	public $RoleId;

	public function __construct($userId, $firstName, $lastName, $roleId)
	{
		$this->UserId = $userId;
		$this->FirstName = $firstName;
		$this->LastName = $lastName;
		$this->RoleId = $roleId;
		$this->IsAdmin = $roleId == GroupRoles::Admin;
	}
}

class GroupItemView
{
	public static function Create($row)
	{
		return new GroupItemView($row[ColumnNames::GROUP_ID], $row[ColumnNames::GROUP_NAME]);
	}

	public $Id;
	public $Name;
	
	public function __construct($groupId, $groupName)
	{
		$this->Id = $groupId;
		$this->Name = $groupName;
	}
}

?>
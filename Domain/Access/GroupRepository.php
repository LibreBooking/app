<?php

interface IGroupRepository
{
	
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
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
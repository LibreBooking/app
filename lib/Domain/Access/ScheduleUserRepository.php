<?php

interface IScheduleUserRepository
{
	/**
	 * @param $userId
	 * @return ScheduleUser
	 */
	function GetUser($userId);
}

class ScheduleUserRepository implements IScheduleUserRepository
{
	/**
	 * @see IScheduleUserRepository::GetUser()
	 */
	public function GetUser($userId)
	{
		return new ScheduleUser($userId, $this->GetUserResources($userId), $this->GetGroupResources($userId));
	}

	private function GetUserResources($userId)
	{
		$userCommand = new SelectUserPermissions($userId);

		$reader = ServiceLocator::GetDatabase()->Query($userCommand);
		$resources = array();

		while ($row = $reader->GetRow())
		{
			$resources[] = new ScheduleResource($row[ColumnNames::RESOURCE_ID], $row[ColumnNames::RESOURCE_NAME]);
		}

		return $resources;
	}

	private function GetGroupResources($userId)
	{
		$groupCommand = new SelectUserGroupPermissions($userId);

		$reader = ServiceLocator::GetDatabase()->Query($groupCommand);
		$groupList = array();

		while ($row = $reader->GetRow())
		{
			$groupId = $row[ColumnNames::GROUP_ID];
			$resourceId = $row[ColumnNames::RESOURCE_ID];
			$resourceName = $row[ColumnNames::RESOURCE_NAME];
				
			$groupList[$groupId][] = array($resourceId, $resourceName);
		}

		foreach($groupList as $groupId => $resourceList)
		{
			foreach($resourceList as $resourceItem)
			{
				$resources[] = new ScheduleResource($resourceItem[0], $resourceItem[1]);
			}
			$groups[] = new ScheduleGroup($groupId, $resources);
		}

		return $groups;
	}
}

class ScheduleUser
{
	private $_userId;
	private $_groups;
	private $_resources;

	/**
	 * @param int $userId;
	 * @param array[int]ScheduleResource $resources
	 * @param array[int]ScheduleGroup $groups
	 */
	public function __construct($userId, $resources, $groups)
	{
		$this->_userId = $userId;
		$this->_resources = $resources;
		$this->_groups = $groups;
	}

	/**
	 * @return int
	 */
	public function Id()
	{
		return $this->_userId;
	}

	/**
	 *
	 * @return array[int]ScheduleGroup
	 */
	function GetGroups()
	{
		return $this->_groups;
	}

	/**
	 * @return array[int]ScheduleResource
	 */
	function GetResources()
	{
		return $this->_resources;
	}
}

class ScheduleGroup
{
	private $_groupId;
	private $_resources;

	/**
	 * @param int $groupId
	 * @param array[int]ScheduleResource $resources
	 */
	public function __construct($groupId, $resources)
	{
		$this->_groupId = $groupId;
		$this->_resources = $resources;
	}

	/**
	 * @return int
	 */
	public function Id()
	{
		return $this->_groupId;
	}

	/**
	 * @return array[int]ScheduleResource
	 */
	function GetResources()
	{
		return $this->_resources;
	}
}

class ScheduleResource
{
	private $_resourceId;
	private $_name;

	/**
	 * @param int $resourceId
	 * @param string $name
	 */
	public function __construct($resourceId, $name)
	{
		$this->_resourceId = $resourceId;
		$this->_name = $name;
	}

	/**
	 * @return int
	 */
	public function Id()
	{
		return $this->_resourceId;
	}

	/**
	 * @return string
	 */
	public function Name()
	{
		return $this->_name;
	}
}
?>
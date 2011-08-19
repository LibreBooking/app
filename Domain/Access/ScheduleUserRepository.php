<?php

interface IScheduleUserRepository
{
	/**
	 * @param $userId
	 * @return IScheduleUser
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
		return new ScheduleUser($userId, $this->GetUserPermissions($userId), $this->GetGroupPermissions($userId), $this->GetGroups($userId));
	}

	private function GetUserPermissions($userId)
	{
		$userCommand = new GetUserPermissionsCommand($userId);

		$reader = ServiceLocator::GetDatabase()->Query($userCommand);
		$resources = array();

		while ($row = $reader->GetRow())
		{
			$resources[] = new ScheduleResource($row[ColumnNames::RESOURCE_ID], $row[ColumnNames::RESOURCE_NAME]);
		}

		return $resources;
	}

	/**
	 * @param $userId
	 * @return array|ScheduleGroup[]
	 */
	private function GetGroupPermissions($userId)
	{
		$groupCommand = new SelectUserGroupPermissions($userId);

		$reader = ServiceLocator::GetDatabase()->Query($groupCommand);
		$groupList = array();

		while ($row = $reader->GetRow())
		{
			$group_id = $row[ColumnNames::GROUP_ID];
			$resourceId = $row[ColumnNames::RESOURCE_ID];
			$resourceName = $row[ColumnNames::RESOURCE_NAME];
				
			$groupList[$group_id][] = array($resourceId, $resourceName);
		}

		$groups = array();
		foreach($groupList as $group_id => $resourceList)
		{
			$resources = array();
			foreach($resourceList as $resourceItem)
			{
				$resources[] = new ScheduleResource($resourceItem[0], $resourceItem[1]);
			}
			$groups[] = new ScheduleGroup($group_id, $resources);
		}

		return $groups;
	}

	private function GetGroups($userId)
	{
		$groups = array();
		$reader = ServiceLocator::GetDatabase()->Query(new GetUserGroupsCommand($userId));
		while ($row = $reader->GetRow())
		{
			$groups[] = array('groupid' => $row[ColumnNames::GROUP_ID], 'roleid' => $row[ColumnNames::ROLE_ID]);
		}

		return $groups;
	}
}

interface IScheduleUser
{
	/**
	 * @return int
	 */
	public function Id();

	/**
	 *
	 * @return array|ScheduleGroup[]
	 */
	function GetGroups();
	
	/**
	 * The resources that the user directly has permission to
	 * @return array|ScheduleResource[]
	 */
	function GetResources();
	
	/**
	 * The resources that the user or any of their groups has permission to
	 * @return array|ScheduleResource[]
	 */
	function GetAllResources();

	/**
	 * @abstract
	 * @return bool
	 */
	function IsGroupAdmin();
}

class ScheduleUser implements IScheduleUser
{
	private $_userId;
	private $_groupPermissions;
	private $_resources;
	private $_isGroupAdmin = false;

	/**
	 * @param int $userId;
	 * @param array|ScheduleResource[] $userPermissions
	 * @param array|ScheduleGroup[] $groupPermissions
	 * @param array $groups
	 */
	public function __construct($userId, $userPermissions, $groupPermissions, $groups)
	{
		$this->_userId = $userId;
		$this->_resources = $userPermissions;
		$this->_groupPermissions = $groupPermissions;

		foreach ($groups as $group)
		{
			if ($group['roleid'] == GroupRoles::Admin)
			{
				$this->_isGroupAdmin = true;
			}
		}
	}

	/**
	 * @see IScheduleUser::Id()
	 */
	public function Id()
	{
		return $this->_userId;
	}

	/**
	 * @see IScheduleUser::GetGroups()
	 */
	function GetGroups()
	{
		return $this->_groupPermissions;
	}
	
	/**
	 * @see IScheduleUser::GetResources()
	 */
	function GetResources()
	{
		return $this->_resources;
	}
	
	/**
	 * @see IScheduleUser::GetAllResources()
	 */
	public function GetAllResources()
	{
		$resources = array();
		
		foreach($this->GetResources() as $resource)
		{
			$resources[] = $resource;
		}
		
		foreach($this->GetGroups() as $group)
		{
			foreach ($group->GetResources() as $resource)
			{
				$resources[] = $resource;
			}
		}
		
		return array_unique($resources);
	}

	/**
	 * @return bool
	 */
	function IsGroupAdmin()
	{
		return $this->_isGroupAdmin;
	}
}

class ScheduleGroup
{
	private $_groupId;
	private $_resources;

	/**
	 * @param int $group_id
	 * @param array|ScheduleResource[] $resources
	 */
	public function __construct($group_id, $resources)
	{
		$this->_groupId = $group_id;
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
	 * @return array|ScheduleResource[]
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
	
	public function __toString()
	{
		// needed for array_unique
		return (string)$this->_resourceId;
	}
}

class NullScheduleResource extends ScheduleResource
{
	public function __construct()
	{
		parent::__construct(0, null);
	}
}
?>
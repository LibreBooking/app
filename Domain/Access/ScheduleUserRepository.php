<?php
/**
Copyright 2011-2017 Nick Korbel

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
	public function GetUser($userId)
	{
		return new ScheduleUser($userId, $this->GetUserPermissions($userId), $this->GetGroupPermissions($userId), $this->GetGroupAdminPermissions($userId));
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

	private function GetGroupAdminPermissions($userId)
	{
		$userCommand = new SelectUserGroupResourceAdminPermissions($userId);

		$reader = ServiceLocator::GetDatabase()->Query($userCommand);
		$resources = array();

		while ($row = $reader->GetRow())
		{
			$resources[] = new ScheduleResource($row[ColumnNames::RESOURCE_ID], $row[ColumnNames::RESOURCE_NAME]);
		}

		return $resources;
	}
}

interface IScheduleUser
{
	/**
	 * @return int
	 */
	public function Id();

	/**
	 * The resources that the user directly has permission to
	 * @return array|ScheduleResource[]
	 */
	public function GetResources();

	/**
	 * The resources that the user or any of their groups has permission to
	 * @return array|ScheduleResource[]
	 */
	public function GetAllResources();

	/**
	 * The resources that the user or any of their groups has admin access to
	 * @return array|ScheduleResource[]
	 */
	public function GetAdminResources();
}

class ScheduleUser implements IScheduleUser
{
	private $_userId;
	private $_groupPermissions;
	private $_resources;
	private $_adminResources;

	/**
	 * @param int $userId;
	 * @param array|ScheduleResource[] $userPermissions
	 * @param array|ScheduleGroup[] $groupPermissions
	 * @param array|ScheduleGroup[] $groupAdminPermissions
	 */
	public function __construct($userId, $userPermissions, $groupPermissions, $groupAdminPermissions)
	{
		$this->_userId = $userId;
		$this->_resources = $userPermissions;
		$this->_groupPermissions = $groupPermissions;
		$this->_adminResources = $groupAdminPermissions;
	}

	public function Id()
	{
		return $this->_userId;
	}

	private function GetGroupPermissions()
	{
		return $this->_groupPermissions;
	}

	public function GetResources()
	{
		return $this->_resources;
	}

	public function GetAdminResources()
	{
		return $this->_adminResources;
	}

	public function GetAllResources()
	{
		$resources = array();

		foreach($this->GetResources() as $resource)
		{
			$resources[] = $resource;
		}

		foreach($this->GetGroupPermissions() as $group)
		{
			foreach ($group->GetResources() as $resource)
			{
				$resources[] = $resource;
			}
		}

		foreach ($this->GetAdminResources() as $resource)
		{
			$resources[] = $resource;
		}

		return array_unique($resources);
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

	public function GetMinimumLength()
	{
		return null;
	}
}
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

class Group
{
	private $id;
	private $name;
	private $adminGroupId;

	private $addedUsers = array();
	private $removedUsers = array();
	private $users = array();

	private $permissionsChanged = false;
	private $removedPermissions = array();
	private $addedPermissions = array();
	private $allowedResourceIds = array();

	private $rolesChanged = false;

	/**
	 * @var array|int[]
	 */
	private $removedRoleIds = array();

	/**
	 * @var array|int[]
	 */
	private $addedRoleIds = array();

	/**
	 * @var array|RoleDto[]
	 */
	private $roleIds = array();

	/**
	 * @param $id int
	 * @param $name string
	 */
	public function __construct($id, $name)
	{
		$this->id = $id;
		$this->name = $name;
	}

	/**
	 * @return int
	 */
	public function Id()
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function Name()
	{
		return $this->name;
	}

	/**
	 * @return int
	 */
	public function AdminGroupId()
	{
		return $this->adminGroupId;
	}

	/**
	 * @param $groupName string
	 * @return void
	 */
	public function Rename($groupName)
	{
		$this->name = $groupName;
	}

	/**
	 * @param $userId int
	 * @return void
	 */
	public function AddUser($userId)
	{
		if (!$this->HasMember($userId))
		{
			$this->addedUsers[] = $userId;
		}
	}

	/**
	 * @param $userId int
	 * @return void
	 */
	public function RemoveUser($userId)
	{
		if ($this->HasMember($userId))
		{
			$this->removedUsers[] = $userId;
		}
	}

	/**
	 * @internal
	 * @return int[] array of userIds
	 */
	public function AddedUsers()
	{
		return $this->addedUsers;
	}

	/**
	 * @internal
	 * @return int[] array of userIds
	 */
	public function RemovedUsers()
	{
		return $this->removedUsers;
	}

	/**
	 * @internal
	 * @return array|int[]
	 */
	public function AddedRoles()
	{
		return $this->addedRoleIds;
	}

	/**
	 * @internal
	 * @return array|int[]
	 */
	public function RemovedRoles()
	{
		return $this->removedRoleIds;
	}

	/**
	 * @internal
	 * @param $groupId
	 * @return void
	 */
	public function WithId($groupId)
	{
		$this->id = $groupId;
	}

	/**
	 * @internal
	 * @param $userId int
	 * @return void
	 */
	public function WithUser($userId)
	{
		$this->users[] = $userId;
	}

	/**
	 * @internal
	 * @param $groupId int
	 * @return void
	 */
	public function WithGroupAdmin($groupId)
	{
		$this->adminGroupId = $groupId;
	}

	/**
	 * @param $userId
	 * @return bool
	 */
	public function HasMember($userId)
	{
		return in_array($userId, $this->users);
	}

	/**
	 * @return array|int[]
	 */
	public function UserIds()
	{
		return $this->users;
	}

	/**
	 * @param int $allowedResourceId
	 * @return void
	 */
	public function WithPermission($allowedResourceId)
	{
		$this->permissionsChanged = false;
		$this->allowedResourceIds[] = $allowedResourceId;
	}

	/**
	 * @param $role int
	 * @return void
	 */
	public function WithRole($role)
	{
		$this->rolesChanged = false;
		$this->roleIds[] = $role;
	}

	/**
	 * @param int[] $allowedResourceIds
	 * @return void
	 */
	public function ChangePermissions($allowedResourceIds = array())
	{
		$diff = new ArrayDiff($this->allowedResourceIds, $allowedResourceIds);
		$removed = $diff->GetRemovedFromArray1();
		$added = $diff->GetAddedToArray1();

		if ($diff->AreDifferent())
		{
			$this->permissionsChanged = true;
			$this->removedPermissions = $removed;
			$this->addedPermissions = $added;

			$this->allowedResourceIds = $allowedResourceIds;
		}
	}

	/**
	 * @internal
	 * @return int[]|array of resourceIds
	 */
	public function RemovedPermissions()
	{
		return $this->removedPermissions;
	}

	/**
	 * @internal
	 * @return int[]|array of resourceIds
	 */
	public function AddedPermissions()
	{
		return $this->addedPermissions;
	}

	/**
	 * @return array|int[]
	 */
	public function AllowedResourceIds()
	{
		return $this->allowedResourceIds;
	}

	/**
	 * @return array|int[]
	 */
	public function RoleIds()
	{
		return $this->roleIds;
	}

	/**
	 * @param $roleIds int[]|array
	 * @return void
	 */
	public function ChangeRoles($roleIds)
	{
		$diff = new ArrayDiff($this->roleIds, $roleIds);
		$removed = $diff->GetRemovedFromArray1();
		$added = $diff->GetAddedToArray1();

		if ($diff->AreDifferent())
		{
			$this->rolesChanged = true;
			$this->removedRoleIds = $removed;
			$this->addedRoleIds = $added;

			$this->roleIds = $roleIds;
		}
	}

	/**
	 * @param $groupId int
	 * @return void
	 */
	public function ChangeAdmin($groupId)
	{
		if (empty($groupId))
		{
			$groupId = null;
		}
		$this->adminGroupId = $groupId;
	}

	public static function Null()
	{
		return new NullGroup();
	}
}

class NullGroup extends Group
{
	public function __construct()
	{
		parent::__construct(0, null);
	}
}

?>
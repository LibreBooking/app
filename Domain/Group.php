<?php

class Group
{
	private $id;
	private $name;
	
	private $addedUsers = array();
	private $removedUsers = array();
	private $users = array();
	
	private $permissionsChanged = false;
	private $removedPermissions = array();
	private $addedPermissions = array();
	private $allowedResourceIds = array();

	public function __construct($id, $name)
	{
		$this->id = $id;
		$this->name = $name;
	}

	public function Id()
	{
		return $this->id;
	}

	public function Name()
	{
		return $this->name;
	}

	public function Rename($groupName)
	{
		$this->name = $groupName;
	}

	public function AddUser($userId)
	{
		if (!$this->HasMember($userId))
		{
			$this->addedUsers[] = $userId;
		}
	}

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
	 * @param $groupId
	 * @return void
	 */
	public function WithId($groupId)
	{
		$this->id = $groupId;
	}

	/**
	 * @internal
	 * @param $userId
	 * @return void
	 */
	public function WithUser($userId)
	{
		$this->users[] = $userId;
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
	 * @param int $allowedResourceId
	 * @return void
	 */
	public function WithPermission($allowedResourceId)
	{
		$this->permissionsChanged = false;
		$this->allowedResourceIds[] = $allowedResourceId;
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
	 * @return int[] array of resourceIds
	 */
	public function RemovedPermissions()
	{
		return $this->removedPermissions;
	}

	/**
	 * @internal
	 * @return int[] array of resourceIds
	 */
	public function AddedPermissions()
	{
		return $this->addedPermissions;
	}

	/**
	 * @return array
	 */
	public function AllowedResourceIds()
	{
		return $this->allowedResourceIds;
	}
}

?>
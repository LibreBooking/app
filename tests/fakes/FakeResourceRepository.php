<?php
/**
Copyright 2013-2018 Nick Korbel

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

require_once(ROOT_DIR . 'Domain/Access/ResourceRepository.php');

class FakeResourceRepository implements IResourceRepository
{
	/**
	 * @var array|BookableResource[]
	 */
	public $_ResourceList = array();

	/**
	 * @var FakeBookableResource
	 */
	public $_Resource;

	/**
	 * @var BookableResource|FakeBookableResource
	 */
	public $_UpdatedResource;

    public $_NamedResources = array();

	public function GetScheduleResources($scheduleId)
	{
		// TODO: Implement GetScheduleResources() method.
	}

	public function LoadById($resourceId)
	{
	    if (isset($this->_ResourceList[$resourceId]))
        {
            return $this->_ResourceList[$resourceId];
        }
		return $this->_Resource;
	}

	public function LoadByPublicId($publicId)
	{
		return $this->_Resource;
	}

    public function LoadByName($name)
    {
        return $this->_NamedResources[$name];
    }

	public function Add(BookableResource $resource)
	{
		// TODO: Implement Add() method.
	}

	public function Update(BookableResource $resource)
	{
		$this->_UpdatedResource = $resource;
	}

	public function Delete(BookableResource $resource)
	{
		// TODO: Implement Delete() method.
	}

	public function GetResourceList()
	{
		return $this->_ResourceList;
	}

	public function GetList($pageNumber, $pageSize, $sortField = null, $sortDirection = null, $filter = null)
    {
        // TODO: Implement GetList() method.
    }

	public function GetAccessoryList($sortField = null, $sortDirection = null)
	{
		// TODO: Implement GetAccessoryList() method.
	}

	public function GetResourceGroups($scheduleId = null, $resourceFilter = null)
	{
		// TODO: Implement GetResourceGroups() method.
	}

	public function AddResourceToGroup($resourceId, $groupId)
	{
		// TODO: Implement AddResourceToGroup() method.
	}

	public function RemoveResourceFromGroup($resourceId, $groupId)
	{
		// TODO: Implement RemoveResourceFromGroup() method.
	}

	public function AddResourceGroup(ResourceGroup $group)
	{
		// TODO: Implement AddResourceGroup() method.
	}

	public function LoadResourceGroup($groupId)
	{
		// TODO: Implement LoadResourceGroup() method.
	}

	public function LoadResourceGroupByPublicId($publicResourceGroupId)
	{
		// TODO: Implement LoadResourceGroupByPublicId() method.
	}

	public function UpdateResourceGroup(ResourceGroup $group)
	{
		// TODO: Implement UpdateResourceGroup() method.
	}

	public function DeleteResourceGroup($groupId)
	{
		// TODO: Implement DeleteResourceGroup() method.
	}

	public function GetResourceTypes()
	{
		// TODO: Implement GetResourceTypes() method.
	}

	public function LoadResourceType($resourceTypeId)
	{
		// TODO: Implement LoadResourceType() method.
	}

	public function AddResourceType(ResourceType $type)
	{
		// TODO: Implement AddResourceType() method.
	}

	public function UpdateResourceType(ResourceType $type)
	{
		// TODO: Implement UpdateResourceType() method.
	}

	public function RemoveResourceType($id)
	{
		// TODO: Implement RemoveResourceType() method.
	}

	public function GetStatusReasons()
	{
		// TODO: Implement GetStatusReasons() method.
	}

	public function AddStatusReason($statusId, $reasonDescription)
	{
		// TODO: Implement AddStatusReason() method.
	}

	public function UpdateStatusReason($reasonId, $reasonDescription)
	{
		// TODO: Implement UpdateStatusReason() method.
	}

	public function RemoveStatusReason($reasonId)
	{
		// TODO: Implement RemoveStatusReason() method.
	}

	public function GetUsersWithPermission($resourceId, $pageNumber = null, $pageSize = null, $filter = null,
										   $accountStatus = AccountStatus::ACTIVE)
	{
		// TODO: Implement GetUsersWithPermission() method.
	}

	public function GetGroupsWithPermission($resourceId, $pageNumber = null, $pageSize = null, $filter = null)
	{
		// TODO: Implement GetGroupsWithPermission() method.
	}

	public function AddResourceUserPermission($resourceId, $userId)
	{
		// TODO: Implement AddResourceUserPermission() method.
	}

	public function RemoveResourceUserPermission($resourceId, $userId)
	{
		// TODO: Implement RemoveResourceUserPermission() method.
	}

	public function AddResourceGroupPermission($resourceId, $groupId)
	{
		// TODO: Implement AddResourceGroupPermission() method.
	}

	public function RemoveResourceGroupPermission($resourceId, $groupId)
	{
		// TODO: Implement RemoveResourceGroupPermission() method.
	}

	public function GetUsersWithPermissionsIncludingGroups($resourceId, $pageNumber = null, $pageSize = null, $filter = null, $accountStatus = AccountStatus::ACTIVE)
	{
		// TODO: Implement GetUsersWithPermissionsIncludingGroups() method.
	}

    /**
     * @param int $resourceId
     * @param int $groupId
     * @param int $type
     */
    public function ChangeResourceGroupPermission($resourceId, $groupId, $type)
    {
        // TODO: Implement ChangeResourceGroupPermission() method.
    }
}
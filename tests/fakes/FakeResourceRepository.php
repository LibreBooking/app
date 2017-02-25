<?php
/**
Copyright 2013-2017 Nick Korbel

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

	/**
	 * Gets all Resources for the given scheduleId
	 *
	 * @param int $scheduleId
	 * @return array|BookableResource[]
	 */
	public function GetScheduleResources($scheduleId)
	{
		// TODO: Implement GetScheduleResources() method.
	}

	/**
	 * @param int $resourceId
	 * @return BookableResource
	 */
	public function LoadById($resourceId)
	{
		return $this->_Resource;
	}

	/**
	 * @param string $publicId
	 * @return BookableResource
	 */
	public function LoadByPublicId($publicId)
	{
		return $this->_Resource;
	}

    public function LoadByName($name)
    {
        return $this->_NamedResources[$name];
    }

	/**
	 * @param BookableResource $resource
	 * @return int ID of created resource
	 */
	public function Add(BookableResource $resource)
	{
		// TODO: Implement Add() method.
	}

	/**
	 * @param BookableResource $resource
	 */
	public function Update(BookableResource $resource)
	{
		$this->_UpdatedResource = $resource;
	}

	/**
	 * @param BookableResource $resource
	 */
	public function Delete(BookableResource $resource)
	{
		// TODO: Implement Delete() method.
	}

	/**
	 * @return array|BookableResource[] array of all resources
	 */
	public function GetResourceList()
	{
		return $this->_ResourceList;
	}

	/**
	 * @param int $pageNumber
	 * @param int $pageSize
	 * @param string|null $sortField
	 * @param string|null $sortDirection
	 * @param ISqlFilter $filter
	 * @return PageableData|BookableResource[]
	 */
	public function GetList($pageNumber, $pageSize, $sortField = null, $sortDirection = null, $filter = null)
	{
		// TODO: Implement GetList() method.
	}

	/**
	 * @return array|AccessoryDto[] all accessories
	 */
	public function GetAccessoryList($sortField = null, $sortDirection = null)
	{
		// TODO: Implement GetAccessoryList() method.
	}

	/**
	 * @param int|null $scheduleId
	 * @param IResourceFilter|null $resourceFilter
	 * @return ResourceGroupTree
	 */
	public function GetResourceGroups($scheduleId = null, $resourceFilter = null)
	{
		// TODO: Implement GetResourceGroups() method.
	}

	/**
	 * @param int $resourceId
	 * @param int $groupId
	 */
	public function AddResourceToGroup($resourceId, $groupId)
	{
		// TODO: Implement AddResourceToGroup() method.
	}

	/**
	 * @param int $resourceId
	 * @param int $groupId
	 */
	public function RemoveResourceFromGroup($resourceId, $groupId)
	{
		// TODO: Implement RemoveResourceFromGroup() method.
	}

	/**
	 * @param ResourceGroup $group
	 * @return ResourceGroup
	 */
	public function AddResourceGroup(ResourceGroup $group)
	{
		// TODO: Implement AddResourceGroup() method.
	}

	/**
	 * @param int $groupId
	 * @return ResourceGroup
	 */
	public function LoadResourceGroup($groupId)
	{
		// TODO: Implement LoadResourceGroup() method.
	}

	/**
	 * @param string $publicResourceGroupId
	 * @return ResourceGroup
	 */
	public function LoadResourceGroupByPublicId($publicResourceGroupId)
	{
		// TODO: Implement LoadResourceGroupByPublicId() method.
	}

	/**
	 * @param ResourceGroup $group
	 */
	public function UpdateResourceGroup(ResourceGroup $group)
	{
		// TODO: Implement UpdateResourceGroup() method.
	}

	/**
	 * @param $groupId
	 */
	public function DeleteResourceGroup($groupId)
	{
		// TODO: Implement DeleteResourceGroup() method.
	}

	/**
	 * @return ResourceType[]|array
	 */
	public function GetResourceTypes()
	{
		// TODO: Implement GetResourceTypes() method.
	}

	/**
	 * @param int $resourceTypeId
	 * @return ResourceType
	 */
	public function LoadResourceType($resourceTypeId)
	{
		// TODO: Implement LoadResourceType() method.
	}

	/**
	 * @param ResourceType $type
	 * @return int
	 */
	public function AddResourceType(ResourceType $type)
	{
		// TODO: Implement AddResourceType() method.
	}

	/**
	 * @param ResourceType $type
	 */
	public function UpdateResourceType(ResourceType $type)
	{
		// TODO: Implement UpdateResourceType() method.
	}

	/**
	 * @param int $id
	 */
	public function RemoveResourceType($id)
	{
		// TODO: Implement RemoveResourceType() method.
	}

	/**
	 * @return ResourceStatusReason[]
	 */
	public function GetStatusReasons()
	{
		// TODO: Implement GetStatusReasons() method.
	}

	/**
	 * @param int $statusId
	 * @param string $reasonDescription
	 * @return int
	 */
	public function AddStatusReason($statusId, $reasonDescription)
	{
		// TODO: Implement AddStatusReason() method.
	}

	/**
	 * @param int $reasonId
	 * @param string $reasonDescription
	 */
	public function UpdateStatusReason($reasonId, $reasonDescription)
	{
		// TODO: Implement UpdateStatusReason() method.
	}

	/**
	 * @param int $reasonId
	 */
	public function RemoveStatusReason($reasonId)
	{
		// TODO: Implement RemoveStatusReason() method.
	}

	/**
	 * @param int $resourceId
	 * @param int|null $pageNumber
	 * @param int|null $pageSize
	 * @param ISqlFilter|null $filter
	 * @param int $accountStatus
	 * @return PageableData|UserItemView[]
	 */
	public function GetUsersWithPermission($resourceId, $pageNumber = null, $pageSize = null, $filter = null,
										   $accountStatus = AccountStatus::ACTIVE)
	{
		// TODO: Implement GetUsersWithPermission() method.
	}

	/**
	 * @param int $resourceId
	 * @param int|null $pageNumber
	 * @param int|null $pageSize
	 * @param ISqlFilter|null $filter
	 * @return PageableData|GroupItemView[]
	 */
	public function GetGroupsWithPermission($resourceId, $pageNumber = null, $pageSize = null, $filter = null)
	{
		// TODO: Implement GetGroupsWithPermission() method.
	}

	/**
	 * @param int $resourceId
	 * @param int $userId
	 */
	public function AddResourceUserPermission($resourceId, $userId)
	{
		// TODO: Implement AddResourceUserPermission() method.
	}

	/**
	 * @param int $resourceId
	 * @param int $userId
	 */
	public function RemoveResourceUserPermission($resourceId, $userId)
	{
		// TODO: Implement RemoveResourceUserPermission() method.
	}

	/**
	 * @param $resourceId
	 * @param $groupId
	 */
	public function AddResourceGroupPermission($resourceId, $groupId)
	{
		// TODO: Implement AddResourceGroupPermission() method.
	}

	/**
	 * @param $resourceId
	 * @param $groupId
	 */
	public function RemoveResourceGroupPermission($resourceId, $groupId)
	{
		// TODO: Implement RemoveResourceGroupPermission() method.
	}

	/**
	 * @param int $resourceId
	 * @param int|null $pageNumber
	 * @param int|null $pageSize
	 * @param ISqlFilter|null $filter
	 * @param int $accountStatus
	 * @return PageableData|UserItemView[]
	 */
	public function GetUsersWithPermissionsIncludingGroups($resourceId, $pageNumber = null, $pageSize = null, $filter = null, $accountStatus = AccountStatus::ACTIVE)
	{
		// TODO: Implement GetUsersWithPermissionsIncludingGroups() method.
	}
}
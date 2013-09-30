<?php
/**
Copyright 2011-2013 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/Application/Attributes/namespace.php');

interface IResourceService
{
	/**
	 * Gets resource list for a schedule
	 * @param int $scheduleId
	 * @param bool $includeInaccessibleResources
	 * @param UserSession $user
	 * @param int $groupId
	 * @param int $resourceId
	 * @return array|ResourceDto[]
	 */
	public function GetScheduleResources($scheduleId, $includeInaccessibleResources, UserSession $user, $groupId = null,
										 $resourceId = null);

	/**
	 * Gets resource list
	 * @param bool $includeInaccessibleResources
	 * @param UserSession $user
	 * @return array|ResourceDto[]
	 */
	public function GetAllResources($includeInaccessibleResources, UserSession $user);

	/**
	 * @abstract
	 * @return array|AccessoryDto[]
	 */
	public function GetAccessories();

	/**
	 * @param $scheduleId
	 * @return ResourceGroupTree
	 */
	public function GetResourceGroups($scheduleId);

	/**
	 * @return ResourceType[]
	 */
	public function GetResourceTypes();

	/**
	 * @return Attribute[]
	 */
	public function GetResourceAttributes();

	/**
	 * @return Attribute[]
	 */
	public function GetResourceTypeAttributes();
}

class ResourceService implements IResourceService
{
	/**
	 * @var IResourceRepository
	 */
	private $_resourceRepository;

	/**
	 * @var IPermissionService
	 */
	private $_permissionService;

	/**
	 * @var IAttributeService
	 */
	private $_attributeService;

	public function __construct(IResourceRepository $resourceRepository, IPermissionService $permissionService,
								IAttributeService $attributeService)
	{
		$this->_resourceRepository = $resourceRepository;
		$this->_permissionService = $permissionService;
		$this->_attributeService = $attributeService;
	}

	public function GetScheduleResources($scheduleId, $includeInaccessibleResources, UserSession $user, $groupId = null,
										 $resourceId = null)
	{
		$resources = $this->_resourceRepository->GetScheduleResources($scheduleId);

		$resourceIds = null;
		if (empty($groupId) && !empty($resourceId))
		{
			$resourceIds = array($resourceId);
		}
		else
		{
			if (!empty($groupId))
			{
				$groups = $this->_resourceRepository->GetResourceGroups($scheduleId);
				$resourceIds = $groups->GetResourceIds($groupId);
			}
		}

		return $this->Filter($resources, $user, $includeInaccessibleResources, $resourceIds);
	}

	public function GetAllResources($includeInaccessibleResources, UserSession $user)
	{
		$resources = $this->_resourceRepository->GetResourceList();

		return $this->Filter($resources, $user, $includeInaccessibleResources);
	}

	/**
	 * @param $resources array|BookableResource[]
	 * @param $user UserSession
	 * @param $includeInaccessibleResources bool
	 * @param int[] $resourceIds
	 * @return array|ResourceDto[]
	 */
	private function Filter($resources, $user, $includeInaccessibleResources, $resourceIds = null)
	{
		$resourceDtos = array();
		foreach ($resources as $resource)
		{
			if (is_array($resourceIds) && !in_array($resource->GetId(), $resourceIds))
			{
				continue;
			}

			$canAccess = $this->_permissionService->CanAccessResource($resource, $user);

			if (!$includeInaccessibleResources && !$canAccess)
			{
				continue;
			}

			$resourceDtos[] = new ResourceDto($resource->GetResourceId(), $resource->GetName(), $canAccess, $resource->GetScheduleId(), $resource->GetMinLength());
		}
		return $resourceDtos;
	}

	public function GetAccessories()
	{
		return $this->_resourceRepository->GetAccessoryList();
	}

	public function GetResourceGroups($scheduleId)
	{
		return $this->_resourceRepository->GetResourceGroups($scheduleId);
	}

	public function GetResourceTypes()
	{
		return $this->_resourceRepository->GetResourceTypes();
	}

	/**
	 * @return Attribute[]
	 */
	public function GetResourceAttributes()
	{
		$attributes = array();
		$customAttributes = $this->_attributeService->GetByCategory(CustomAttributeCategory::RESOURCE);
		foreach ($customAttributes as $ca)
		{
			$attributes[] = new Attribute($ca);
		}

		return $attributes;
	}

	/**
	 * @return Attribute[]
	 */
	public function GetResourceTypeAttributes()
	{
		$attributes = array();
		$customAttributes = $this->_attributeService->GetByCategory(CustomAttributeCategory::RESOURCE_TYPE);
		foreach ($customAttributes as $ca)
		{
			$attributes[] = new Attribute($ca);
		}

		return $attributes;
	}
}


class ResourceDto
{
	/**
	 * @param int $id
	 * @param string $name
	 * @param bool $canAccess
	 * @param null|int $scheduleId
	 * @param null|TimeInterval $minLength
	 */
	public function __construct($id, $name, $canAccess = true, $scheduleId = null, $minLength = null)
	{
		$this->Id = $id;
		$this->Name = $name;
		$this->CanAccess = $canAccess;
		$this->ScheduleId = $scheduleId;
		$this->MinimumLength = $minLength;
	}

	/**
	 * @var int
	 */
	public $Id;

	/**
	 * @var string
	 */
	public $Name;

	/**
	 * @var bool
	 */
	public $CanAccess;

	/**
	 * @var null|int
	 */
	public $ScheduleId;

	/**
	 * @var null|TimeInterval
	 */
	public $MinimumLength;

	/**
	 * alias of GetId()
	 * @return int
	 */
	public function GetResourceId()
	{
		return $this->Id;
	}

	/**
	 * @return int
	 */
	public function GetId()
	{
		return $this->Id;
	}

	/**
	 * @return string
	 */
	public function GetName()
	{
		return $this->Name;
	}

	/**
	 * @return int|null
	 */
	public function GetScheduleId()
	{
		return $this->ScheduleId;
	}

	/**
	 * @return null|TimeInterval
	 */
	public function GetMinimumLength()
	{
		return $this->MinimumLength;
	}
}

?>
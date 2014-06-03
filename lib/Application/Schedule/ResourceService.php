<?php
/**
Copyright 2011-2014 Nick Korbel

This file is part of Booked SchedulerBooked SchedulereIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later versBooked SchedulerduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
alBooked SchedulercheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/Application/Attributes/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

interface IResourceService
{
	/**
	 * Gets resource list for a schedule
	 * @param int $scheduleId
	 * @param bool $includeInaccessibleResources
	 * @param UserSession $user
	 * @param ScheduleResourceFilter|null $filter
	 * @return array|ResourceDto[]
	 */
	public function GetScheduleResources($scheduleId, $includeInaccessibleResources, UserSession $user, $filter = null);

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
	 * @param int $scheduleId
	 * @param UserSession $user
	 * @return ResourceGroupTree
	 */
	public function GetResourceGroups($scheduleId, UserSession $user);

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

	/**
	 * @var IUserRepository
	 */
	private $_userRepository;

	public function __construct(IResourceRepository $resourceRepository,
								IPermissionService $permissionService,
								IAttributeService $attributeService,
								IUserRepository $userRepository)
	{
		$this->_resourceRepository = $resourceRepository;
		$this->_permissionService = $permissionService;
		$this->_attributeService = $attributeService;
		$this->_userRepository = $userRepository;
	}

	public function GetScheduleResources($scheduleId, $includeInaccessibleResources, UserSession $user, $filter = null)
	{
		if ($filter == null)
		{
			$filter = new ScheduleResourceFilter();
		}

		$resources = $this->_resourceRepository->GetScheduleResources($scheduleId);
		$resourceIds = $filter->FilterResources($resources, $this->_resourceRepository, $this->_attributeService);

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
		$filter = new ResourcePermissionFilter($this->_permissionService, $user);
		$statusFilter = new ResourceStatusFilter($this->_userRepository, $user);

		$resourceDtos = array();
		foreach ($resources as $resource)
		{
			if (is_array($resourceIds) && !in_array($resource->GetId(), $resourceIds))
			{
				continue;
			}

			$canAccess = $filter->ShouldInclude($resource);

			if (!$includeInaccessibleResources && !$canAccess)
			{
				continue;
			}

			if ($canAccess)
			{
				$canAccess = $statusFilter->ShouldInclude($resource);
			}

			$resourceDtos[] = new ResourceDto($resource->GetResourceId(), $resource->GetName(), $canAccess, $resource->GetScheduleId(), $resource->GetMinLength());
		}

		return $resourceDtos;
	}

	public function GetAccessories()
	{
		return $this->_resourceRepository->GetAccessoryList();
	}

	public function GetResourceGroups($scheduleId, UserSession $user)
	{
		$filter = new CompositeResourceFilter();
		$filter->Add(new ResourcePermissionFilter($this->_permissionService, $user));
		$filter->Add(new ResourceStatusFilter($this->_userRepository, $user));

		$groups = $this->_resourceRepository->GetResourceGroups($scheduleId, $filter);

		return $groups;
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
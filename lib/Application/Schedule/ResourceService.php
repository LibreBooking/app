<?php
/**
 * Copyright 2011-2020 Nick Korbel
 *
 * This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
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
	 * @param ScheduleResourceFilter|null $filter
	 * @param null $pageNumber
	 * @param null $pageSize
	 * @return array|ResourceDto[]
	 */
	public function GetAllResources($includeInaccessibleResources, UserSession $user, $filter = null, $pageNumber = null, $pageSize = null);

	/**
	 * @return Accessory[]
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

	/**
	 * @param int $resourceId
	 * @return BookableResource
	 */
	public function GetResource($resourceId);
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

	/**
	 * @var IAccessoryRepository
	 */
	private $_accessoryRepository;

	public function __construct(IResourceRepository $resourceRepository,
								IPermissionService $permissionService,
								IAttributeService $attributeService,
								IUserRepository $userRepository,
								IAccessoryRepository $accessoryRepository)
	{
		$this->_resourceRepository = $resourceRepository;
		$this->_permissionService = $permissionService;
		$this->_attributeService = $attributeService;
		$this->_userRepository = $userRepository;
		$this->_accessoryRepository = $accessoryRepository;
	}

	/**
	 * @return ResourceService
	 */
	public static function Create()
	{
		return new ResourceService(new ResourceRepository(),
								   PluginManager::Instance()->LoadPermission(),
								   new AttributeService(new AttributeRepository()),
								   new UserRepository(), new AccessoryRepository());
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

	public function GetAllResources($includeInaccessibleResources, UserSession $user, $filter = null, $pageNumber = null, $pageSize = null)
	{
		if ($filter == null)
		{
			$filter = new ScheduleResourceFilter();
		}

		if ($pageNumber != null || $pageSize != null)
		{
			$resources = $this->_resourceRepository->GetList($pageNumber, $pageSize);
			$resources = $resources->Results();
		}
		else
		{
			$resources = $this->_resourceRepository->GetResourceList();
		}
		$resourceIds = $filter->FilterResources($resources, $this->_resourceRepository, $this->_attributeService);

		return $this->Filter($resources, $user, $includeInaccessibleResources, $resourceIds);
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
				if (!$includeInaccessibleResources && !$canAccess)
				{
					continue;
				}
			}

			$resourceDtos[] = new ResourceDto($resource->GetResourceId(),
											  $resource->GetName(),
											  $canAccess,
											  $canAccess && $filter->CanBook($resource),
											  $resource->GetScheduleId(),
											  $resource->GetMinLength(),
											  $resource->GetResourceTypeId(),
											  $resource->GetAdminGroupId(),
											  $resource->GetScheduleAdminGroupId(),
											  $resource->GetStatusId(),
											  $resource->GetRequiresApproval(),
											  $resource->IsCheckInEnabled(),
											  $resource->IsAutoReleased(),
											  $resource->GetAutoReleaseMinutes(),
											  $resource->GetColor(),
											  $resource->GetMaxConcurrentReservations());
		}

		return $resourceDtos;
	}

	public function GetAccessories()
	{
		return $this->_accessoryRepository->LoadAll();
	}

	public function GetResourceGroups($scheduleId, UserSession $user)
	{
		$filter = new CompositeResourceFilter();
		if (!Configuration::Instance()->GetSectionKey(ConfigSection::SCHEDULE, ConfigKeys::SCHEDULE_SHOW_INACCESSIBLE_RESOURCES, new BooleanConverter()))
		{
			$filter->Add(new ResourcePermissionFilter($this->_permissionService, $user));
		}
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

	public function GetResource($resourceId)
	{
		return $this->_resourceRepository->LoadById($resourceId);
	}
}
<?php
class ResourceService implements IResourceService
{
	/**
	 * @var \IResourceRepository
	 */
	private $_resourceRepository;

	/**
	 * @var \IPermissionService
	 */
	private $_permissionService;

	public function __construct(IResourceRepository $resourceRepository, IPermissionService $permissionService)
	{
		$this->_resourceRepository = $resourceRepository;
		$this->_permissionService = $permissionService;
	}
	

	/**
	 * @param $scheduleId
	 * @param $includeInaccessibleResources
	 * @param UserSession $user
	 * @return array|ResourceDto[]
	 */
	public function GetScheduleResources($scheduleId, $includeInaccessibleResources, UserSession $user)
	{
		$resourceDtos = array();
		$resources = $this->_resourceRepository->GetScheduleResources($scheduleId);
		
		foreach ($resources as $resource)
		{
			$canAccess = $this->_permissionService->CanAccessResource($resource, $user);
			
			if (!$includeInaccessibleResources && !$canAccess)
			{
				continue;
			}
			
			$resourceDtos[] = new ResourceDto($resource->GetResourceId(), $resource->GetName(), $canAccess);
		}
		
		return $resourceDtos;
	}

	/**
	 * @return array|AccessoryDto[]
	 */
	public function GetAccessories()
	{
		return $this->_resourceRepository->GetAccessoryList();
	}
}

interface IResourceService
{
	/**
	 * Gets resource list for a schedule
	 * @param int $scheduleId
	 * @param bool $includeInaccessibleResources
	 * @param UserSession $user
	 * @return array|ResourceDto[]
	 */
	public function GetScheduleResources($scheduleId, $includeInaccessibleResources, UserSession $user);

	/**
	 * @abstract
	 * @return array|AccessoryDto[]
	 */
	public function GetAccessories();
}

class ResourceDto
{
	public function __construct($id, $name, $canAccess = true)
	{
		$this->Id = $id;
		$this->Name = $name;
		$this->CanAccess = $canAccess;
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
}
?>
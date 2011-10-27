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
		// TODO: implement going to repository
		return array(new AccessoryDto(2, "number 2", 20), new AccessoryDto(4, "number 4", 40));
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

class AccessoryDto
{
	/**
	 * @var int
	 */
	public $Id;

	/**
	 * @var string
	 */
	public $Name;

	/**
	 * @var int
	 */
	public $QuantityAvailable;

	public function __construct($id, $name, $quantityAvailable)
	{
		$this->Id = $id;
		$this->Name = $name;
		$this->QuantityAvailable = $quantityAvailable;
	}
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
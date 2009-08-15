<?php
class ResourceService implements IResourceService
{
	private $_resourceRepository;
	private $_permissionService;
	
	public function __construct(IResourceRepository $resourceRepository, IPermissionService $permissionService)
	{
		$this->_resourceRepository = $resourceRepository;
		$this->_permissionService = $permissionService;
	}
	
	public function GetScheduleResources($scheduleId)
	{
		$resourceDtos = array();
		$resources = $this->_resourceRepository->GetScheduleResources($scheduleId);
		
		foreach ($resources as $resource)
		{
			$canAccess = $this->_permissionService->CanAccessResource($resource);
			$resourceDtos[] = new ResourceDto($resource->GetResourceId(), $resource->GetName(), $canAccess);
		}
		
		return $resourceDtos;
	}
}

interface IResourceService
{
	/**
	 * Gets resource list for a schedule
	 * @param int $scheduleId
	 * @return array[int]ResourceDto
	 */
	public function GetScheduleResources($scheduleId);
}

class ResourceDto
{
	public function __construct($id, $name, $canAccess)
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
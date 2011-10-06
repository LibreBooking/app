<?php
class ResourceService implements IResourceService
{
	/**
	 * @var \IResourceRepository
	 */
	private $_resourceRepository;
	
	public function __construct(IResourceRepository $resourceRepository)
	{
		$this->_resourceRepository = $resourceRepository;
	}
	
	/**
	 * @see IResourceService::GetScheduleResources()
	 */
	public function GetScheduleResources($scheduleId, $includeInaccessibleResources, IPermissionService $permissionService, UserSession $user)
	{
		$resourceDtos = array();
		$resources = $this->_resourceRepository->GetScheduleResources($scheduleId);
		
		foreach ($resources as $resource)
		{
			$canAccess = $permissionService->CanAccessResource($resource, $user);
			
			if (!$includeInaccessibleResources && !$canAccess)
			{
				continue;
			}
			
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
	 * @param bool $includeInaccessibleResources
	 * @param IPermissionService $permissionService
	 * @param UserSession $user
	 * @return array[int]ResourceDto
	 */
	public function GetScheduleResources($scheduleId, $includeInaccessibleResources, IPermissionService $permissionService, UserSession $user);
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
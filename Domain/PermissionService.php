<?php
interface IPermissionService
{
	
	/**
	 * @param IResource $resource
	 * @return bool
	 */
	public function CanAccessResource(IResource $resource);	
}

class PermissionService implements IPermissionService
{
	/**
	 * @var IResourcePermissionStore
	 */
	private $_store;
	
	/**
	 * @var int
	 */
	private $_userId;
	
	private $_allowedResourceIds;
	
	/**
	 * @param IResourcePermissionStore $store
	 * @param int $userId
	 */
	public function __construct(IResourcePermissionStore $store, $userId)
	{
		$this->_store = $store;
		$this->_userId = $userId;
	}
	
	/**
	 * @see IPermissionService::CanAccessResource()
	 */
	public function CanAccessResource(IResource $resource)
	{
		if ($this->_allowedResourceIds == null)
		{
			$this->_allowedResourceIds = $this->_store->GetPermittedResources($this->_userId);
		}
		
		return in_array($resource->GetResourceId(), $this->_allowedResourceIds);
	}
}

interface IPermissionServiceFactory
{
	/**
	 * @param int $userId
	 * @return IPermissionService
	 */
	function GetPermissionService($userId);
}

class PermissionServiceFactory implements IPermissionServiceFactory
{
	/**
	 * @see IPermissionServiceFactory::GetPermissionService()
	 */
	public function GetPermissionService($userId)
	{
		// TODO: Make this pluggable
		$resourcePermissionStore = new ResourcePermissionStore(new ScheduleUserRepository());
		return new PermissionService($resourcePermissionStore, $userId);
	}
}
?>
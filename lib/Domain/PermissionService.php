<?php
interface IPermissionService
{
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
	
	public function __construct(IResourcePermissionStore $store, $userId)
	{
		$this->_store = $store;
		$this->_userId = $userId;
	}
	
	public function CanAccessResource(IResource $resource)
	{
		$allowedResourceIds = $this->_store->GetPermittedResources($userId);
		
		return in_array($resource->GetResourceId(), $allowedResourceIds);
	}
}

class ResourcePermissionStore implements IResourcePermissionStore
{
	public function GetPermittedResources($userId)
	{}
}

interface IResourcePermissionStore
{
	/**
	 * @param $userId int
	 * @return array[]int
	 */
	function GetPermittedResources($userId);
}
?>
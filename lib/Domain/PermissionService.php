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
	
	private $_allowedResourceIds;
	
	public function __construct(IResourcePermissionStore $store, $userId)
	{
		$this->_store = $store;
		$this->_userId = $userId;
	}
	
	public function CanAccessResource(IResource $resource)
	{
		if ($this->_allowedResourceIds == null)
		{
			$this->_allowedResourceIds = $this->_store->GetPermittedResources($this->_userId);
		}
		
		return in_array($resource->GetResourceId(), $this->_allowedResourceIds);
	}
}
?>
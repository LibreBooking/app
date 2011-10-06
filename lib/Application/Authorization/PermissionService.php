<?php
interface IPermissionService
{
	/**
	 * @param IResource $resource
	 * @param $user UserSession
	 * @return bool
	 */
	public function CanAccessResource(IResource $resource, UserSession $user);
}

class PermissionService implements IPermissionService
{
	/**
	 * @var IResourcePermissionStore
	 */
	private $_store;
	
	private $_allowedResourceIds;
	
	/**
	 * @param IResourcePermissionStore $store
	 */
	public function __construct(IResourcePermissionStore $store)
	{
		$this->_store = $store;
	}

	/**
	 * @param IResource $resource
	 * @param $user UserSession
	 * @return bool
	 */
	public function CanAccessResource(IResource $resource, UserSession $user)
	{
		if ($this->_allowedResourceIds == null)
		{
			$this->_allowedResourceIds = $this->_store->GetPermittedResources($user->UserId);
		}
		
		return in_array($resource->GetResourceId(), $this->_allowedResourceIds);
	}
}

?>
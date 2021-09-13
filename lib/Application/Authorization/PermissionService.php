<?php

interface IPermissionService
{
    /**
     * @param IPermissibleResource $resource
     * @param UserSession $user
     * @return bool
     */
    public function CanAccessResource(IPermissibleResource $resource, UserSession $user);

    /**
     * @param IPermissibleResource $resource
     * @param UserSession $user
     * @return bool
     */
    public function CanBookResource(IPermissibleResource $resource, UserSession $user);

    /**
     * @param IPermissibleResource $resource
     * @param UserSession $user
     * @return bool
     */
    public function CanViewResource(IPermissibleResource $resource, UserSession $user);
}

class PermissionService implements IPermissionService
{
    /**
     * @var IResourcePermissionStore
     */
    private $_store;

    private $_allowedResourceIds;

    private $_bookableResourceIds;

    private $_viewOnlyResourceIds;


    /**
     * @param IResourcePermissionStore $store
     */
    public function __construct(IResourcePermissionStore $store)
    {
        $this->_store = $store;
    }

    /**
     * @param IPermissibleResource $resource
     * @param UserSession $user
     * @return bool
     */
    public function CanAccessResource(IPermissibleResource $resource, UserSession $user)
    {
        if ($user->IsAdmin) {
            return true;
        }

        if ($this->_allowedResourceIds == null) {
            $this->_allowedResourceIds = $this->_store->GetAllResources($user->UserId);
        }

        return in_array($resource->GetResourceId(), $this->_allowedResourceIds);
    }

    /**
     * @param IPermissibleResource $resource
     * @param UserSession $user
     * @return bool
     */
    public function CanBookResource(IPermissibleResource $resource, UserSession $user)
    {
        if ($user->IsAdmin) {
            return true;
        }

        if ($this->_bookableResourceIds == null) {
            $this->_bookableResourceIds = $this->_store->GetBookableResources($user->UserId);
        }

        return in_array($resource->GetResourceId(), $this->_bookableResourceIds);
    }

    /**
     * @param IPermissibleResource $resource
     * @param UserSession $user
     * @return bool
     */
    public function CanViewResource(IPermissibleResource $resource, UserSession $user)
    {
        if ($user->IsAdmin) {
            return true;
        }

        if ($this->_viewOnlyResourceIds == null) {
            $this->_viewOnlyResourceIds = $this->_store->GetViewOnlyResources($user->UserId);
        }

        return in_array($resource->GetResourceId(), $this->_viewOnlyResourceIds);
    }
}

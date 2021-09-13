<?php

class ResourcePermissionFilter implements IResourceFilter
{
    /**
     * @var IPermissionService $permissionService
     */
    private $permissionService;

    /**
     * @var UserSession $user
     */
    private $user;

    public function __construct(IPermissionService $permissionService, UserSession $user)
    {
        $this->permissionService = $permissionService;
        $this->user = $user;
    }

    public function ShouldInclude($resource)
    {
        return $this->permissionService->CanAccessResource($resource, $this->user);
    }

    public function CanBook($resource)
    {
        return $this->permissionService->CanBookResource($resource, $this->user);
    }
}

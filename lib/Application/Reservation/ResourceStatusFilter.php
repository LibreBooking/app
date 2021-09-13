<?php

class ResourceStatusFilter implements IResourceFilter
{
    /**
     * @var IUserRepository
     */
    private $userRepository;

    /**
     * @var UserSession
     */
    private $user;

    public function __construct(IUserRepository $userRepository, UserSession $user)
    {
        $this->user = $user;
        $this->userRepository = $userRepository;
    }

    /**
     * @param IResource $resource
     * @return bool
     */
    public function ShouldInclude($resource)
    {
        if ($resource->GetStatusId() != ResourceStatus::AVAILABLE) {
            $user = $this->userRepository->LoadById($this->user->UserId);
            return $user->IsResourceAdminFor($resource);
        }

        return true;
    }
}

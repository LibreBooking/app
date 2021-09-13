<?php

require_once(ROOT_DIR . 'Domain/Access/namespace.php');

class GroupAdminUserRepository extends UserRepository
{
    /**
     * @var IGroupViewRepository
     */
    private $groupRepository;

    /**
     * @var UserSession
     */
    private $userSession;

    public function __construct(IGroupViewRepository $groupRepository, UserSession $userSession)
    {
        $this->groupRepository = $groupRepository;
        $this->userSession = $userSession;
        parent::__construct();
    }

    public function GetList($pageNumber, $pageSize, $sortField = null, $sortDirection = null, $filter = null, $accountStatus = AccountStatus::ALL)
    {
        if (empty($accountStatus)) {
            $accountStatus = AccountStatus::ALL;
        }

        $user = parent::LoadById($this->userSession->UserId);

        $groupIds = [];

        foreach ($user->GetAdminGroups() as $group) {
            $groupIds[] = $group->GroupId;
        }

        return $this->groupRepository->GetUsersInGroup($groupIds, $pageNumber, $pageSize, $filter, $accountStatus);
    }

    /**
     * @param int $userId
     * @return User|void
     */
    public function LoadById($userId)
    {
        $user = parent::LoadById($userId);
        $me = parent::LoadById($this->userSession->UserId);

        if ($userId == $this->userSession->UserId || $me->IsAdminFor($user)) {
            return $user;
        }

        return User::Null();
    }
}

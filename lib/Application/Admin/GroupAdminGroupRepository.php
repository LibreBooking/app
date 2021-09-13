<?php

require_once(ROOT_DIR . 'Domain/Access/namespace.php');

class GroupAdminGroupRepository extends GroupRepository
{
    /**
     * @var IUserRepository
     */
    private $userRepository;

    /**
     * @var UserSession
     */
    private $userSession;

    public function __construct(IUserRepository $userRepository, UserSession $userSession)
    {
        $this->userRepository = $userRepository;
        $this->userSession = $userSession;
        parent::__construct();
    }

    public function GetList($pageNumber = null, $pageSize = null, $sortField = null, $sortDirection = null, $filter = null)
    {
        $user = $this->userRepository->LoadById($this->userSession->UserId);

        $groupIds = [];
        $groups = $user->GetAdminGroups();
        foreach ($groups as $group) {
            $groupIds[] = $group->GroupId;
        }
        $and = new SqlFilterIn(new SqlFilterColumn(TableNames::GROUPS_ALIAS, ColumnNames::GROUP_ID), $groupIds);
        if ($filter == null) {
            $filter = $and;
        } else {
            $filter->_And($and);
        }
        return parent::GetList($pageNumber, $pageSize, $sortField, $sortDirection, $filter);
    }

    public function LoadById($groupId)
    {
        $user = $this->userRepository->LoadById($this->userSession->UserId);

        if ($user->IsGroupAdminFor($groupId)) {
            return parent::LoadById($groupId);
        }

        return Group::Null();
    }

    public function Add(Group $group)
    {
        $id = parent::Add($group);
        $recalledGroup = parent::LoadById($id);

        $groups = $this->userRepository->LoadGroups($this->userSession->UserId);
        foreach ($groups as $userGroup) {
            if ($userGroup->IsGroupAdmin) {
                $recalledGroup->ChangeAdmin($userGroup->GroupId);
                break;
            }
        }

        parent::Update($recalledGroup);

        return $id;
    }
}

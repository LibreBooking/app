<?php
/**
 * Copyright 2011-2019 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');
require_once(ROOT_DIR . 'Pages/Admin/ManageGroupsPage.php');

class ManageGroupsActions
{
    const Activate = 'activate';
    const Deactivate = 'deactivate';
    const Password = 'password';
    const Permissions = 'permissions';
    const RemoveUser = 'removeUser';
    const AddUser = 'addUser';
    const AddGroup = 'addGroup';
    const UpdateGroup = 'updateGroup';
    const DeleteGroup = 'deleteGroup';
    const Roles = 'roles';
    const GroupAdmin = 'groupAdmin';
    const AdminGroups = 'adminGroups';
    const ResourceGroups = 'resourceGroups';
    const ScheduleGroups = 'scheduleGroups';
}

class ManageGroupsPresenter extends ActionPresenter
{
    /**
     * @var IManageGroupsPage
     */
    private $page;

    /**
     * @var GroupRepository
     */
    private $groupRepository;

    /**
     * @var ResourceRepository
     */
    private $resourceRepository;
    /**
     * @var ScheduleRepository
     */
    private $scheduleRepository;

    /**
     * @param IManageGroupsPage $page
     * @param GroupRepository $groupRepository
     * @param ResourceRepository $resourceRepository
     * @param ScheduleRepository $scheduleRepository
     */
    public function __construct(IManageGroupsPage $page,
                                GroupRepository $groupRepository,
                                ResourceRepository $resourceRepository,
                                ScheduleRepository $scheduleRepository)
    {
        parent::__construct($page);

        $this->page = $page;
        $this->groupRepository = $groupRepository;
        $this->resourceRepository = $resourceRepository;
        $this->scheduleRepository = $scheduleRepository;

        $this->AddAction(ManageGroupsActions::AddUser, 'AddUser');
        $this->AddAction(ManageGroupsActions::RemoveUser, 'RemoveUser');
        $this->AddAction(ManageGroupsActions::Permissions, 'ChangePermissions');
        $this->AddAction(ManageGroupsActions::AddGroup, 'AddGroup');
        $this->AddAction(ManageGroupsActions::UpdateGroup, 'UpdateGroup');
        $this->AddAction(ManageGroupsActions::DeleteGroup, 'DeleteGroup');
        $this->AddAction(ManageGroupsActions::Roles, 'ChangeRoles');
        $this->AddAction(ManageGroupsActions::GroupAdmin, 'ChangeGroupAdmin');
        $this->AddAction(ManageGroupsActions::AdminGroups, 'ChangeAdminGroups');
        $this->AddAction(ManageGroupsActions::ResourceGroups, 'ChangeResourceGroups');
        $this->AddAction(ManageGroupsActions::ScheduleGroups, 'ChangeScheduleGroups');
    }

    public function PageLoad()
    {
        if ($this->page->GetGroupId() != null) {
            $groupList = $this->groupRepository->GetList(1, 1, null, null, new SqlFilterEquals(new SqlFilterColumn(TableNames::GROUPS_ALIAS, ColumnNames::GROUP_ID), $this->page->GetGroupId()));
        }
        else {
            $groupList = $this->groupRepository->GetList($this->page->GetPageNumber(), $this->page->GetPageSize(), $this->page->GetSortField(), $this->page->GetSortDirection());
        }

        $this->page->BindGroups($groupList->Results());
        $this->page->BindPageInfo($groupList->PageInfo());

        $this->page->BindResources($this->resourceRepository->GetResourceList());
        $this->page->BindSchedules($this->scheduleRepository->GetAll());

        $this->page->BindRoles(array(
            new RoleDto(1, 'Group Admin', RoleLevel::GROUP_ADMIN),
            new RoleDto(2, 'Application Admin', RoleLevel::APPLICATION_ADMIN),
            new RoleDto(3, 'Resource Admin', RoleLevel::RESOURCE_ADMIN),
            new RoleDto(4, 'Schedule Admin', RoleLevel::SCHEDULE_ADMIN)
        ));
        $this->page->BindAdminGroups($this->groupRepository->GetGroupsByRole(RoleLevel::GROUP_ADMIN));
    }

    public function ChangePermissions()
    {
        $group = $this->groupRepository->LoadById($this->page->GetGroupId());
        $resources = array();
        $allowed = array();
        $view = array();

        if (is_array($this->page->GetAllowedResourceIds())) {
            $resources = $this->page->GetAllowedResourceIds();
        }

        foreach ($resources as $resource) {
            $split = explode('_', $resource);
            $resourceId = $split[0];
            $permissionType = $split[1];

            if ($permissionType === ResourcePermissionType::Full . '') {
                $allowed[] = $resourceId;
            }
            else {
                if ($permissionType === ResourcePermissionType::View . '') {
                    $view[] = $resourceId;
                }
            }
        }

        $group->ChangeViewPermissions($view);
        $group->ChangeAllowedPermissions($allowed);
        $this->groupRepository->Update($group);
    }

    public function ChangeRoles()
    {
        $groupId = $this->page->GetGroupId();
        Log::Debug("Changing roles for groupId: %s", $groupId);

        $group = $this->groupRepository->LoadById($groupId);
        $roles = array();

        if (is_array($this->page->GetRoleIds())) {
            $roles = $this->page->GetRoleIds();
        }
        $group->ChangeRoles($roles);
        $this->groupRepository->Update($group);
    }

    public function ProcessDataRequest()
    {
        $response = '';
        $request = $this->page->GetDataRequest();
        switch ($request) {
            case 'groupMembers' :
                $users = $this->groupRepository->GetUsersInGroup($this->page->GetGroupId());
                $response = new UserGroupResults($users->Results(), $users->PageInfo()->Total);
                break;
            case 'permissions' :
                $response = $this->GetGroupResourcePermissions();
                break;
            case 'roles' :
                $response = $this->GetGroupRoles();
                break;
            case ManageGroupsActions::AdminGroups :
                $response = $this->GetAdminGroups();
                break;
            case ManageGroupsActions::ResourceGroups :
                $response = $this->GetResourceAdminGroups();
                break;
            case ManageGroupsActions::ScheduleGroups :
                $response = $this->GetScheduleAdminGroups();
                break;
        }

        $this->page->SetJsonResponse($response);
    }

    /**
     * @return int[] all resource ids the user has permission to
     */
    public function GetGroupResourcePermissions()
    {
        $group = $this->groupRepository->LoadById($this->page->GetGroupId());
        return array('full' => $group->AllowedResourceIds(), 'view' => $group->AllowedViewResourceIds());
    }

    public function AddUser()
    {
        $groupId = $this->page->GetGroupId();
        $userId = $this->page->GetUserId();

        Log::Debug("Adding userId: %s to groupId: %s", $userId, $groupId);

        $group = $this->groupRepository->LoadById($groupId);
        $group->AddUser($userId);
        $this->groupRepository->Update($group);
    }

    public function RemoveUser()
    {
        $groupId = $this->page->GetGroupId();
        $userId = $this->page->GetUserId();

        Log::Debug('Removing userId: %s from groupId: %s', $userId, $groupId);

        $group = $this->groupRepository->LoadById($groupId);
        $group->RemoveUser($userId);
        $this->groupRepository->Update($group);
    }

    public function ChangeUsers()
    {
        $groupId = $this->page->GetGroupId();
        $userIds = $this->page->GetUserIds();

        Log::Debug('Changing group users: groupId: %s', $groupId);

        $group = $this->groupRepository->LoadById($groupId);
        $group->ChangeUsers($userIds);
        $this->groupRepository->Update($group);
    }

    public function AddGroup()
    {
        $groupName = $this->page->GetGroupName();
        $isDefault = $this->page->AutomaticallyAddToGroup();
        Log::Debug('Adding new group with name: %s, isdefault: %s', $groupName, $isDefault);

        $group = new Group(0, $groupName, $isDefault);
        return $this->groupRepository->Add($group);
    }

    public function UpdateGroup()
    {
        $groupId = $this->page->GetGroupId();
        $groupName = $this->page->GetGroupName();
        $isDefault = $this->page->AutomaticallyAddToGroup();
        Log::Debug('Renaming group id: %s to: %s', $groupId, $groupName);

        $group = $this->groupRepository->LoadById($groupId);
        $group->Rename($groupName);
        $group->ChangeDefault($isDefault);

        $this->groupRepository->Update($group);
    }

    public function DeleteGroup()
    {
        $groupId = $this->page->GetGroupId();

        Log::Debug("Deleting groupId: %s", $groupId);

        $group = $this->groupRepository->LoadById($groupId);
        $this->groupRepository->Remove($group);
    }

    public function ChangeGroupAdmin()
    {
        $groupId = $this->page->GetGroupId();
        $adminGroupId = $this->page->GetAdminGroupId();

        Log::Debug("Changing admin for groupId: %s to %s", $groupId, $adminGroupId);

        $group = $this->groupRepository->LoadById($groupId);

        $group->ChangeAdmin($adminGroupId);

        $this->groupRepository->Update($group);
    }

    /**
     * @return array|int[]
     */
    public function GetGroupRoles()
    {
        $groupId = $this->page->GetGroupId();
        $group = $this->groupRepository->LoadById($groupId);

        $ids = $group->RoleIds();

        return $ids;
    }

    public function GetAdminGroups()
    {
        $groupId = $this->page->GetGroupId();

        $result = $this->groupRepository->GetList(null, null, null, null, new SqlFilterEquals(new SqlFilterColumn(TableNames::GROUPS_ALIAS, ColumnNames::GROUP_ADMIN_GROUP_ID), $groupId));
        $ids = array();
        /** @var GroupItemView $group */
        foreach ($result->Results() as $group)
        {
            $ids[] = $group->Id();
        }

        return $ids;
    }

    public function GetResourceAdminGroups()
    {
        $groupId = $this->page->GetGroupId();

        $result = $this->resourceRepository->GetList(null, null, null, null, new SqlFilterEquals(new SqlFilterColumn(TableNames::RESOURCES_ALIAS, ColumnNames::RESOURCE_ADMIN_GROUP_ID), $groupId));
        $ids = array();
        /** @var BookableResource $resource */
        foreach ($result->Results() as $resource)
        {
            $ids[] = $resource->GetId();
        }

        return $ids;
    }

    public function GetScheduleAdminGroups()
    {
        $groupId = $this->page->GetGroupId();

        $result = $this->scheduleRepository->GetList(null, null, null, null, new SqlFilterEquals(new SqlFilterColumn(TableNames::SCHEDULES_ALIAS, ColumnNames::SCHEDULE_ADMIN_GROUP_ID), $groupId));
        $ids = array();
        /** @var Schedule $schedule */
        foreach ($result->Results() as $schedule)
        {
            $ids[] = $schedule->GetId();
        }

        return $ids;
    }

    public function ChangeAdminGroups()
    {
        $groupId = $this->page->GetGroupId();
        $groupIds = $this->page->GetGroupAdminIds();
        Log::Debug('Changing group admins. Setting group admin id to %s for %s', $groupId, var_export($groupIds, true));

        foreach ($groupIds as $id)
        {
            $group = $this->groupRepository->LoadById($id);
            $group->ChangeAdmin($groupId);
            $this->groupRepository->Update($group);
        }
    }

    public function ChangeResourceGroups()
    {
        $groupId = $this->page->GetGroupId();
        $resourceIds = $this->page->GetResourceAdminIds();
        Log::Debug('Changing resource admins. Setting group admin id to %s for %s', $groupId, var_export($resourceIds, true));

        foreach ($resourceIds as $id)
        {
            $resource = $this->resourceRepository->LoadById($id);
            $resource->SetAdminGroupId($groupId);
            $this->resourceRepository->Update($resource);
        }
    }

    public function ChangeScheduleGroups()
    {
        $groupId = $this->page->GetGroupId();
        $scheduleIds = $this->page->GetScheduleAdminIds();
        Log::Debug('Changing schedule admins. Setting group admin id to %s for %s', $groupId, var_export($scheduleIds, true));

        foreach ($scheduleIds as $id)
        {
            $schedule = $this->scheduleRepository->LoadById($id);
            $schedule->SetAdminGroupId($groupId);
            $this->scheduleRepository->Update($schedule);
        }
    }
}

class UserGroupResults
{
    /**
     * @param UserItemView[] $users
     * @param int $totalUsers
     */
    public function __construct($users, $totalUsers)
    {
        foreach ($users as $user) {
            $this->Users[] = new AutocompleteUser($user->Id, $user->First, $user->Last, $user->Email, $user->Username);
        }
        $this->Total = $totalUsers;
    }

    /**
     * @var int
     */
    public $Total;

    /**
     * @var AutocompleteUser[]
     */
    public $Users;
}


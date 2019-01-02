<?php

/**
 * Copyright 2018-2019 Nick Korbel
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

require_once(ROOT_DIR . 'Presenters/Admin/ManageGroupsPresenter.php');

interface IGroupSaveController
{
    /**
     * @param GroupRequest $request
     * @param WebServiceUserSession $session
     * @return GroupControllerResult
     */
    public function Create($request, $session);

    /**
     * @param int $groupId
     * @param GroupRequest $request
     * @param WebServiceUserSession $session
     * @return GroupControllerResult
     */
    public function Update($groupId, $request, $session);

    /**
     * @param int $groupId
     * @param WebServiceUserSession $session
     * @return GroupControllerResult
     */
    public function Delete($groupId, $session);

    /**
     * @param int $groupId
     * @param GroupRolesRequest $request
     * @param WebServiceUserSession $session
     * @return GroupControllerResult
     */
    public function ChangeRoles($groupId, $request, $session);

    /**
     * @param int $groupId
     * @param GroupPermissionsRequest $request
     * @param WebServiceUserSession $session
     * @return GroupControllerResult
     */
    public function ChangePermissions($groupId, $request, $session);

    /**
     * @param int $groupId
     * @param GroupUsersRequest $request
     * @param WebServiceUserSession $session
     * @return GroupControllerResult
     */
    public function ChangeUsers($groupId, $request, $session);
}

class GroupControllerResult
{
    private $groupId;
    private $errors = array();

    public function __construct($groupId, $errors = array())
    {
        $this->groupId = $groupId;
        $this->errors = $errors;
    }

    /**
     * @return bool
     */
    public function WasSuccessful()
    {
        return !empty($this->groupId) && empty($this->errors);
    }

    /**
     * @return int
     */
    public function GroupId()
    {
        return $this->groupId;
    }

    /**
     * @return string[]
     */
    public function Errors()
    {
        return $this->errors;
    }
}

class GroupSaveController implements IGroupSaveController
{
    /**
     * @var GroupRepository
     */
    private $groupRepository;

    /**
     * @var ResourceRepository
     */
    private $resourceRepository;
    /**
     * @var IScheduleRepository
     */
    private $scheduleRepository;

    public function __construct(GroupRepository $groupRepository, ResourceRepository $resourceRepository, IScheduleRepository $scheduleRepository)
    {
        $this->groupRepository = $groupRepository;
        $this->resourceRepository = $resourceRepository;
        $this->scheduleRepository = $scheduleRepository;
    }

    /**
     * @param GroupRequest $request
     * @param WebServiceUserSession $session
     * @return GroupControllerResult
     */
    public function Create($request, $session)
    {
        $errors = $this->ValidateRequest($request);

        if (!empty($errors)) {
            return new GroupControllerResult(null, $errors);
        }

        $presenter = $this->GetPresenter(new CreateGroupFacade($request));

        $id = $presenter->AddGroup();

        return new GroupControllerResult($id, null);
    }

    /**
     * @param int $groupId
     * @param GroupRequest $request
     * @param WebServiceUserSession $session
     * @return GroupControllerResult
     */
    public function Update($groupId, $request, $session)
    {
        $errors = $this->ValidateRequest($request);

        if (!empty($errors)) {
            return new GroupControllerResult(null, $errors);
        }

        $presenter = $this->GetPresenter(new CreateGroupFacade($request, $groupId));

        $id = $presenter->AddGroup();

        return new GroupControllerResult($id, null);
    }

    /**
     * @param int $groupId
     * @param WebServiceUserSession $session
     * @return GroupControllerResult
     */
    public function Delete($groupId, $session)
    {
        $errors = empty($groupId) ? array('groupId is required') : array();
        if (!empty($errors)) {
            return new GroupControllerResult(null, $errors);
        }

        $presenter = $this->GetPresenter(new CreateGroupFacade(null, $groupId));
        $presenter->DeleteGroup();

        return new GroupControllerResult($groupId);
    }

    /**
     * @param GroupRequest $request
     * @return array|string[]
     */
    private function ValidateRequest($request)
    {
        $errors = array();

        if (empty($request->name)) {
            $errors[] = 'name is required';
        }

        return $errors;
    }

    private function GetPresenter($page)
    {
        return new ManageGroupsPresenter($page, $this->groupRepository, $this->resourceRepository, $this->scheduleRepository);
    }

    /**
     * @param int $groupId
     * @param GroupRolesRequest $request
     * @param WebServiceUserSession $session
     * @return GroupControllerResult
     */
    public function ChangeRoles($groupId, $request, $session)
    {
        $presenter = $this->GetPresenter(new UpdateGroupRolesFacade($request, $groupId));

        $presenter->ChangeRoles();

        return new GroupControllerResult($groupId, null);
    }

    /**
     * @param int $groupId
     * @param GroupPermissionsRequest $request
     * @param WebServiceUserSession $session
     * @return GroupControllerResult
     */
    public function ChangePermissions($groupId, $request, $session)
    {
        $presenter = $this->GetPresenter(new UpdateGroupPermissionsFacade($request, $groupId));

        $presenter->ChangePermissions();

        return new GroupControllerResult($groupId, null);
    }

    /**
     * @param int $groupId
     * @param GroupUsersRequest $request
     * @param WebServiceUserSession $session
     * @return GroupControllerResult
     */
    public function ChangeUsers($groupId, $request, $session)
    {
        $presenter = $this->GetPresenter(new UpdateGroupUsersFacade($request, $groupId));

        $presenter->ChangeUsers();

        return new GroupControllerResult($groupId, null);
    }
}

abstract class GroupControllerPageFacade implements IManageGroupsPage
{
    public function TakingAction()
    {
    }

    public function GetAction()
    {
    }

    public function RequestingData()
    {
    }

    public function GetDataRequest()
    {
    }

    public function PageLoad()
    {
    }

    public function Redirect($url)
    {
    }

    public function RedirectToError($errorMessageId = ErrorMessages::UNKNOWN_ERROR, $lastPage = '')
    {
    }

    public function IsPostBack()
    {
    }

    public function IsValid()
    {
    }

    public function GetLastPage($defaultPage = '')
    {
    }

    public function RegisterValidator($validatorId, $validator)
    {
    }

    public function EnforceCSRFCheck()
    {
    }

    public function GetSortField()
    {
    }

    public function GetSortDirection()
    {
    }

    public function GetGroupId()
    {
    }

    public function BindGroups($groups)
    {
    }

    public function BindPageInfo(PageInfo $pageInfo)
    {
    }

    public function GetPageNumber()
    {
    }

    public function GetPageSize()
    {
    }

    public function SetJsonResponse($response)
    {
    }

    public function GetUserId()
    {
    }

    public function BindResources($resources)
    {
    }

    public function BindRoles($roles)
    {
    }

    public function GetAllowedResourceIds()
    {
    }

    public function GetGroupName()
    {
    }

    public function GetRoleIds()
    {
    }

    public function BindAdminGroups($adminGroups)
    {
    }

    public function GetAdminGroupId()
    {
    }

    public function AutomaticallyAddToGroup()
    {
    }

    public function GetUserIds()
    {
    }
}

class CreateGroupFacade extends GroupControllerPageFacade
{
    /**
     * @var GroupRequest
     */
    private $request;
    private $id;

    /**
     * @param GroupRequest $request
     * @param int|null $id
     */
    public function __construct($request, $id = null)
    {
        $this->request = $request;
        $this->id = $id;
    }

    public function GetGroupId()
    {
        return $this->id;
    }

    public function GetGroupName()
    {
        return $this->request->name;
    }

    public function AutomaticallyAddToGroup()
    {
        return $this->request->isDefault;
    }

    /**
     * @param $schedules Schedule[]
     */
    public function BindSchedules($schedules)
    {
        // TODO: Implement BindSchedules() method.
    }

    /**
     * @return int[]
     */
    public function GetGroupAdminIds()
    {
        // TODO: Implement GetGroupAdminIds() method.
    }

    /**
     * @return int[]
     */
    public function GetResourceAdminIds()
    {
        // TODO: Implement GetResourceAdminIds() method.
    }

    /**
     * @return int[]
     */
    public function GetScheduleAdminIds()
    {
        // TODO: Implement GetScheduleAdminIds() method.
    }
}

class UpdateGroupRolesFacade extends GroupControllerPageFacade
{
    /**
     * @var GroupRolesRequest
     */
    private $request;
    private $id;

    /**
     * @param GroupRolesRequest $request
     * @param int|null $id
     */
    public function __construct($request, $id = null)
    {
        $this->request = $request;
        $this->id = $id;
    }

    public function GetGroupId()
    {
        return $this->id;
    }

    public function GetRoleIds()
    {
        $roles = $this->request->roleIds;

        return empty($roles) ? [] : $roles;
    }

    /**
     * @param $schedules Schedule[]
     */
    public function BindSchedules($schedules)
    {
        // TODO: Implement BindSchedules() method.
    }

    /**
     * @return int[]
     */
    public function GetGroupAdminIds()
    {
        // TODO: Implement GetGroupAdminIds() method.
    }

    /**
     * @return int[]
     */
    public function GetResourceAdminIds()
    {
        // TODO: Implement GetResourceAdminIds() method.
    }

    /**
     * @return int[]
     */
    public function GetScheduleAdminIds()
    {
        // TODO: Implement GetScheduleAdminIds() method.
    }
}

class UpdateGroupPermissionsFacade extends GroupControllerPageFacade
{
    /**
     * @var GroupPermissionsRequest
     */
    private $request;
    private $id;

    /**
     * @param GroupPermissionsRequest $request
     * @param int|null $id
     */
    public function __construct($request, $id = null)
    {
        $this->request = $request;
        $this->id = $id;
    }

    public function GetGroupId()
    {
        return $this->id;
    }

    public function GetAllowedResourceIds()
    {
        $ids = array();
        $full = $this->request->permissions;
        $view = $this->request->viewPermissions;

        if (!empty($full)) {
            foreach ($full as $id) {
                $ids[] = $id . '_' . ResourcePermissionType::Full;
            }
        }

        if (!empty($view)) {
            foreach ($view as $id) {
                $ids[] = $id . '_' . ResourcePermissionType::View;
            }
        }

        return $ids;
    }

    /**
     * @param $schedules Schedule[]
     */
    public function BindSchedules($schedules)
    {
        // TODO: Implement BindSchedules() method.
    }

    /**
     * @return int[]
     */
    public function GetGroupAdminIds()
    {
        // TODO: Implement GetGroupAdminIds() method.
    }

    /**
     * @return int[]
     */
    public function GetResourceAdminIds()
    {
        // TODO: Implement GetResourceAdminIds() method.
    }

    /**
     * @return int[]
     */
    public function GetScheduleAdminIds()
    {
        // TODO: Implement GetScheduleAdminIds() method.
    }
}

class UpdateGroupUsersFacade extends GroupControllerPageFacade
{
    /**
     * @var GroupUsersRequest
     */
    private $request;
    private $id;

    /**
     * @param GroupUsersRequest $request
     * @param int|null $id
     */
    public function __construct($request, $id = null)
    {
        $this->request = $request;
        $this->id = $id;
    }

    public function GetGroupId()
    {
        return $this->id;
    }

    public function GetUserIds()
    {
        $ids = $this->request->userIds;

        return empty($ids) ? [] : $ids;
    }

    /**
     * @param $schedules Schedule[]
     */
    public function BindSchedules($schedules)
    {
        // TODO: Implement BindSchedules() method.
    }

    /**
     * @return int[]
     */
    public function GetGroupAdminIds()
    {
        // TODO: Implement GetGroupAdminIds() method.
    }

    /**
     * @return int[]
     */
    public function GetResourceAdminIds()
    {
        // TODO: Implement GetResourceAdminIds() method.
    }

    /**
     * @return int[]
     */
    public function GetScheduleAdminIds()
    {
        // TODO: Implement GetScheduleAdminIds() method.
    }
}
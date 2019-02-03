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

require_once(ROOT_DIR . 'Domain/Values/ResourcePermissionType.php');

interface IScheduleUserRepository
{
    /**
     * @param $userId
     * @return IScheduleUser
     */
    function GetUser($userId);
}

class ScheduleUserRepository implements IScheduleUserRepository
{
    public function GetUser($userId)
    {
        $userPermissions = $this->GetUserPermissions($userId);
        return new ScheduleUser($userId,
            $userPermissions['full'],
            $userPermissions['view'],
            $this->GetGroupPermissions($userId),
            $this->GetGroupAdminPermissions($userId));
    }

    private function GetUserPermissions($userId)
    {
        $userCommand = new GetUserPermissionsCommand($userId);

        $reader = ServiceLocator::GetDatabase()->Query($userCommand);
        $resources['full'] = array();
        $resources['view'] = array();

        while ($row = $reader->GetRow()) {
            if ($row[ColumnNames::PERMISSION_TYPE] == ResourcePermissionType::Full) {
                $resources['full'][] = new ScheduleResource($row[ColumnNames::RESOURCE_ID], $row[ColumnNames::RESOURCE_NAME]);

            }
            else {
                $resources['view'][] = new ScheduleResource($row[ColumnNames::RESOURCE_ID], $row[ColumnNames::RESOURCE_NAME]);
            }
        }

		$reader->Free();

        return $resources;
    }

    /**
     * @param $userId
     * @return array|ScheduleGroup[]
     */
    private function GetGroupPermissions($userId)
    {
        $groupCommand = new SelectUserGroupPermissions($userId);

        $reader = ServiceLocator::GetDatabase()->Query($groupCommand);
        $groupList = array();

        while ($row = $reader->GetRow()) {
            $group_id = $row[ColumnNames::GROUP_ID];
            $resourceId = $row[ColumnNames::RESOURCE_ID];
            $resourceName = $row[ColumnNames::RESOURCE_NAME];
            $permissionType = $row[ColumnNames::PERMISSION_TYPE];

            $groupList[$group_id][] = array($resourceId, $resourceName, $permissionType);
        }

		$reader->Free();

        $groups = array();
        foreach ($groupList as $group_id => $resourceList) {
            $resources = array();
            $viewOnly = array();
            foreach ($resourceList as $resourceItem) {
                $permissionType = $resourceItem[2];
                if ($permissionType == ResourcePermissionType::View) {
                    $viewOnly[] = new ScheduleResource($resourceItem[0], $resourceItem[1]);
                }
                else {
                    $resources[] = new ScheduleResource($resourceItem[0], $resourceItem[1]);
                }
            }
            $groups[] = new ScheduleGroup($group_id, $resources, $viewOnly);
        }

        return $groups;
    }

    private function GetGroupAdminPermissions($userId)
    {
        $userCommand = new SelectUserGroupResourceAdminPermissions($userId);

        $reader = ServiceLocator::GetDatabase()->Query($userCommand);
        $resources = array();

        while ($row = $reader->GetRow()) {
            $resources[] = new ScheduleResource($row[ColumnNames::RESOURCE_ID], $row[ColumnNames::RESOURCE_NAME]);
        }

		$reader->Free();

        return $resources;
    }
}

interface IScheduleUser
{
    /**
     * @return int
     */
    public function Id();

    /**
     * The resources that the user or any of their groups has permission to
     * @return array|ScheduleResource[]
     */
    public function GetAllResources();

    /**
     * The resources that the user or any of their groups has bookable permission to
     * @return array|ScheduleResource[]
     */
    public function GetBookableResources();

    /**
     * The resources that the user or any of their groups has view permission to
     * @return array|ScheduleResource[]
     */
    public function GetViewOnlyResources();

    /**
     * The resources that the user or any of their groups has admin access to
     * @return array|ScheduleResource[]
     */
    public function GetAdminResources();
}

class ScheduleUser implements IScheduleUser
{
    private $_userId;
    private $_groupPermissions;
    private $_userPermissionsFull;
    private $_userPermissionView;
    private $_adminResources;

    /**
     * @param int $userId ;
     * @param array|ScheduleResource[] $userPermissionsFull
     * @param array|ScheduleResource[] $userPermissionsView
     * @param array|ScheduleGroup[] $groupPermissions
     * @param array|ScheduleResource[] $groupAdminPermissions
     */
    public function __construct($userId, $userPermissionsFull, $userPermissionsView, $groupPermissions, $groupAdminPermissions)
    {
        $this->_userId = $userId;
        $this->_userPermissionsFull = $userPermissionsFull;
        $this->_userPermissionView = $userPermissionsView;
        $this->_groupPermissions = $groupPermissions;
        $this->_adminResources = $groupAdminPermissions;
    }

    public function Id()
    {
        return $this->_userId;
    }

    private function GetGroupPermissions()
    {
        return $this->_groupPermissions;
    }

    private function GetUserPermissionsFull()
    {
        return $this->_userPermissionsFull;
    }

    private function GetUserPermissionsView()
    {
        return $this->_userPermissionView;
    }

    public function GetAdminResources()
    {
        return $this->_adminResources;
    }

    public function GetAllResources()
    {
        $resources = array();

        foreach ($this->GetUserPermissionsFull() as $resource) {
            $resources[] = $resource;
        }

        foreach ($this->GetUserPermissionsView() as $resource) {
            $resources[] = $resource;
        }

        foreach ($this->GetGroupPermissions() as $group) {
            foreach ($group->GetAllResources() as $resource) {
                $resources[] = $resource;
            }
        }

        foreach ($this->GetAdminResources() as $resource) {
            $resources[] = $resource;
        }

        return array_unique($resources);
    }

    public function GetBookableResources()
    {
        $resources = array();

        foreach ($this->GetUserPermissionsFull() as $resource) {
            $resources[] = $resource;
        }

        foreach ($this->GetGroupPermissions() as $group) {
            foreach ($group->GetBookableResources() as $resource) {
                $resources[] = $resource;
            }
        }

        foreach ($this->GetAdminResources() as $resource) {
            $resources[] = $resource;
        }

        return array_unique($resources);
    }

    public function GetViewOnlyResources()
    {
        $resources = array();

        foreach ($this->GetUserPermissionsView() as $resource) {
            $resources[] = $resource;
        }

        foreach ($this->GetGroupPermissions() as $group) {
            foreach ($group->GetViewOnlyResources() as $resource) {
                $resources[] = $resource;
            }
        }

        return array_unique($resources);
    }
}

class ScheduleGroup
{
    private $group_id;
    private $bookableResources;
    private $viewOnlyResources;
    private $allResources;

    /**
     * @param int $group_id
     * @param ScheduleResource[] $bookableResources
     * @param ScheduleResource[] $viewOnlyResources
     */
    public function __construct($group_id, $bookableResources, $viewOnlyResources)
    {
        $this->group_id = $group_id;
        $this->bookableResources = $bookableResources;
        $this->viewOnlyResources = $viewOnlyResources;
        $this->allResources = array_merge($bookableResources, $viewOnlyResources);
    }

    /**
     * @return int
     */
    public function Id()
    {
        return $this->group_id;
    }

    /**
     * @return array|ScheduleResource[]
     */
    public function GetAllResources()
    {
        return $this->allResources;
    }

    /**
     * @return array|ScheduleResource[]
     */
    public function GetBookableResources()
    {
        return $this->bookableResources;
    }

    /**
     * @return array|ScheduleResource[]
     */
    public function GetViewOnlyResources()
    {
        return $this->viewOnlyResources;
    }
}

class ScheduleResource
{
    private $_resourceId;
    private $_name;

    /**
     * @param int $resourceId
     * @param string $name
     */
    public function __construct($resourceId, $name)
    {
        $this->_resourceId = $resourceId;
        $this->_name = $name;
    }

    /**
     * @return int
     */
    public function Id()
    {
        return $this->_resourceId;
    }

    /**
     * @return string
     */
    public function Name()
    {
        return $this->_name;
    }

    public function __toString()
    {
        // needed for array_unique
        return (string)$this->_resourceId;
    }
}

class NullScheduleResource extends ScheduleResource
{
    public function __construct()
    {
        parent::__construct(0, null);
    }

    public function GetMinimumLength()
    {
        return null;
    }
}
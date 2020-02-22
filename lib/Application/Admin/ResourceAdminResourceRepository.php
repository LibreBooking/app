<?php
/**
Copyright 2012-2020 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Domain/Access/ResourceRepository.php');

class ResourceAdminResourceRepository extends ResourceRepository
{
    /**
     * @var IUserRepository
     */
    private $repo;

    /**
     * @var UserSession
     */
    private $user;

    public function __construct(IUserRepository $repo, UserSession $userSession)
    {
        $this->repo = $repo;
        $this->user = $userSession;
		parent::__construct();
    }

    /**
     * @return array|BookableResource[] array of all resources
     */
    public function GetResourceList()
    {
		$resources = parent::GetResourceList();

		return $this->GetFilteredResources($resources);
    }

	public function GetList($pageNumber, $pageSize, $sortField = null, $sortDirection = null, $filter = null)
	{
		if (!$this->user->IsAdmin)
		{
			$scheduleAdminGroupIds = array();
			$resourceAdminGroupIds = array();

			$groups = $this->repo->LoadGroups($this->user->UserId, array(RoleLevel::SCHEDULE_ADMIN, RoleLevel::RESOURCE_ADMIN));
			foreach ($groups as $group)
			{
				if ($group->IsResourceAdmin)
				{
					$resourceAdminGroupIds[] = $group->GroupId;
				}

				if ($group->IsScheduleAdmin)
				{
					$scheduleAdminGroupIds[] = $group->GroupId;
				}
			}

			if ($filter == null)
			{
				$filter = new SqlFilterNull();
			}

			$additionalFilter = new SqlFilterIn(new SqlFilterColumn(TableNames::SCHEDULES_ALIAS, ColumnNames::SCHEDULE_ADMIN_GROUP_ID), $scheduleAdminGroupIds);
			$filter->_And($additionalFilter->_Or(new SqlFilterIn(new SqlFilterColumn(TableNames::RESOURCES_ALIAS, ColumnNames::RESOURCE_ADMIN_GROUP_ID), $resourceAdminGroupIds)));
		}

		return parent::GetList($pageNumber, $pageSize, $sortField, $sortDirection, $filter);
	}

    public function Update(BookableResource $resource)
    {
		if (!$this->user->IsAdmin)
		{
			$user = $this->repo->LoadById($this->user->UserId);
			if (!$user->IsResourceAdminFor($resource))
			{
				// if we got to this point, the user does not have the ability to update the resource
				throw new Exception(sprintf('Resource Update Failed. User %s does not have admin access to resource %s.', $this->user->UserId, $resource->GetId()));
			}
		}

        parent::Update($resource);
    }

	public function GetScheduleResources($scheduleId)
	{
		$resources =  parent::GetScheduleResources($scheduleId);
		return $this->GetFilteredResources($resources);
	}

	/**
	 * @param $resources
	 * @return array|BookableResource[]
	 */
	private function GetFilteredResources($resources)
	{
		if ($this->user->IsAdmin)
		{
			return $resources;
		}

		$user = $this->repo->LoadById($this->user->UserId);

		$filteredResources = array();
		/** @var $resource BookableResource */
		foreach ($resources as $resource)
		{
			if ($user->IsResourceAdminFor($resource))
			{
				$filteredResources[] = $resource;
			}
		}

		return $filteredResources;
	}
}
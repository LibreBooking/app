<?php
/**
Copyright 2017-2018 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');

class FakeResourceService implements IResourceService
{
	/**
	 * @var ResourceDto[]
	 */
	public $_AllResources = array();

    /**
	 * @var ResourceDto[]
	 */
	public $_ScheduleResources = array();

    /**
     * @var ScheduleResourceFilter|null
     */
    public $_LastFilter;

    /**
	 * Gets resource list for a schedule
	 * @param int $scheduleId
	 * @param bool $includeInaccessibleResources
	 * @param UserSession $user
	 * @param ScheduleResourceFilter|null $filter
	 * @return array|ResourceDto[]
	 */
	public function GetScheduleResources($scheduleId, $includeInaccessibleResources, UserSession $user, $filter = null)
	{
		return $this->_ScheduleResources;
	}

	public function GetAllResources($includeInaccessibleResources, UserSession $user, $filter = null, $pageNumber = null, $pageSize = null)
	{
	    $this->_LastFilter = $filter;
		return $this->_AllResources;
	}

	/**
	 * @return array|AccessoryDto[]
	 */
	public function GetAccessories()
	{
		// TODO: Implement GetAccessories() method.
	}

	/**
	 * @param int $scheduleId
	 * @param UserSession $user
	 * @return ResourceGroupTree
	 */
	public function GetResourceGroups($scheduleId, UserSession $user)
	{
		// TODO: Implement GetResourceGroups() method.
	}

	/**
	 * @return ResourceType[]
	 */
	public function GetResourceTypes()
	{
		// TODO: Implement GetResourceTypes() method.
	}

	/**
	 * @return Attribute[]
	 */
	public function GetResourceAttributes()
	{
		// TODO: Implement GetResourceAttributes() method.
	}

	/**
	 * @return Attribute[]
	 */
	public function GetResourceTypeAttributes()
	{
		// TODO: Implement GetResourceTypeAttributes() method.
	}

    /**
     * @param int $resourceId
     * @return BookableResource
     */
    public function GetResource($resourceId)
    {
        // TODO: Implement GetResource() method.
    }
}

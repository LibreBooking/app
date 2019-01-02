<?php

/**
 * Copyright 2012-2019 Nick Korbel
 *
 * This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

class Report_Filter
{
	/**
	 * @var int[]|null
	 */
	private $resourceIds;

	/**
	 * @var int[]|null
	 */
	private $scheduleIds;

	/**
	 * @var int|null
	 */
	private $userId;

	/**
	 * @var int|null
	 */
	private $participantId;

	/**
	 * @var int[]|null
	 */
	private $groupIds;

    /**
     * @var int[]|null
     */
	private $accessoryIds;

	/**
	 * @var bool
	 */
	private $includeDeleted;

	/**
	 * @var int[]|null
	 */
	private $resourceTypeIds;

	/**
	 * @param $resourceIds int[]|null
	 * @param $scheduleIds int[]|null
	 * @param $userId int|null
	 * @param $groupIds int[]|null
	 * @param $accessoryIds int[]|null
	 * @param $participantId int|null
	 * @param $includeDeleted bool
	 * @param $resourceTypeIds int[]|null
	 */
	public function __construct($resourceIds, $scheduleIds, $userId, $groupIds, $accessoryIds, $participantId, $includeDeleted, $resourceTypeIds)
	{
	    $removeEmpty = function($value)
        {
            return !empty($value);
        };

	    if (!is_array($resourceIds))
        {
            $resourceIds = array($resourceIds);
        }
        if (!is_array($scheduleIds))
        {
            $scheduleIds = array($scheduleIds);
        }
        if (!is_array($groupIds))
        {
            $groupIds = array($groupIds);
        }
        if (!is_array($accessoryIds))
        {
            $accessoryIds = array($accessoryIds);
        }
        if (!is_array($resourceTypeIds))
        {
            $resourceTypeIds = array($resourceTypeIds);
        }

		$this->resourceIds = array_filter($resourceIds, $removeEmpty);
		$this->scheduleIds = array_filter($scheduleIds, $removeEmpty);
		$this->userId = $userId;
		$this->groupIds = array_filter($groupIds, $removeEmpty);
		$this->accessoryIds = array_filter($accessoryIds, $removeEmpty);
		$this->participantId = $participantId;
		$this->includeDeleted = $includeDeleted;
		$this->resourceTypeIds =array_filter($resourceTypeIds, $removeEmpty) ;
	}

	public function Add(ReportCommandBuilder $builder)
	{
		if (!empty($this->resourceIds))
		{
			$builder->WithResourceIds($this->resourceIds);
		}
		if (!empty($this->scheduleIds))
		{
			$builder->WithScheduleIds($this->scheduleIds);
		}
		if (!empty($this->userId))
		{
			$builder->WithUserId($this->userId);
		}
		if (!empty($this->participantId))
		{
			$builder->WithParticipantId($this->participantId);
		}
		if (!empty($this->groupIds))
		{
			$builder->WithGroupIds($this->groupIds);
		}
		if (!empty($this->accessoryIds))
		{
			$builder->WithAccessoryIds($this->accessoryIds);
		}
		if ($this->includeDeleted)
		{
			$builder->WithDeleted();
		}
		if (!empty($this->resourceTypeIds))
		{
			$builder->WithResourceTypeIds($this->resourceTypeIds);
		}
	}

	/**
	 * @return int[]|null
	 */
	public function ResourceIds()
	{
		return $this->resourceIds;
	}

	/**
	 * @return int[]|null
	 */
	public function ResourceTypeIds()
	{
		return $this->resourceTypeIds;
	}

	/**
	 * @return int[]|null
	 */
	public function ScheduleIds()
	{
		return $this->scheduleIds;
	}

	/**
	 * @return int|null
	 */
	public function UserId()
	{
		return $this->userId;
	}

	/**
	 * @return int|null
	 */
	public function ParticipantId()
	{
		return $this->participantId;
	}

	/**
	 * @return int[]|null
	 */
	public function GroupIds()
	{
		return $this->groupIds;
	}

	/**
	 * @return int[]|null
	 */
	public function AccessoryIds()
	{
		return $this->accessoryIds;
	}

	/**
	 * @return bool
	 */
	public function IncludeDeleted()
	{
		return $this->includeDeleted === true;
	}
}

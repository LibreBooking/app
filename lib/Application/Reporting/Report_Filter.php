<?php
/**
Copyright 2012-2014 Nick Korbel

This file is part of Booked SchedulerBooked SchedulereIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later versBooked SchedulerduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
alBooked SchedulercheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

class Report_Filter
{
	/**
	 * @var int|null
	 */
	private $resourceId;

	/**
	 * @var int|null
	 */
	private $scheduleId;

	/**
	 * @var int|null
	 */
	private $userId;

	/**
	 * @var int|null
	 */
	private $groupId;

	/**
	 * @param $resourceId int|null
	 * @param $scheduleId int|null
	 * @param $userId int|null
	 * @param $groupId int|null
	 * @param $accessoryId int|null
	 */
	public function __construct($resourceId, $scheduleId, $userId, $groupId, $accessoryId)
	{
		$this->resourceId = $resourceId;
		$this->scheduleId = $scheduleId;
		$this->userId = $userId;
		$this->groupId = $groupId;
		$this->accessoryId = $accessoryId;
	}

	public function Add(ReportCommandBuilder $builder)
	{
		if (!empty($this->resourceId))
		{
			$builder->WithResourceId($this->resourceId);
		}
		if (!empty($this->scheduleId))
		{
			$builder->WithScheduleId($this->scheduleId);
		}
		if (!empty($this->userId))
		{
			$builder->WithUserId($this->userId);
		}
		if (!empty($this->groupId))
		{
			$builder->WithGroupId($this->groupId);
		}
		if (!empty($this->accessoryId))
		{
			$builder->WithAccessoryId($this->accessoryId);
		}
	}

	/**
	 * @return int|null
	 */
	public function ResourceId()
	{
		return $this->resourceId;
	}

	/**
	 * @return int|null
	 */
	public function ScheduleId()
	{
		return $this->scheduleId;
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
	public function GroupId()
	{
		return $this->groupId;
	}

	/**
	 * @return int|null
	 */
	public function AccessoryId()
	{
		return $this->accessoryId;
	}
}


?>
<?php
/**
Copyright 2012-2015 Nick Korbel

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

class ReportCommandBuilder
{
	const REPORT_TEMPLATE = 'SELECT [SELECT_TOKEN]
				FROM reservation_instances ri
				INNER JOIN reservation_series rs ON rs.series_id = ri.series_id
				INNER JOIN users owner ON owner.user_id = rs.owner_id

				[JOIN_TOKEN]
				WHERE rs.status_id <> 2
				[AND_TOKEN]
				[GROUP_BY_TOKEN]
				[ORDER_TOKEN]
				[LIMIT_TOKEN]';

	const RESERVATION_LIST_FRAGMENT = 'rs.date_created as date_created, rs.last_modified as last_modified, rs.repeat_type,
		rs.description as description, rs.title as title, rs.status_id as status_id, ri.reference_number, ri.start_date, ri.end_date,
							(SELECT GROUP_CONCAT(CONCAT(cav.custom_attribute_id,\'=\', cav.attribute_value) SEPARATOR "!sep!")
								FROM custom_attribute_values cav WHERE cav.entity_id = ri.series_id AND cav.attribute_category = 1) as attribute_list';

	const COUNT_FRAGMENT = 'COUNT(1) as total';

	const TOTAL_TIME_FRAGMENT = 'SUM( UNIX_TIMESTAMP(LEAST(ri.end_date, @endDate)) - UNIX_TIMESTAMP(GREATEST(ri.start_date, @startDate)) ) AS totalTime';

	const RESOURCE_LIST_FRAGMENT = 'resources.name as resource_name, resources.resource_id';

	const SCHEDULE_LIST_FRAGMENT = 'schedules.schedule_id, schedules.name as schedule_name';

	const ACCESSORY_LIST_FRAGMENT = 'accessories.accessory_name, accessories.accessory_id, ar.quantity';

	const USER_LIST_FRAGMENT = 'owner.fname as owner_fname, owner.lname as owner_lname, CONCAT(owner.fname, \' \', owner.lname) as owner_name, owner.user_id as owner_id';

	const GROUP_LIST_FRAGMENT = 'groups.name as group_name, groups.group_id';

	const RESOURCE_JOIN_FRAGMENT = 'INNER JOIN reservation_resources rr ON rs.series_id = rr.series_id
				INNER JOIN resources ON rr.resource_id = resources.resource_id
				INNER JOIN schedules ON resources.schedule_id = schedules.schedule_id';

	const PARTICIPANT_JOIN_FRAGMENT = 'INNER JOIN users participants ON participants.user_id = @participant_id
			INNER JOIN reservation_users pu ON pu.user_id = participants.user_id AND pu.reservation_user_level = 2 AND pu.reservation_instance_id = ri.reservation_instance_id ';

	const ACCESSORY_JOIN_FRAGMENT = 'INNER JOIN reservation_accessories ar ON rs.series_id = ar.series_id
				INNER JOIN accessories ON ar.accessory_id = accessories.accessory_id';

	const GROUP_JOIN_FRAGMENT = 'INNER JOIN user_groups ug ON ug.user_id = owner.user_id
				INNER JOIN groups ON groups.group_id = ug.group_id';

	const ORDER_BY_FRAGMENT = 'ORDER BY ri.start_date ASC';

	const TOTAL_ORDER_BY_FRAGMENT = 'ORDER BY total DESC';

	const TIME_ORDER_BY_FRAGMENT = 'ORDER BY totalTime DESC';

	const SCHEDULE_ID_FRAGMENT = 'AND schedules.schedule_id = @scheduleid';

	const RESOURCE_ID_FRAGMENT = 'AND resources.resource_id = @resourceid';

	const ACCESSORY_ID_FRAGMENT = 'AND accessories.accessory_id = @accessoryid';

	const USER_ID_FRAGMENT = 'AND owner.user_id = @userid';

	const GROUP_ID_FRAGMENT = 'AND ug.group_id = @groupid';

	const DATE_FRAGMENT = 'AND ((ri.start_date >= @startDate AND ri.start_date < @endDate) OR
						(ri.end_date >= @startDate AND ri.end_date <= @endDate) OR
						(ri.start_date <= @startDate AND ri.end_date > @endDate))';

	const GROUP_BY_GROUP_FRAGMENT = 'GROUP BY groups.group_id';

	const GROUP_BY_RESOURCE_FRAGMENT = 'GROUP BY resources.resource_id';

	const GROUP_BY_SCHEDULE_FRAGMENT = 'GROUP BY schedules.schedule_id';

	const GROUP_BY_USER_FRAGMENT = 'GROUP BY owner.user_id';

	/**
	 * @var bool
	 */
	private $fullList = false;
	/**
	 * @var bool
	 */
	private $count = false;
	/**
	 * @var bool
	 */
	private $time = false;
	/**
	 * @var bool
	 */
	private $joinResources = false;
	/**
	 * @var bool
	 */
	private $joinParticipants = false;
	/**
	 * @var bool
	 */
	private $joinGroups = false;
	/**
	 * @var bool
	 */
	private $joinAccessories = false;
	/**
	 * @var bool
	 */
	private $listResources = false;
	/**
	 * @var bool
	 */
	private $listSchedules = false;
	/**
	 * @var bool
	 */
	private $listGroups = false;
	/** @var bool
	 */
	private $listUsers = false;
	/**
	 * @var bool
	 */
	private $listAccessories = false;
	/**
	 * @var bool
	 */
	private $limitWithin = false;
	/**
	 * @var null|int
	 */
	private $scheduleId = null;
	/**
	 * @var null|int
	 */
	private $userId = null;
	/**
	 * @var null|int
	 */
	private $participantId = null;
	/**
	 * @var null|int
	 */
	private $resourceId = null;
	/**
	 * @var null|int
	 */
	private $accessoryId = null;
	/**
	 * @var null|int
	 */
	private $groupId = null;
	/**
	 * @var null|Date
	 */
	private $startDate = null;
	/**
	 * @var null|Date
	 */
	private $endDate = null;
	/**
	 * @var bool
	 */
	private $groupByGroup = false;
	/**
	 * @var bool
	 */
	private $groupByResource = false;
	/**
	 * @var bool
	 */
	private $groupBySchedule = false;
	/**
	 * @var bool
	 */
	private $groupByUser = false;
	/**
	 * @var int
	 */
	private $limit = 0;
	/**
	 * @var array|Parameter[]
	 */
	private $parameters = array();

	/**
	 * @return ReportCommandBuilder
	 */
	public function SelectFullList()
	{
		$this->fullList = true;
		$this->listUsers = true;
		return $this;
	}

	/**
	 * @return ReportCommandBuilder
	 */
	public function SelectCount()
	{
		$this->count = true;
		return $this;
	}

	/**
	 * @return ReportCommandBuilder
	 */
	public function SelectTime()
	{
		$this->time = true;
		$this->limitWithin = true;
		$this->startDate = Date::Min();
		$this->endDate = Date::Max();
		return $this;
	}

	/**
	 * @return ReportCommandBuilder
	 */
	public function OfResources()
	{
		$this->joinResources = true;
		$this->listResources = true;
		return $this;
	}

	/**
	 * @return ReportCommandBuilder
	 */
	public function OfAccessories()
	{
		$this->joinAccessories = true;
		$this->listAccessories = true;
		return $this;
	}

	/**
	 * @param Date $start
	 * @param Date $end
	 * @return ReportCommandBuilder
	 */
	public function Within(Date $start, Date $end)
	{
		$this->limitWithin = true;
		$this->startDate = $start;
		$this->endDate = $end;
		return $this;
	}

	/**
	 * @param int $resourceId
	 * @return ReportCommandBuilder
	 */
	public function WithResourceId($resourceId)
	{
		$this->joinResources = true;
		$this->resourceId = $resourceId;
		return $this;
	}

	/**
	 * @param int $userId
	 * @return ReportCommandBuilder
	 */
	public function WithUserId($userId)
	{
		$this->userId = $userId;
		return $this;
	}

	/**
	 * @param int $userId
	 * @return ReportCommandBuilder
	 */
	public function WithParticipantId($userId)
	{
		$this->joinParticipants = true;
		$this->participantId = $userId;
		return $this;
	}

	/**
	 * @param int $scheduleId
	 * @return ReportCommandBuilder
	 */
	public function WithScheduleId($scheduleId)
	{
		$this->joinResources = true;
		$this->scheduleId = $scheduleId;
		return $this;
	}

	/**
	 * @param int $groupId
	 * @return ReportCommandBuilder
	 */
	public function WithGroupId($groupId)
	{
		$this->joinGroups = true;
		$this->groupId = $groupId;
		return $this;
	}

	/**
	 * @param int $accessoryId
	 * @return ReportCommandBuilder
	 */
	public function WithAccessoryId($accessoryId)
	{
		$this->joinAccessories = true;
		$this->accessoryId = $accessoryId;
		return $this;
	}

	/**
	 * @return ReportCommandBuilder
	 */
	public function GroupByGroup()
	{
		$this->joinGroups = true;
		$this->listGroups = true;
		$this->groupByGroup = true;
		return $this;
	}

	/**
	 * @return ReportCommandBuilder
	 */
	public function GroupByResource()
	{
		$this->joinResources = true;
		$this->listResources = true;
		$this->groupByResource = true;
		return $this;
	}

	/**
	 * @return ReportCommandBuilder
	 */
	public function GroupByUser()
	{
		$this->listUsers = true;
		$this->groupByUser = true;
		return $this;
	}

	/**
	 * @return ReportCommandBuilder
	 */
	public function GroupBySchedule()
	{
		$this->joinResources = true;
		$this->listSchedules = true;
		$this->groupBySchedule = true;
		return $this;
	}

	/**
	 * @param int $limit
	 * @return ReportCommandBuilder
	 */
	public function LimitedTo($limit)
	{
		$this->limit = $limit;
	}

	/**
	 * @return ISqlCommand
	 */
	public function Build()
	{
		$sql = self::REPORT_TEMPLATE;
		$sql = str_replace('[SELECT_TOKEN]', $this->GetSelectList(), $sql);
		$sql = str_replace('[JOIN_TOKEN]', $this->GetJoin(), $sql);
		$sql = str_replace('[AND_TOKEN]', $this->GetWhereAnd(), $sql);
		$sql = str_replace('[GROUP_BY_TOKEN]', $this->GetGroupBy(), $sql);
		$sql = str_replace('[ORDER_TOKEN]', $this->GetOrderBy(), $sql);
		$sql = str_replace('[LIMIT_TOKEN]', $this->GetLimit(), $sql);

		$query = new AdHocCommand($sql);
		foreach ($this->parameters as $parameter)
		{
			$query->AddParameter($parameter);
		}

		return $query;
	}

	/**
	 * @return ReportQueryFragment
	 */
	private function GetSelectList()
	{
		$selectSql = new ReportQueryFragment();

		if ($this->fullList)
		{
			$selectSql->Append(self::RESERVATION_LIST_FRAGMENT);
		}

		if ($this->count)
		{
			$selectSql->Append(self::COUNT_FRAGMENT);
		}

		if ($this->time)
		{
			$selectSql->Append(self::TOTAL_TIME_FRAGMENT);
		}

		if ($this->listResources && ($this->fullList || $this->groupByResource))
		{
			$selectSql->AppendSelect(self::RESOURCE_LIST_FRAGMENT);
		}

		if ($this->listAccessories && $this->fullList)
		{
			$selectSql->AppendSelect(self::ACCESSORY_LIST_FRAGMENT);
		}

		if ($this->listGroups)
		{
			$selectSql->AppendSelect(self::GROUP_LIST_FRAGMENT);
		}

		if ($this->listUsers)
		{
			$selectSql->AppendSelect(self::USER_LIST_FRAGMENT);
		}

		if ($this->listSchedules)
		{
			$selectSql->AppendSelect(self::SCHEDULE_LIST_FRAGMENT);
		}

		return $selectSql;
	}

	/**
	 * @return ReportQueryFragment
	 */
	private function GetJoin()
	{
		$join = new ReportQueryFragment();

		if ($this->joinResources)
		{
			$join->Append(self::RESOURCE_JOIN_FRAGMENT);
		}

		if ($this->joinAccessories)
		{
			$join->Append(self::ACCESSORY_JOIN_FRAGMENT);
		}

		if ($this->joinGroups)
		{
			$join->Append(self::GROUP_JOIN_FRAGMENT);
		}

		if ($this->joinParticipants)
		{
			$join->Append(self::PARTICIPANT_JOIN_FRAGMENT);
		}

		return $join;
	}

	/**
	 * @return ReportQueryFragment
	 */
	private function GetWhereAnd()
	{
		$and = new ReportQueryFragment();

		if (!empty($this->scheduleId))
		{
			$and->Append(self::SCHEDULE_ID_FRAGMENT);
			$this->AddParameter(new Parameter(ParameterNames::SCHEDULE_ID, $this->scheduleId));
		}

		if (!empty($this->userId))
		{
			$and->Append(self::USER_ID_FRAGMENT);
			$this->AddParameter(new Parameter(ParameterNames::USER_ID, $this->userId));
		}


		if (!empty($this->participantId))
		{
			$this->AddParameter(new Parameter(ParameterNames::PARTICIPANT_ID, $this->participantId));
		}

		if (!empty($this->groupId))
		{
			$and->Append(self::GROUP_ID_FRAGMENT);
			$this->AddParameter(new Parameter(ParameterNames::GROUP_ID, $this->groupId));
		}

		if (!empty($this->resourceId))
		{
			$and->Append(self::RESOURCE_ID_FRAGMENT);
			$this->AddParameter(new Parameter(ParameterNames::RESOURCE_ID, $this->resourceId));
		}

		if (!empty($this->accessoryId))
		{
			$and->Append(self::ACCESSORY_ID_FRAGMENT);
			$this->AddParameter(new Parameter(ParameterNames::ACCESSORY_ID, $this->accessoryId));
		}

		if ($this->limitWithin)
		{
			$and->Append(self::DATE_FRAGMENT);
			$this->AddParameter(new Parameter(ParameterNames::START_DATE, $this->startDate->ToDatabase()));
			$this->AddParameter(new Parameter(ParameterNames::END_DATE, $this->endDate->ToDatabase()));
		}

		return $and;
	}

	/**
	 * @return ReportQueryFragment
	 */
	private function GetGroupBy()
	{
		$groupBy = new ReportQueryFragment();
		if ($this->fullList)
		{
			return $groupBy;
		}
		if ($this->groupByGroup)
		{
			$groupBy->Append(self::GROUP_BY_GROUP_FRAGMENT);
		}

		if ($this->groupByResource)
		{
			$groupBy->Append(self::GROUP_BY_RESOURCE_FRAGMENT);
		}

		if ($this->groupBySchedule)
		{
			$groupBy->Append(self::GROUP_BY_SCHEDULE_FRAGMENT);
		}

		if ($this->groupByUser)
		{
			$groupBy->Append(self::GROUP_BY_USER_FRAGMENT);
		}

		return $groupBy;
	}

	/**
	 * @return ReportQueryFragment
	 */
	private function GetOrderBy()
	{
		$orderBy = new ReportQueryFragment();
		if ($this->fullList)
		{
			$orderBy->Append(self::ORDER_BY_FRAGMENT);
		}
		else {
			if ($this->count)
			{
				$orderBy->Append(self::TOTAL_ORDER_BY_FRAGMENT);
			}
			else
			{
				$orderBy->Append(self::TIME_ORDER_BY_FRAGMENT);
			}
		}

		return $orderBy;
	}

	/**
	 * @return ReportQueryFragment
	 */
	private function GetLimit()
	{
		$limit = new ReportQueryFragment();
		if (!empty($this->limit))
		{
			$limit->Append("LIMIT 0 , {$this->limit}");
		}

		return $limit;
	}

	private function AddParameter(Parameter $parameter)
	{
		$this->parameters[] = $parameter;
	}
}

class ReportQueryFragment
{
	private $sql = '';

	public function Append($sql)
	{
		$this->sql .= " $sql";
	}

	public function AppendSelect($selectSql)
	{
		$this->sql .= ",$selectSql";
	}

	public function __toString()
	{
		return $this->sql;
	}
}

?>
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

interface IQuotaRepository
{
	/**
	 * @abstract
	 * @return array|Quota[]
	 */
	function LoadAll();

	/**
	 * @abstract
	 * @param Quota $quota
	 * @return void
	 */
	function Add(Quota $quota);

	/**
	 * @abstract
	 * @param $quotaId
	 * @return void
	 */
	function DeleteById($quotaId);
}

interface IQuotaViewRepository
{
	/**
	 * @abstract
	 * @return array|QuotaItemView[]
	 */
	function GetAll();
}

class QuotaRepository implements IQuotaRepository, IQuotaViewRepository
{
	public function LoadAll()
	{
		$quotas = array();

		$command = new GetAllQuotasCommand();
		$reader = ServiceLocator::GetDatabase()->Query($command);

		while ($row = $reader->GetRow())
		{
			$quotaId = $row[ColumnNames::QUOTA_ID];

			$limit = Quota::CreateLimit($row[ColumnNames::QUOTA_LIMIT], $row[ColumnNames::QUOTA_UNIT]);
			$duration = Quota::CreateDuration($row[ColumnNames::QUOTA_DURATION]);

			$resourceId = $row[ColumnNames::RESOURCE_ID];
			$groupId = $row[ColumnNames::GROUP_ID];
			$scheduleId = $row[ColumnNames::SCHEDULE_ID];
			$enforcedStartTime = $row[ColumnNames::ENFORCED_START_TIME];
			$enforcedEndTime = $row[ColumnNames::ENFORCED_END_TIME];
			$enforcedDays = empty($row[ColumnNames::ENFORCED_DAYS]) ? array() : explode(',', $row[ColumnNames::ENFORCED_DAYS]);
			$scope = Quota::CreateScope($row[ColumnNames::QUOTA_SCOPE]);

			$quotas[] = new Quota($quotaId, $duration, $limit, $resourceId, $groupId, $scheduleId, $enforcedStartTime, $enforcedEndTime, $enforcedDays, $scope);
		}
		$reader->Free();
		return $quotas;
	}

	/**
	 * @return array|QuotaItemView[]
	 */
	function GetAll()
	{
		$quotas = array();

		$command = new GetAllQuotasCommand();
		$reader = ServiceLocator::GetDatabase()->Query($command);

		while ($row = $reader->GetRow())
		{
			$quotaId = $row[ColumnNames::QUOTA_ID];

			$limit = $row[ColumnNames::QUOTA_LIMIT];
			$unit = $row[ColumnNames::QUOTA_UNIT];
			$duration = $row[ColumnNames::QUOTA_DURATION];
			$groupName = $row['group_name'];
			$resourceName = $row['resource_name'];
			$scheduleName = $row['schedule_name'];
			$enforcedStartTime = $row[ColumnNames::ENFORCED_START_TIME];
			$enforcedEndTime = $row[ColumnNames::ENFORCED_END_TIME];
			$enforcedDays = empty($row[ColumnNames::ENFORCED_DAYS]) ? array() : explode(',', $row[ColumnNames::ENFORCED_DAYS]);
			$scope = $row[ColumnNames::QUOTA_SCOPE];

			$quotas[] = new QuotaItemView($quotaId, $limit, $unit, $duration, $groupName, $resourceName, $scheduleName, $enforcedStartTime, $enforcedEndTime,
										  $enforcedDays, $scope);
		}

		$reader->Free();
		return $quotas;
	}

	/**
	 * @param Quota $quota
	 * @return void
	 */
	function Add(Quota $quota)
	{
		$command = new AddQuotaCommand($quota->GetDuration()->Name(),
									   $quota->GetLimit()->Amount(),
									   $quota->GetLimit()->Name(),
									   $quota->ResourceId(),
									   $quota->GroupId(),
									   $quota->ScheduleId(),
									   $quota->EnforcedStartTime(),
									   $quota->EnforcedEndTime(),
									   $quota->EnforcedDays(),
									   $quota->GetScope()->Name());

		ServiceLocator::GetDatabase()->Execute($command);
	}

	/**
	 * @param $quotaId
	 * @return void
	 */
	function DeleteById($quotaId)
	{
		//TODO:  Make this delete a quota instead of the id
		$command = new DeleteQuotaCommand($quotaId);
		ServiceLocator::GetDatabase()->Execute($command);
	}
}

class QuotaItemView
{
	public $Id;
	public $Limit;
	public $Unit;
	public $Duration;
	public $GroupName;
	public $ResourceName;
	public $ScheduleName;
	public $AllDay;
	public $Everyday;
	public $EnforcedStartTime;
	public $EnforcedEndTime;
	public $EnforcedDays;
	public $Scope;

	/**
	 * @param int $quotaId
	 * @param decimal $limit
	 * @param string $unit
	 * @param string $duration
	 * @param string $groupName
	 * @param string $resourceName
	 * @param string $scheduleName
	 * @param string|null $enforcedStartTime
	 * @param string|null $enforcedEndTime
	 * @param array|int[] $enforcedDays
	 * @param string $scope
	 */
	public function __construct($quotaId, $limit, $unit, $duration, $groupName, $resourceName, $scheduleName, $enforcedStartTime, $enforcedEndTime,
								$enforcedDays, $scope)
	{
		$this->Id = $quotaId;
		$this->Limit = $limit;
		$this->Unit = $unit;
		$this->Duration = $duration;
		$this->GroupName = $groupName;
		$this->ResourceName = $resourceName;
		$this->ScheduleName = $scheduleName;
		$this->EnforcedStartTime = empty($enforcedStartTime) ? null : Time::Parse($enforcedStartTime);
		$this->EnforcedEndTime = empty($enforcedEndTime) ? null : Time::Parse($enforcedEndTime);
		$this->EnforcedDays = empty($enforcedDays) ? array() : $enforcedDays;
		$this->AllDay = empty($enforcedStartTime) || empty($enforcedEndTime);
		$this->Everyday = empty($enforcedDays);
		$this->Scope = empty($scope) ? QuotaScope::IncludeCompleted : $scope;
	}
}
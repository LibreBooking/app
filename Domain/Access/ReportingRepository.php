<?php
/**
Copyright 2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

class ReportCommandBuilder
{
	const REPORT_TEMPLATE = 'SELECT [SELECT_TOKEN] FROM reservation_instances ri
				INNER JOIN reservation_series rs ON rs.series_id = ri.series_id
				INNER JOIN reservation_users ru ON ru.reservation_instance_id = ri.reservation_instance_id
				INNER JOIN users ON users.user_id = rs.owner_id
				INNER JOIN users owner ON owner.user_id = rs.owner_id
				[JOIN_TOKEN]
				WHERE rs.status_id <> 2 AND ru.reservation_user_level = 1
				[AND_TOKEN]
				[ORDER_TOKEN]';

	const COMMON_LIST_FRAGMENT = 'rs.date_created as date_created, rs.last_modified as last_modified, rs.description as description, rs.title as title
						rs.status_id as status_id, owner.fname as owner_fname, owner.lname as owner_lname, owner.user_id as owner_id';

	const RESOURCE_LIST_FRAGMENT = 'resources.name, resources.resource_id, resources.schedule_id, schedules.name as schedule_name';

	const ACCESSORY_LIST_FRAGMENT = 'accessories.accessory_name, accessories.accessory_id';

	const RESOURCE_JOIN_FRAGMENT = 'INNER JOIN reservation_resources rr ON rs.series_id = rr.series_id
				INNER JOIN resources on rr.resource_id = resources.resource_id
				INNER JOIN schedules ON resources.schedule_id = schedules.schedule_id';

	const ACCESSORY_JOIN_FRAGMENT = 'INNER JOIN reservation_accessories ar ON rs.series_id = ar.series_id
				INNER JOIN accessories ON ar.accessory_id = accessories.accessory_id';

	const ORDER_BY_FRAGMENT = 'ORDER BY ri.start_date ASC';

	private $fullList = false;
	private $resources = false;
	private $accessories = false;

	/**
	 * @return ReportCommandBuilder
	 */
	public function SelectFullList()
	{
		$this->fullList = true;
		return $this;
	}

	/**
	 * @return ReportCommandBuilder
	 */
	public function OfResources()
	{
		$this->resources = true;
		return $this;
	}

	/**
	 * @return ReportCommandBuilder
	 */
	public function OfAccessories()
	{
		$this->accessories = true;
		return $this;
	}

	/**
	 * @param Date $start
	 * @param Date $end
	 * @return ReportCommandBuilder
	 */
	public function Within(Date $start, Date $end)
	{
		return $this;
	}

	/**
	 * @param int $resourceId
	 * @return ReportCommandBuilder
	 */
	public function WithResourceId($resourceId)
	{
		return $this;
	}

	/**
	 * @param int $userId
	 * @return ReportCommandBuilder
	 */
	public function WithUserId($userId)
	{
		return $this;
	}

	/**
	 * @param int $scheduleId
	 * @return ReportCommandBuilder
	 */
	public function WithScheduleId($scheduleId)
	{
		return $this;
	}

	/**
	 * @param int $groupId
	 * @return ReportCommandBuilder
	 */
	public function WithGroupId($groupId)
	{
		return $this;
	}

	/**
	 * @return ReportCommandBuilder
	 */
	public function GroupByGroup()
	{
		return $this;
	}

	/**
	 * @return ISqlCommand
	 */
	public function Build()
	{
		$sql = self::REPORT_TEMPLATE;
		$sql = str_replace('[SELECT_TOKEN]', $this->GetSelectList(), $sql);
		$sql = str_replace('[JOIN_TOKEN]', $this->GetJoin(), $sql);
		$sql = str_replace('[AND_TOKEN]', '', $sql);
		$sql = str_replace('[ORDER_TOKEN]', self::ORDER_BY_FRAGMENT, $sql);


		$query = new AdHocCommand($sql);
		//$query->AddParameter()

		return $query;
	}

	/**
	 * @return string
	 */
	private function GetSelectList()
	{
		$selectSql = '';

		if ($this->fullList)
		{
			$selectSql = self::COMMON_LIST_FRAGMENT;
			if ($this->resources)
			{
				return $selectSql . ',' . self::RESOURCE_LIST_FRAGMENT;
			}

			if ($this->accessories)
			{
				return $selectSql . ',' . self::ACCESSORY_LIST_FRAGMENT;
			}
		}

		return $selectSql;
	}

	/**
	 * @return string
	 */
	private function GetJoin()
	{
		if ($this->resources)
		{
			return self::RESOURCE_JOIN_FRAGMENT;
		}

		if ($this->accessories)
		{
			return self::ACCESSORY_JOIN_FRAGMENT;
		}

		return '';
	}


}

interface IReportingRepository
{

}

class ReportingRepository implements IReportingRepository
{

}

?>
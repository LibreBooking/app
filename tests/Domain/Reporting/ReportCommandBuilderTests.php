<?php
/**
 * Copyright 2012-2017 Nick Korbel
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

class ReportCommandBuilderTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}

	public function testJustFullResourceList()
	{
		$builder = new ReportCommandBuilder();
		$actual = $builder->SelectFullList()
						  ->OfResources()
						  ->Build();

		$this->assertContains(ReportCommandBuilder::RESERVATION_LIST_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::RESOURCE_LIST_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::RESOURCE_JOIN_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::ORDER_BY_FRAGMENT, $actual->GetQuery());
	}

	public function testJustFullAccessoryList()
	{
		$builder = new ReportCommandBuilder();
		$actual = $builder->SelectFullList()
						  ->OfAccessories()
						  ->Build();

		$this->assertContains(ReportCommandBuilder::RESERVATION_LIST_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::ACCESSORY_LIST_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::ACCESSORY_JOIN_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::ORDER_BY_FRAGMENT, $actual->GetQuery());
	}

	public function testFilteredBySchedule()
	{
		$scheduleId = array(123);

		$builder = new ReportCommandBuilder();
		$actual = $builder->SelectFullList()
						  ->OfAccessories()
						  ->WithScheduleIds($scheduleId)
						  ->Build();

		$this->assertContains(ReportCommandBuilder::RESERVATION_LIST_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::ACCESSORY_LIST_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::ACCESSORY_JOIN_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::RESOURCE_JOIN_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::SCHEDULE_ID_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::ORDER_BY_FRAGMENT, $actual->GetQuery());
	}

	public function testFilteredByAccessory()
	{
		$accessoryId = array(123);

		$builder = new ReportCommandBuilder();
		$actual = $builder->SelectFullList()
						  ->OfAccessories()
						  ->WithAccessoryIds($accessoryId)
						  ->Build();

		$this->assertContains(ReportCommandBuilder::RESERVATION_LIST_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::ACCESSORY_LIST_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::ACCESSORY_JOIN_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::ACCESSORY_ID_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::ORDER_BY_FRAGMENT, $actual->GetQuery());
	}

	public function testFilteredByUser()
	{
		$userId = 123;

		$builder = new ReportCommandBuilder();
		$actual = $builder->SelectFullList()
						  ->OfResources()
						  ->WithUserId($userId)
						  ->Build();

		$this->assertContains(ReportCommandBuilder::RESERVATION_LIST_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::RESOURCE_LIST_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::RESOURCE_JOIN_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::USER_ID_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::ORDER_BY_FRAGMENT, $actual->GetQuery());
	}

	public function testFilteredByParticipant()
	{
		$userId = 123;

		$builder = new ReportCommandBuilder();
		$actual = $builder->SelectFullList()
						  ->OfResources()
						  ->WithParticipantId($userId)
						  ->Build();

		$this->assertContains(ReportCommandBuilder::RESERVATION_LIST_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::RESOURCE_LIST_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::RESOURCE_JOIN_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::PARTICIPANT_JOIN_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::ORDER_BY_FRAGMENT, $actual->GetQuery());
	}

	public function testFilteredByGroup()
	{
		$groupId = array(123);

		$builder = new ReportCommandBuilder();
		$actual = $builder->SelectFullList()
						  ->OfAccessories()
						  ->WithGroupIds($groupId)
						  ->Build();

		$this->assertContains(ReportCommandBuilder::RESERVATION_LIST_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::USER_LIST_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::ACCESSORY_LIST_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::ACCESSORY_JOIN_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::GROUP_JOIN_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::GROUP_ID_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::ORDER_BY_FRAGMENT, $actual->GetQuery());
	}

	public function testFilteredByGroupAndSchedule()
	{
		$groupId = array(123);
		$scheduleId = array(123);

		$builder = new ReportCommandBuilder();
		$actual = $builder->SelectFullList()
						  ->OfAccessories()
						  ->WithGroupIds($groupId)
						  ->WithScheduleIds($scheduleId)
						  ->Build();

		$this->assertContains(ReportCommandBuilder::RESERVATION_LIST_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::USER_LIST_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::ACCESSORY_LIST_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::ACCESSORY_JOIN_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::USER_LIST_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::GROUP_JOIN_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::GROUP_ID_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::RESOURCE_JOIN_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::SCHEDULE_ID_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::ORDER_BY_FRAGMENT, $actual->GetQuery());
	}

	public function testCountOfResourceIdGroupedByGroup()
	{
		$resourceId = array(123);

		$builder = new ReportCommandBuilder();
		$actual = $builder->SelectCount()
						  ->WithResourceIds($resourceId)
						  ->GroupByGroup()
						  ->Build();

		$this->assertContains(ReportCommandBuilder::COUNT_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::GROUP_LIST_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::GROUP_JOIN_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::RESOURCE_JOIN_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::RESOURCE_ID_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::GROUP_BY_GROUP_FRAGMENT, $actual->GetQuery());
	}

	public function testFilteredByDateRange()
	{
		$resourceId = array(123);
		$start = Date::Now();
		$end = Date::Now();

		$builder = new ReportCommandBuilder();
		$actual = $builder->SelectFullList()
						  ->OfResources()
						  ->WithResourceIds($resourceId)
						  ->Within($start, $end)
						  ->Build();

		$this->assertContains(ReportCommandBuilder::USER_LIST_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::RESOURCE_LIST_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::RESOURCE_JOIN_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::RESOURCE_ID_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::DATE_FRAGMENT, $actual->GetQuery());
	}

	public function testGroupsByGroupAndResource()
	{
		$builder = new ReportCommandBuilder();
		$actual = $builder->SelectCount()
						  ->GroupByGroup()
						  ->GroupByResource()
						  ->Build();

		$this->assertContains(ReportCommandBuilder::COUNT_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::GROUP_LIST_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::GROUP_JOIN_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::RESOURCE_LIST_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::RESOURCE_JOIN_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::GROUP_BY_GROUP_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::GROUP_BY_RESOURCE_FRAGMENT, $actual->GetQuery());
	}

	public function testGroupsBySchedule()
	{
		$builder = new ReportCommandBuilder();
		$actual = $builder->SelectCount()
						  ->GroupBySchedule()
						  ->Build();

		$this->assertContains(ReportCommandBuilder::COUNT_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::SCHEDULE_LIST_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::RESOURCE_JOIN_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::GROUP_BY_SCHEDULE_FRAGMENT, $actual->GetQuery());
	}

	public function testGroupsByUser()
	{
		$builder = new ReportCommandBuilder();
		$actual = $builder->SelectCount()
						  ->GroupByUser()
						  ->Build();

		$this->assertContains(ReportCommandBuilder::COUNT_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::USER_LIST_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::GROUP_BY_USER_FRAGMENT, $actual->GetQuery());
	}

	public function testIfGroupByThenNoResourcesAreListed()
	{
		$builder = new ReportCommandBuilder();
		$actual = $builder->SelectCount()
						  ->OfResources()
						  ->GroupByGroup()
						  ->Build();

		$this->assertNotContains(ReportCommandBuilder::RESOURCE_LIST_FRAGMENT, $actual->GetQuery());
		$this->assertNotContains(ReportCommandBuilder::RESERVATION_LIST_FRAGMENT, $actual->GetQuery());
	}

	public function testFilteredByResourceType()
	{
		$resourceTypeId = array(123);

		$builder = new ReportCommandBuilder();
		$actual = $builder->SelectFullList()
						  ->OfResources()
						  ->WithResourceTypeIds($resourceTypeId)
						  ->Build();

		$this->assertContains(ReportCommandBuilder::RESOURCE_LIST_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::RESOURCE_JOIN_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::RESOURCE_TYPE_ID_FRAGMENT, $actual->GetQuery());
	}
}
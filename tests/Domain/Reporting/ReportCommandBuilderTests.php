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
		$scheduleId = 123;

		$builder = new ReportCommandBuilder();
		$actual = $builder->SelectFullList()
				->OfAccessories()
				->WithScheduleId($scheduleId)
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
		$accessoryId = 123;

		$builder = new ReportCommandBuilder();
		$actual = $builder->SelectFullList()
				->OfAccessories()
				->WithAccessoryId($accessoryId)
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

	public function testFilteredByGroup()
	{
		$groupId = 123;

		$builder = new ReportCommandBuilder();
		$actual = $builder->SelectFullList()
				->OfAccessories()
				->WithGroupId($groupId)
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
		$groupId = 123;
		$scheduleId = 123;

		$builder = new ReportCommandBuilder();
		$actual = $builder->SelectFullList()
				->OfAccessories()
				->WithGroupId($groupId)
				->WithScheduleId($scheduleId)
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
		$resourceId = 123;

		$builder = new ReportCommandBuilder();
		$actual = $builder->SelectCount()
				->WithResourceId($resourceId)
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
		$resourceId = 123;
		$start = Date::Now();
		$end = Date::Now();

		$builder = new ReportCommandBuilder();
		$actual = $builder->SelectFullList()
				->OfResources()
				->WithResourceId($resourceId)
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
}

?>
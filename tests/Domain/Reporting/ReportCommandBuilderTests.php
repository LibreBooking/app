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
		
		$this->assertContains(ReportCommandBuilder::COMMON_LIST_FRAGMENT, $actual->GetQuery());
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

		$this->assertContains(ReportCommandBuilder::COMMON_LIST_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::ACCESSORY_LIST_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::ACCESSORY_JOIN_FRAGMENT, $actual->GetQuery());
		$this->assertContains(ReportCommandBuilder::ORDER_BY_FRAGMENT, $actual->GetQuery());
	}
}

?>
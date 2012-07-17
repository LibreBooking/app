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

require_once(ROOT_DIR . 'Presenters/Reports/GenerateReportPresenter.php');

class ReportDefinitionTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}

	public function testGetsColumns()
	{
		$rows = array(array(ColumnNames::ACCESSORY_NAME => 'an', ColumnNames::RESOURCE_NAME_ALIAS => 'rn'),	'unknown' => 'unknown');
		$report = new CustomReport($rows);

		$definition = new ReportDefinition($report, null);

		$headerKeys = $definition->GetColumnHeaders();

		$this->assertEquals(2, count($headerKeys));
	}

	public function testOrdersAndFormatsData()
	{
		$timezone = 'America/Chicago';
		$date = '2012-02-14 08:12:31';

		$rows = array(array(
						  ColumnNames::RESERVATION_END => $date,
						  ColumnNames::GROUP_NAME_ALIAS => 'gn',
						  ColumnNames::ACCESSORY_NAME => 'an',
							'unknown' => 'unknown'

					  ));
		$report = new CustomReport($rows);

		$definition = new ReportDefinition($report, $timezone);

		$row = $definition->GetRow($rows[0]);

		$this->assertEquals(3, count($row));
		$this->assertEquals('an', $row[0]);
		$format = Resources::GetInstance()->GeneralDateTimeFormat();
		$this->assertEquals(Date::FromDatabase($date)->ToTimezone($timezone)->Format($format), $row[1]);
		$this->assertEquals('gn', $row[2]);
	}
}

?>
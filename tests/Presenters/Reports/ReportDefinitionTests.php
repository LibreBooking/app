<?php
/**
 * Copyright 2012-2014 Nick Korbel
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

require_once(ROOT_DIR . 'Presenters/Reports/GenerateReportPresenter.php');

class ReportDefinitionTests extends TestBase
{
	/**
	 * @var FakeAttributeRepository
	 */
	private $attributeRepository;

	public function setup()
	{
		$this->attributeRepository = new FakeAttributeRepository();
		parent::setup();
	}

	public function testGetsColumns()
	{
		$rows = array(array(ColumnNames::ACCESSORY_NAME => 'an', ColumnNames::RESOURCE_NAME_ALIAS => 'rn', 'unknown' => 'unknown'));
		$report = new CustomReport($rows, $this->attributeRepository);

		$definition = new ReportDefinition($report, null);

		$headerKeys = $definition->GetColumnHeaders();

		$this->assertEquals(2, count($headerKeys));
	}

	public function testGetsColumnsWithCustomAttributes()
	{
		$attributes = $this->attributeRepository->_CustomAttributes;

		$rows = array(array(ColumnNames::ACCESSORY_NAME => 'an', 'unknown' => 'unknown', ColumnNames::ATTRIBUTE_LIST => '1=1!sep!2=!sep!3='));
		$report = new CustomReport($rows, $this->attributeRepository);

		$definition = new ReportDefinition($report, null);

		$headerKeys = $definition->GetColumnHeaders();

		$this->assertEquals(3, count($headerKeys));
		$this->assertEquals('test attribute', $headerKeys['attribute1']->Title());
		$this->assertEquals('test attribute2', $headerKeys['attribute2']->Title());
	}

	public function testOrdersAndFormatsData()
	{
		$timezone = 'America/Chicago';
		$date = '2012-02-14 08:12:31';
		$oneHourThirtyMinutes = TimeInterval::Parse("1h30m");
		$userId = 100;

		$rows = array(array(
				ColumnNames::RESERVATION_START => $date,
				ColumnNames::OWNER_FULL_NAME_ALIAS => 'un',
				ColumnNames::OWNER_USER_ID => $userId,
				ColumnNames::ACCESSORY_NAME => 'an',
				'unknown' => 'unknown',
				ColumnNames::TOTAL_TIME => $oneHourThirtyMinutes->TotalSeconds(),
				ColumnNames::ACCESSORY_ID => 1,
		));
		$report = new CustomReport($rows, $this->attributeRepository);

		$definition = new ReportDefinition($report, $timezone);

		/** @var $row ReportCell[] */
		$row = $definition->GetRow($rows[0]);

		$this->assertEquals(4, count($row));
		$this->assertEquals('an', $row[0]->Value());

		$format = Resources::GetInstance()->GeneralDateTimeFormat();
		$systemFormat = Resources::GetInstance()->GeneralDateFormat();

		$this->assertEquals(Date::FromDatabase($date)->ToTimezone($timezone)->Format($format), $row[1]->Value());
		$this->assertEquals(Date::FromDatabase($date)->ToTimezone($timezone)->Format($systemFormat), $row[1]->ChartValue());
		$this->assertEquals(ChartColumnType::Date, $row[1]->GetChartColumnType());
		$this->assertNull($row[1]->GetChartGroup());

		$this->assertEquals('un', $row[2]->Value());
		$this->assertEquals($userId, $row[2]->ChartValue());
		$this->assertEquals(ChartColumnType::Label, $row[2]->GetChartColumnType());
		$this->assertEmpty($row[2]->GetChartGroup());

		$this->assertEquals($oneHourThirtyMinutes, $row[3]->Value());
		$this->assertEquals($oneHourThirtyMinutes->TotalSeconds(), $row[3]->ChartValue());
		$this->assertEquals(ChartColumnType::Total, $row[3]->GetChartColumnType());
	}

	public function testGetChartTypeBasedOnReportData()
	{
		$timezone = 'UTC';
		$totalReport = new CustomReport(array(array(ColumnNames::TOTAL => 1)), $this->attributeRepository);
		$timeReport = new CustomReport(array(array(ColumnNames::TOTAL_TIME => 1)), $this->attributeRepository);
		$reservationReport = new CustomReport(array(array(ColumnNames::RESERVATION_START => 1)), $this->attributeRepository);

		$totalDefinition = new ReportDefinition($totalReport, $timezone);
		$timeDefinition = new ReportDefinition($timeReport, $timezone);
		$reservationDefinition = new ReportDefinition($reservationReport, $timezone);

		$this->assertEquals(ChartType::Total, $totalDefinition->GetChartType());
		$this->assertEquals(ChartType::TotalTime, $timeDefinition->GetChartType());
		$this->assertEquals(ChartType::Date, $reservationDefinition->GetChartType());
	}

	public function testGetsRowDataForCustomAttributes()
	{
		$rows = array(array(
				ColumnNames::ACCESSORY_NAME => 'an',
				ColumnNames::ACCESSORY_ID => 1,
				ColumnNames::ATTRIBUTE_LIST => '1=1!sep!2=!sep!3=3'));

		$report = new CustomReport($rows, $this->attributeRepository);

		$definition = new ReportDefinition($report, null);

		/** @var $row ReportCell[] */
		$row = $definition->GetRow($rows[0]);

		$this->assertEquals(3, count($row));
		$this->assertEquals('an', $row[0]->Value());
		$this->assertEquals('1', $row[1]->Value());
		$this->assertEquals(null, $row[2]->Value(), 'there is no 3rd attribute in the fake');
	}
}
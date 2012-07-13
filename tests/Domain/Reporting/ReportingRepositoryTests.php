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

class ReportingRepositoryTests extends TestBase
{
	/**
	 * @var ReportingRepository
	 */
	private $repository;

	public function setup()
	{
		parent::setup();

		$this->repository = new ReportingRepository();
	}

	public function testRunsBuiltCommand()
	{
		$builder = new ReportCommandBuilder();
		$expected = $builder->Build();

		$expectedRows = array(array('c' => 'v'));
		$this->db->SetRows($expectedRows);

		$rows = $this->repository->GetCustomReport($builder);

		$this->assertEquals($expected, $this->db->_LastCommand);
		$this->assertEquals($expectedRows, $rows);
	}

	public function testSavesCustomReport()
	{
		$reportName = 'reportName';
		$ownerId = 12;
		$startRange = Date::Parse('2010-01-01', 'America/Chicago');
		$endRange = Date::Parse('2010-01-02', 'America/Chicago');
		$resourceId = 1;
		$scheduleId = 2;
		$userId = 3;
		$groupId = 4;
		$accessoryId = 5;

		$usage = new Report_Usage(Report_Usage::ACCESSORIES);
		$selection = new Report_ResultSelection(Report_ResultSelection::COUNT);
		$groupBy = new Report_GroupBy(Report_GroupBy::RESOURCE);
		$range = new Report_Range(Report_Range::DATE_RANGE, $startRange, $endRange);
		$filter = new Report_Filter($resourceId, $scheduleId, $userId, $groupId, $accessoryId);

		$report = new SavedReport($reportName, $ownerId, $usage, $selection, $groupBy, $range, $filter);

		$this->repository->SaveCustomReport($report);

		$serializedCriteria = "usage=ACCESSORIES;selection=COUNT;groupby=RESOURCE;range=DATE_RANGE;range_start={$startRange->ToDatabase()};range_end={$endRange->ToDatabase()};resourceid=$resourceId;scheduleid=$scheduleId;userid=$userId;groupid=$groupId;accessoryid=$accessoryId";

		$expectedCommand = new AddSavedReportCommand($reportName, $ownerId, $report->DateCreated(), $serializedCriteria);

		$this->assertEquals($expectedCommand, $this->db->_LastCommand);
	}

	public function testLoadsAllReportsForUser()
	{
		$userId = 100;
		$report1 = 'report1';
		$report2 = 'report2';

		$date = Date::Now();

		$expectedReport1 = new SavedReport($report1, $userId,new Report_Usage(Report_Usage::ACCESSORIES),
					new Report_ResultSelection(Report_ResultSelection::COUNT),
					new Report_GroupBy(Report_GroupBy::GROUP),
					new Report_Range(Report_Range::DATE_RANGE, Date::Now(), Date::Now()),
					new Report_Filter(12, 11, 896, 123, 45234) );
		$expectedReport1->WithDateCreated($date);

		$serialized1 = $expectedReport1->Serialize();
		$serialized2 = "corrupted";

		$rows = new SavedReportRow();
		$rows->With($userId, $report1, $date->ToDatabase(), $serialized1)
			->With($userId, $report2, $date->ToDatabase(), $serialized2);

		$this->db->SetRows($rows->Rows());

		$reports = $this->repository->LoadSavedReportsForUser($userId);

		$expectedCommand = new GetAllSavedReportsForUserCommand($userId);
		$this->assertEquals($expectedCommand, $this->db->_LastCommand);
		
		$this->assertEquals(2, count($reports));
		$this->assertEquals($expectedReport1, $reports[0]);
	}
}
?>
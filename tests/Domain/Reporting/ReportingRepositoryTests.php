<?php
/**
Copyright 2012-2016 Nick Korbel

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

		$expectedRows = array(array(ColumnNames::DURATION_ALIAS => 3600));
		$this->db->SetRows($expectedRows);

		$rows = $this->repository->GetCustomReport($builder);

        $expectedRows[0][ColumnNames::DURATION_HOURS] = 1;

		$this->assertEquals($expected, $this->db->_LastCommand);
		$this->assertEquals($expectedRows, $rows);
	}

	public function testSavesCustomReport()
	{
		$reportName = 'reportName';
		$ownerId = 12;
		$startRange = '2010-01-01';
		$endRange = '2010-01-02';
		$timezone = 'America/Chicago';
		$startDate = Date::Parse($startRange, $timezone);
		$endDate = Date::Parse($endRange, $timezone);
		$resourceId = 1;
		$scheduleId = 2;
		$userId = 3;
		$groupId = 4;
		$accessoryId = 5;
		$participantId = 6;

		$usage = new Report_Usage(Report_Usage::ACCESSORIES);
		$selection = new Report_ResultSelection(Report_ResultSelection::COUNT);
		$groupBy = new Report_GroupBy(Report_GroupBy::RESOURCE);
		$range = new Report_Range(Report_Range::DATE_RANGE, $startRange, $endRange, $timezone);
		$filter = new Report_Filter($resourceId, $scheduleId, $userId, $groupId, $accessoryId, $participantId);

		$report = new SavedReport($reportName, $ownerId, $usage, $selection, $groupBy, $range, $filter);

		$this->repository->SaveCustomReport($report);

		$serializedCriteria = "usage=ACCESSORIES;selection=COUNT;groupby=RESOURCE;range=DATE_RANGE;range_start={$startDate->ToDatabase()};range_end={$endDate->ToDatabase()};resourceid=$resourceId;scheduleid=$scheduleId;userid=$userId;groupid=$groupId;accessoryid=$accessoryId;participantid=$participantId";

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
					new Report_Range(Report_Range::DATE_RANGE, Date::Now()->ToUtc(), Date::Now()->ToUtc()),
					new Report_Filter(12, 11, 896, 123, 45234, 111) );
		$expectedReport1->WithDateCreated($date->ToUtc());
		$expectedReport1->WithId(1);

		$serialized1 = ReportSerializer::Serialize($expectedReport1);
		$serialized2 = "corrupted";

		$rows = new SavedReportRow();
		$rows->With($userId, $report1, $date->ToDatabase(), $serialized1, 1)
			->With($userId, $report2, $date->ToDatabase(), $serialized2, 2);

		$this->db->SetRows($rows->Rows());

		$reports = $this->repository->LoadSavedReportsForUser($userId);

		$expectedCommand = new GetAllSavedReportsForUserCommand($userId);
		$this->assertEquals($expectedCommand, $this->db->_LastCommand);

		$this->assertEquals(2, count($reports));
		$this->assertEquals($expectedReport1, $reports[0]);
		$this->assertEquals(new Report_Usage(Report_Usage::RESOURCES), $reports[1]->Usage());
	}

	public function testLoadsSingleReportForUser()
	{
		$userId = 100;
		$reportId = 1;
		$reportName = 'report2';

		$date = Date::Now();

		$expectedReport1 = new SavedReport($reportName, $userId, new Report_Usage(Report_Usage::ACCESSORIES),
					new Report_ResultSelection(Report_ResultSelection::COUNT),
					new Report_GroupBy(Report_GroupBy::GROUP),
					new Report_Range(Report_Range::DATE_RANGE, Date::Now()->ToUtc(), Date::Now()->ToUtc()),
					new Report_Filter(12, 11, 896, 123, 45234, 111) );
		$expectedReport1->WithDateCreated($date->ToUtc());
		$expectedReport1->WithId($reportId);

		$serialized1 = ReportSerializer::Serialize($expectedReport1);

		$rows = new SavedReportRow();
		$rows->With($userId, $reportName, $date->ToDatabase(), $serialized1, $reportId);

		$this->db->SetRows($rows->Rows());

		$report = $this->repository->LoadSavedReportForUser($reportId, $userId);

		$expectedCommand = new GetSavedReportForUserCommand($reportId, $userId);
		$this->assertEquals($expectedCommand, $this->db->_LastCommand);
		$this->assertEquals($expectedReport1, $report);
	}

	public function testDeletesSavedReport()
	{
		$userId = 100;
		$reportId = 1;

		$expectedCommand = new DeleteSavedReportCommand($reportId, $userId);

		$this->repository->DeleteSavedReport($reportId, $userId);

		$this->assertEquals($expectedCommand, $this->db->_LastCommand);
	}
}
?>
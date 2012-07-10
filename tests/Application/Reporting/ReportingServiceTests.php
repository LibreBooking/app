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

require_once(ROOT_DIR . 'lib/Application/Reporting/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

class ReportingServiceTests extends TestBase
{
	/**
	 * @var ReportingService
	 */
	private $rs;

	/**
	 * @var IReportingRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $reportingRepository;

	public function setup()
	{
		parent::setup();

		$this->reportingRepository = $this->getMock('IReportingRepository');

		$this->rs = new ReportingService($this->reportingRepository);
	}

	public function testBuildsCustomResourceReport()
	{
		$start = Date::Parse('2010-01-01');
		$end = Date::Parse('2010-01-02');

		$resourceId = 1;
		$scheduleId = 2;
		$userId = 3;
		$groupId = 4;

		$usage = new Report_Usage(Report_Usage::RESOURCES);
		$selection = new Report_ResultSelection(Report_ResultSelection::FULL_LIST);
		$groupBy = new Report_GroupBy(Report_GroupBy::GROUP);
		$range = new Report_Range(Report_Range::DATE_RANGE, $start, $end);

		$filter = new Report_Filter($resourceId, $scheduleId, $userId, $groupId);

		$commandBuilder = new ReportCommandBuilder();
		$commandBuilder->SelectFullList()
			->OfResources()
			->Within($start, $end)
			->WithResourceId($resourceId)
			->WithUserId($userId)
			->WithScheduleId($scheduleId)
			->WithGroupId($groupId)
			->GroupByGroup();

		$rows = array(array('columname' => 'value'));

		$this->reportingRepository->expects($this->once())
					->method('GetCustomReport')
					->with($this->equalTo($commandBuilder))
					->will($this->returnValue($rows));

		$report = $this->rs->GenerateCustomReport($usage, $selection, $groupBy, $range, $filter);

		$this->assertEquals(ReportColumns::ResourceFullList(), $report->GetColumns());
		$this->assertEquals(new CustomReportData($rows), $report->GetData());
	}
}

?>
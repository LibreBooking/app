<?php
/**
Copyright 2012 Nick Korbel

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

require_once(ROOT_DIR . 'Pages/Reports/GenerateReportPage.php');

class GenerateReportPresenterTests extends TestBase
{
	/**
	 * @var GenerateReportPresenter
	 */
	public $presenter;

	/**
	 * @var FakeGenerateReportPage
	 */
	public $page;

	/**
	 * @var IReportingService|PHPUnit_Framework_MockObject_MockObject
	 */
	public $reportingService;

	public function setup()
	{
		parent::setup();

		$this->page = new FakeGenerateReportPage();
		$this->reportingService = $this->getMock('IReportingService');
		$resourceRepository = $this->getMock('IResourceRepository');
		$scheduleRepository = $this->getMock('IScheduleRepository');
		$groupRepository = $this->getMock('IGroupViewRepository');

		$this->presenter = new GenerateReportPresenter($this->page, $this->fakeUser, $this->reportingService, $resourceRepository, $scheduleRepository, $groupRepository);
	}

	public function testRunsCustomReport()
	{
		$this->SetupPage();

		$expectedStart = $this->page->_RangeStart;
		$expectedEnd = $this->page->_RangeEnd;
		$expectedReport = new FakeReport();

		$usage = new Report_Usage($this->page->_Usage);
		$selection = new Report_ResultSelection($this->page->_ResultSelection);
		$groupBy = new Report_GroupBy($this->page->_GroupBy);
		$range = new Report_Range($this->page->_Range, $expectedStart, $expectedEnd, $this->fakeUser->Timezone);
		$filter = new Report_Filter($this->page->_ResourceId, $this->page->_ScheduleId, $this->page->_UserId, $this->page->_GroupId, $this->page->_AccessoryId);

		$this->reportingService->expects($this->once())
				->method('GenerateCustomReport')
				->with($this->equalTo($usage), $this->equalTo($selection), $this->equalTo($groupBy), $this->equalTo($range), $this->equalTo($filter))
				->will($this->returnValue($expectedReport));

		$this->presenter->GenerateCustomReport();

		$this->assertEquals($expectedReport, $this->page->_BoundReport);
	}

	public function testSavesReport()
	{
		$this->SetupPage();
		$reportName = 'report name';

		$this->page->_ReportName = $reportName;

		$expectedStart = $this->page->_RangeStart;
		$expectedEnd = $this->page->_RangeEnd;

		$usage = new Report_Usage($this->page->_Usage);
		$selection = new Report_ResultSelection($this->page->_ResultSelection);
		$groupBy = new Report_GroupBy($this->page->_GroupBy);
		$range = new Report_Range($this->page->_Range, $expectedStart, $expectedEnd, $this->fakeUser->Timezone);
		$filter = new Report_Filter($this->page->_ResourceId, $this->page->_ScheduleId, $this->page->_UserId, $this->page->_GroupId, $this->page->_AccessoryId);

		$this->reportingService->expects($this->once())
				->method('Save')
				->with($this->equalTo($reportName), $this->equalTo($this->fakeUser->UserId), $this->equalTo($usage), $this->equalTo($selection), $this->equalTo($groupBy), $this->equalTo($range), $this->equalTo($filter));

		$this->presenter->SaveReport();
	}

	private function SetupPage()
	{
		$this->page->_Usage = Report_Usage::ACCESSORIES;
		$this->page->_ResultSelection = Report_ResultSelection::COUNT;
		$this->page->_GroupBy = Report_GroupBy::USER;
		$this->page->_Range = Report_Range::DATE_RANGE;
		$this->page->_RangeStart = '01/01/2001';
		$this->page->_RangeEnd = '02/02/2002';
		$this->page->_ResourceId = 20;
		$this->page->_ScheduleId = 30;
		$this->page->_UserId = 40;
		$this->page->_GroupId = 50;
		$this->page->_AccessoryId = 60;
	}
}

class FakeGenerateReportPage extends GenerateReportPage
{
	/**
	 * @var Report_ResultSelection|string
	 */
	public $_ResultSelection = Report_ResultSelection::FULL_LIST;
	/**
	 * @var Report_GroupBy|string
	 */
	public $_GroupBy = Report_GroupBy::NONE;
	/**
	 * @var Report_Range|string
	 */
	public $_Range = Report_Range::ALL_TIME;
	/**
	 * @var string
	 */
	public $_RangeStart;
	/**
	 * @var string
	 */
	public $_RangeEnd;

	/**
	 * @var int
	 */
	public $_ResourceId;
	/**
	 * @var int
	 */
	public $_ScheduleId;
	/**
	 * @var int
	 */
	public $_UserId;
	/**
	 * @var int
	 */
	public $_GroupId;
	/**
	 * @var int
	 */
	public $_AccessoryId;
	/**
	 * @var IReport
	 */
	public $_BoundReport;
	/**
	 * @var Report_Usage
	 */
	public $_Usage;

	/**
	 * @var string
	 */
	public $_ReportName;
	/**
	 * @var BookableResource[]
	 */
	public $_BoundResources;
	/**
	 * @var AccessoryDto[]
	 */
	public $_BoundAccessories;
	/**
	 * @var Schedule[]
	 */
	public $_BoundSchedules;
	/**
	 * @var bool
	 */
	public $_ErrorDisplayed;
	/**
	 * @var bool
	 */
	public $_ResultsShown;
	/**
	 * @var bool
	 */
	public $_ReportPrinted;
	/**
	 * @var bool
	 */
	public $_CsvShown;

	public function GetResultSelection()
	{
		return $this->_ResultSelection;
	}

	public function GetGroupBy()
	{
		return $this->_GroupBy;
	}

	public function GetRange()
	{
		return $this->_Range;
	}

	public function GetStart()
	{
		return $this->_RangeStart;
	}

	public function GetEnd()
	{
		return $this->_RangeEnd;
	}

	public function GetResourceId()
	{
		return $this->_ResourceId;
	}

	public function GetScheduleId()
	{
		return $this->_ScheduleId;
	}

	public function GetUserId()
	{
		return $this->_UserId;
	}

	public function GetGroupId()
	{
		return $this->_GroupId;
	}

	public function BindReport(IReport $report, IReportDefinition $definition)
	{
		$this->_BoundReport = $report;
	}

	public function GetUsage()
	{
		return $this->_Usage;
	}

	public function GetAccessoryId()
	{
		return $this->_AccessoryId;
	}

	public function GetReportName()
	{
		return $this->_ReportName;
	}

	public function BindResources($resources)
	{
		$this->_BoundResources = $resources;
	}

	public function BindAccessories($accessories)
	{
		$this->_BoundAccessories = $accessories;
	}

	public function BindSchedules($schedules)
	{
		$this->_BoundSchedules = $schedules;
	}

	public function DisplayError()
	{
		$this->_ErrorDisplayed = true;
	}

	public function ShowResults()
	{
		$this->_ResultsShown = true;
	}

	public function PrintReport()
	{
		$this->_ReportPrinted = true;
	}

	public function ShowCsv()
	{
		$this->_CsvShown = true;
	}

}

?>
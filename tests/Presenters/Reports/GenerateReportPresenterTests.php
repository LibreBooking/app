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

		$this->presenter = new GenerateReportPresenter($this->page, $this->fakeUser, $this->reportingService);
	}

	public function testRunsCustomReport()
	{
		$startDate = '01/01/2001';
		$endDate = '02/02/2002';

		$expectedStart = Date::Parse($startDate, $this->fakeUser->Timezone);
		$expectedEnd = Date::Parse($endDate, $this->fakeUser->Timezone);
		$resourceId = 20;
		$scheduleId = 30;
		$userId = 40;
		$groupId = 50;

		$this->page->_Usage = Report_Usage::ACCESSORIES;
		$this->page->_ResultSelection = Report_ResultSelection::COUNT;
		$this->page->_GroupBy = Report_GroupBy::USER;
		$this->page->_Range = Report_Range::DATE_RANGE;
		$this->page->_RangeStart = $startDate;
		$this->page->_RangeEnd = $endDate;
		$this->page->_ResourceId = $resourceId;
		$this->page->_ScheduleId = $scheduleId;
		$this->page->_UserId = $userId;
		$this->page->_GroupId = $groupId;

		$expectedReport = $this->getMock('IReport');

		$usage = new Report_Usage($this->page->_Usage);
		$selection = new Report_ResultSelection($this->page->_ResultSelection);
		$groupBy = new Report_GroupBy($this->page->_GroupBy);
		$range = new Report_Range($this->page->_Range, $expectedStart, $expectedEnd);
		$filter = new Report_Filter($resourceId, $scheduleId, $userId, $groupId);

		$this->reportingService->expects($this->once())
					->method('GenerateCustomReport')
					->with($this->equalTo($usage), $this->equalTo($selection), $this->equalTo($groupBy), $this->equalTo($range), $this->equalTo($filter))
					->will($this->returnValue($expectedReport));

		$this->presenter->GenerateCustomReport();

		$this->assertEquals($expectedReport, $this->page->_BoundReport);
	}
}

class FakeGenerateReportPage implements IGenerateReportPage
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
	 * @var IReport
	 */
	public $_BoundReport;

	/**
	 * @var Report_Usage
	 */
	public $_Usage;

	/**
	 * @return string|Report_ResultSelection
	 */
	public function GetResultSelection()
	{
		return $this->_ResultSelection;
	}

	/**
	 * @return string|Report_GroupBy
	 */
	public function GetGroupBy()
	{
		return $this->_GroupBy;
	}

	/**
	 * @return string|Report_Range
	 */
	public function GetRange()
	{
		return $this->_Range;
	}

	/**
	 * @return string
	 */
	public function GetStart()
	{
		return $this->_RangeStart;
	}

	/**
	 * @return string
	 */
	public function GetEnd()
	{
		return $this->_RangeEnd;
	}

	/**
	 * @return int
	 */
	public function GetResourceId()
	{
		return $this->_ResourceId;
	}

	/**
	 * @return int
	 */
	public function GetScheduleId()
	{
		return $this->_ScheduleId;
	}

	/**
	 * @return int
	 */
	public function GetUserId()
	{
		return $this->_UserId;
	}

	/**
	 * @return int
	 */
	public function GetGroupId()
	{
		return $this->_GroupId;
	}

	public function BindReport(IReport $report)
	{
		$this->_BoundReport = $report;
	}

	/**
	 * @return string|Report_Usage
	 */
	public function GetUsage()
	{
		return $this->_Usage;
	}
}

?>
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

require_once(ROOT_DIR . 'Presenters/Reports/SavedReportsPresenter.php');

class SavedReportsPresenterTests extends TestBase
{
	/**
	 * @var SavedReportsPresenter
	 */
	public $presenter;

	/**
	 * @var FakeSavedReportsPage
	 */
	public $page;

	/**
	 * @var IReportingService|PHPUnit_Framework_MockObject_MockObject
	 */
	public $service;

	public function setup()
	{
		parent::setup();

		$this->page = new FakeSavedReportsPage();
		$this->service = $this->getMock('IReportingService');

		$this->presenter = new SavedReportsPresenter($this->page, $this->fakeUser, $this->service);
	}

	public function testGetsAllSavedReportsForTheUser()
	{
		$savedReports = array(new FakeSavedReport());

		$this->service->expects($this->once())
				->method('GetSavedReports')
				->with($this->equalTo($this->fakeUser->UserId))
				->will($this->returnValue($savedReports));

		$this->presenter->PageLoad();

		$this->assertEquals($savedReports, $this->page->_BoundReportList);
	}

	public function testRunsSavedReport()
	{
		$reportId = 100;
		$this->page->_ReportId = $reportId;
		$savedReport = new FakeSavedReport();
		$report = new FakeReport();

		$this->service->expects($this->once())
				->method('GetSavedReport')
				->with($this->equalTo($reportId), $this->equalTo($this->fakeUser->UserId))
				->will($this->returnValue($savedReport));

		$this->service->expects($this->once())
				->method('GenerateCustomReport')
				->with($this->equalTo($savedReport->Usage()),
					   $this->equalTo($savedReport->Selection()),
					   $this->equalTo($savedReport->GroupBy()),
					   $this->equalTo($savedReport->Range()),
					   $this->equalTo($savedReport->Filter()))
				->will($this->returnValue($report));

		$this->presenter->GenerateReport();

		$this->assertEquals($report, $this->page->_BoundReport);
		$this->assertEquals(new ReportDefinition($report, $this->fakeUser->Timezone), $this->page->_BoundDefinition);
		$this->assertTrue($this->page->_ResultsDisplayed);
	}
	
	public function testWhenReportIsNotFound()
	{
		$this->service->expects($this->once())
						->method('GetSavedReport')
						->with($this->anything(), $this->anything())
						->will($this->returnValue(null));

		$this->presenter->GenerateReport();

		$this->assertTrue($this->page->_ErrorDisplayed);
	}
}

class FakeSavedReportsPage extends SavedReportsPage
{
	/**
	 * @var SavedReport[]
	 */
	public $_BoundReportList;
	/**
	 * @var int
	 */
	public $_ReportId;
	/**
	 * @var
	 */
	public $_BoundReport;
	/**
	 * @var
	 */
	public $_BoundDefinition;
	/**
	 * @var bool
	 */
	public $_ErrorDisplayed = false;
	/**
	 * @var bool
	 */
	public $_ResultsDisplayed = false;

	public function BindReportList($reportList)
	{
		$this->_BoundReportList = $reportList;
	}

	public function BindReport(IReport $report, IReportDefinition $definition)
	{
		$this->_BoundReport = $report;
		$this->_BoundDefinition = $definition;
	}

	public function DisplayError()
	{
		$this->_ErrorDisplayed = true;
	}

	public function ShowResults()
	{
		$this->_ResultsDisplayed = true;
	}

	public function GetReportId()
	{
		return $this->_ReportId;
	}

}

?>
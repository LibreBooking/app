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
}

class FakeSavedReportsPage extends SavedReportsPage
{
	/**
	 * @var SavedReport[]
	 */
	public $_BoundReportList;

	public function BindReportList($reportList)
	{
		$this->_BoundReportList = $reportList;
	}
}
?>
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

require_once(ROOT_DIR . 'Presenters/CalendarExportPresenter.php');

class CalendarExportPresenterTests extends TestBase
{
	/**
	 * @var IReservationViewRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $repo;

	/**
	 * @var ICalendarExportPage|PHPUnit_Framework_MockObject_MockObject
	 */
	private $page;

	/**
	 * @var CalendarExportPresenter
	 */
	private $presenter;

	public function setup()
	{
		parent::setup();

		$this->repo = $this->getMock('IReservationViewRepository');
		$this->page = $this->getMock('ICalendarExportPage');

		$this->presenter = new CalendarExportPresenter($this->page, $this->repo);
	}

	public function testLoadsReservationByReferenceNumber()
	{
		$referenceNumber = 'ref';
		$results = array(new TestReservationItemView(1, Date::Now(), Date::Now()));

		$reservationResult = new PageableData($results, 200, 1, 200);

		$filter = new SqlFilterGreaterThan(ColumnNames::RESERVATION_START, Date::Now()->AddDays(-7)->ToDatabase());
		$filter->_And(new SqlFilterEquals(ColumnNames::REFERENCE_NUMBER, $referenceNumber));

		$this->page->expects($this->once())
				->method('GetReferenceNumber')
				->will($this->returnValue($referenceNumber));

		$this->repo->expects($this->once())
				->method('GetList')
				->with($this->equalTo(1), $this->equalTo(200), $this->isNull(), $this->isNull(), $this->equalTo($filter))
				->will($this->returnValue($reservationResult));

		$this->page->expects($this->once())
						->method('SetReservations')
						->with($this->arrayHasKey(0));

		$this->presenter->PageLoad();
	}
}

?>
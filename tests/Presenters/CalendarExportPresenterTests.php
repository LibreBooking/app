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

    /**
     * @var ICalendarExportValidator|PHPUnit_Framework_MockObject_MockObject
     */
    private $validator;

    public function setup()
    {
        parent::setup();

        $this->repo = $this->getMock('IReservationViewRepository');
        $this->page = $this->getMock('ICalendarExportPage');
        $this->validator = $this->getMock('ICalendarExportValidator');

        $this->validator->expects($this->atLeastOnce())
            ->method('IsValid')
            ->will($this->returnValue(true));

        $this->presenter = new CalendarExportPresenter($this->page, $this->repo, $this->validator);
    }

    public function testLoadsReservationByReferenceNumber()
    {
        $referenceNumber = 'ref';
        $reservationResult = new ReservationView();

        $this->page->expects($this->once())
                ->method('GetReferenceNumber')
                ->will($this->returnValue($referenceNumber));

        $this->repo->expects($this->once())
                ->method('GetReservationForEditing')
                ->with($this->equalTo($referenceNumber))
                ->will($this->returnValue($reservationResult));

        $this->page->expects($this->once())
                ->method('SetReservations')
                ->with($this->arrayHasKey(0));

        $this->presenter->PageLoad();
    }

    public function testGetsScheduleReservationsForTheNextYearByScheduleId()
    {
        $scheduleId = '1';
        $reservationResult = array(new TestReservationItemView(1, Date::Now(), Date::Now()));

        $weekAgo = Date::Now()->AddDays(-7);
        $nextYear = Date::Now()->AddDays(365);

        $this->page->expects($this->once())
                ->method('GetScheduleId')
                ->will($this->returnValue($scheduleId));

        $this->repo->expects($this->once())
                ->method('GetReservationList')
                ->with($this->equalTo($weekAgo), $this->equalTo($nextYear), $this->isNull(), $this->isNull(), $scheduleId, $this->isNull())
                ->will($this->returnValue($reservationResult));

        $this->page->expects($this->once())
                ->method('SetReservations')
                ->with($this->arrayHasKey(0));

        $this->presenter->PageLoad();
    }

    public function testGetsScheduleReservationsForTheNextYearByResourceId()
    {
        $resourceId = '1';
        $reservationResult = array(new TestReservationItemView(1, Date::Now(), Date::Now()));

        $weekAgo = Date::Now()->AddDays(-7);
        $nextYear = Date::Now()->AddDays(365);

        $this->page->expects($this->once())
                ->method('GetResourceId')
                ->will($this->returnValue($resourceId));

        $this->repo->expects($this->once())
                ->method('GetReservationList')
                ->with($this->equalTo($weekAgo), $this->equalTo($nextYear), $this->isNull(), $this->isNull(), $this->isNull(), $resourceId)
                ->will($this->returnValue($reservationResult));

        $this->page->expects($this->once())
                ->method('SetReservations')
                ->with($this->arrayHasKey(0));

        $this->presenter->PageLoad();
    }

	public function testOnlyAddsTheFirstReservationOfARepeatedSeries()
    {
        $resourceId = '1';
		$r1 = new TestReservationItemView(1, Date::Now(), Date::Now());
		$r1->WithSeriesId(10);

		$r2 = new TestReservationItemView(2, Date::Now(), Date::Now());
		$r2->WithSeriesId(10);

		$r3 = new TestReservationItemView(2, Date::Now(), Date::Now());
		$r3->WithSeriesId(10);
        $reservationResult = array($r1, $r2, $r3);

        $weekAgo = Date::Now()->AddDays(-7);
        $nextYear = Date::Now()->AddDays(365);

        $this->page->expects($this->once())
                ->method('GetResourceId')
                ->will($this->returnValue($resourceId));

        $this->repo->expects($this->once())
                ->method('GetReservationList')
                ->with($this->equalTo($weekAgo), $this->equalTo($nextYear), $this->isNull(), $this->isNull(), $this->isNull(), $resourceId)
                ->will($this->returnValue($reservationResult));

        $this->page->expects($this->once())
                ->method('SetReservations')
                ->with($this->equalTo(array(new iCalendarReservationView($r1))));

        $this->presenter->PageLoad();
    }
}

?>
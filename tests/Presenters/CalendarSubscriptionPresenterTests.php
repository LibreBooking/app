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

require_once(ROOT_DIR . 'Presenters/CalendarSubscriptionPresenter.php');

class CalendarSubscriptionPresenterTests extends TestBase
{
	/**
	 * @var IReservationViewRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $repo;

	/**
	 * @var ICalendarSubscriptionPage|PHPUnit_Framework_MockObject_MockObject
	 */
	private $page;

	/**
	 * @var CalendarSubscriptionPresenter
	 */
	private $presenter;

	/**
	 * @var ICalendarExportValidator|PHPUnit_Framework_MockObject_MockObject
	 */
	private $validator;

	/**
	 * @var ICalendarSubscriptionService|PHPUnit_Framework_MockObject_MockObject
	 */
	private $service;

	public function setup()
	{
		parent::setup();

		$this->repo = $this->getMock('IReservationViewRepository');
		$this->page = $this->getMock('ICalendarSubscriptionPage');
		$this->validator = $this->getMock('ICalendarExportValidator');
		$this->service = $this->getMock('ICalendarSubscriptionService');

		$this->validator->expects($this->atLeastOnce())
				->method('IsValid')
				->will($this->returnValue(true));

		$this->presenter = new CalendarSubscriptionPresenter($this->page, $this->repo, $this->validator, $this->service);
	}

	public function testGetsScheduleReservationsForTheNextYearByScheduleId()
	{
		$publicId = '1';
		$reservationResult = array(new TestReservationItemView(1, Date::Now(), Date::Now()));

		$scheduleId = 999;
		$schedule = new FakeSchedule($scheduleId);

		$weekAgo = Date::Now()->AddDays(-7);
		$nextYear = Date::Now()->AddDays(365);

		$this->page->expects($this->once())
				->method('GetScheduleId')
				->will($this->returnValue($publicId));

		$this->service->expects($this->once())
				->method('GetSchedule')
				->with($this->equalTo($publicId))
				->will($this->returnValue($schedule));

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
		$publicId = '1';
		$reservationResult = array(new TestReservationItemView(1, Date::Now(), Date::Now()));

		$resourceId = 999;
		$resource = new FakeBookableResource($resourceId);

		$weekAgo = Date::Now()->AddDays(-7);
		$nextYear = Date::Now()->AddDays(365);

		$this->page->expects($this->once())
				->method('GetResourceId')
				->will($this->returnValue($publicId));

		$this->service->expects($this->once())
				->method('GetResource')
				->with($this->equalTo($publicId))
				->will($this->returnValue($resource));

		$this->repo->expects($this->once())
				->method('GetReservationList')
				->with($this->equalTo($weekAgo), $this->equalTo($nextYear), $this->isNull(), $this->isNull(), $this->isNull(), $resourceId)
				->will($this->returnValue($reservationResult));

		$this->page->expects($this->once())
				->method('SetReservations')
				->with($this->arrayHasKey(0));

		$this->presenter->PageLoad();
	}

	public function testGetsUserReservationsForTheNextYearByResourceId()
	{
		$publicId = '1';
		$reservationResult = array(new TestReservationItemView(1, Date::Now(), Date::Now()));

		$userId = 999;
		$user = new FakeUser($userId);

		$weekAgo = Date::Now()->AddDays(-7);
		$nextYear = Date::Now()->AddDays(365);

		$this->page->expects($this->once())
				->method('GetUserId')
				->will($this->returnValue($publicId));

		$this->service->expects($this->once())
				->method('GetUser')
				->with($this->equalTo($publicId))
				->will($this->returnValue($user));

		$this->repo->expects($this->once())
				->method('GetReservationList')
				->with($this->equalTo($weekAgo), $this->equalTo($nextYear), $userId, $this->isNull(), $this->isNull(), $this->isNull())
				->will($this->returnValue($reservationResult));

		$this->page->expects($this->once())
				->method('SetReservations')
				->with($this->arrayHasKey(0));

		$this->presenter->PageLoad();
	}

	public function testOnlyAddsTheFirstReservationOfARepeatedSeries()
	{
		$r1 = new TestReservationItemView(1, Date::Now(), Date::Now());
		$r1->WithSeriesId(10);

		$r2 = new TestReservationItemView(2, Date::Now(), Date::Now());
		$r2->WithSeriesId(10);

		$r3 = new TestReservationItemView(2, Date::Now(), Date::Now());
		$r3->WithSeriesId(10);
		$reservationResult = array($r1, $r2, $r3);

		$publicId = '1';
		$resourceId = 999;
		$resource = new FakeBookableResource($resourceId);

		$weekAgo = Date::Now()->AddDays(-7);
		$nextYear = Date::Now()->AddDays(365);

		$this->page->expects($this->once())
				->method('GetResourceId')
				->will($this->returnValue($publicId));

		$this->service->expects($this->once())
				->method('GetResource')
				->with($this->equalTo($publicId))
				->will($this->returnValue($resource));

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
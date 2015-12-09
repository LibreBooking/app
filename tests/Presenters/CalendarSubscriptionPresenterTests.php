<?php
/**
Copyright 2012-2015 Nick Korbel

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

require_once(ROOT_DIR . 'Pages/Export/CalendarSubscriptionPage.php');
require_once(ROOT_DIR . 'Presenters/CalendarSubscriptionPresenter.php');

class CalendarSubscriptionPresenterTests extends TestBase
{
	/**
	 * @var IReservationViewRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $repo;

	/**
	 * @var FakeCalendarSubscriptionPage
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

	/**
	 * @var FakePrivacyFilter
	 */
	private $privacyFilter;

	public function setup()
	{
		parent::setup();

		$this->repo = $this->getMock('IReservationViewRepository');
		$this->page = new FakeCalendarSubscriptionPage();//$this->getMock('ICalendarSubscriptionPage');
		$this->validator = $this->getMock('ICalendarExportValidator');
		$this->service = $this->getMock('ICalendarSubscriptionService');
		$this->privacyFilter = new FakePrivacyFilter();

		$this->validator->expects($this->atLeastOnce())
				->method('IsValid')
				->will($this->returnValue(true));

		$this->presenter = new CalendarSubscriptionPresenter(
			$this->page,
			$this->repo,
			$this->validator,
			$this->service,
			$this->privacyFilter);
	}

	public function testGetsScheduleReservationsForTheNextYearByScheduleId()
	{
		$publicId = '1';
		$reservationResult = array(new TestReservationItemView(1, Date::Now(), Date::Now()));

		$scheduleId = 999;
		$schedule = new FakeSchedule($scheduleId);

		$weekAgo = Date::Now()->AddDays(-7);
		$nextYear = Date::Now()->AddDays(365);

		$this->page->ScheduleId = $publicId;

		$this->service->expects($this->once())
				->method('GetSchedule')
				->with($this->equalTo($publicId))
				->will($this->returnValue($schedule));

		$this->repo->expects($this->once())
				->method('GetReservationList')
				->with($this->equalTo($weekAgo), $this->equalTo($nextYear), $this->isNull(), ReservationUserLevel::OWNER, $scheduleId, $this->isNull())
				->will($this->returnValue($reservationResult));

		$this->presenter->PageLoad();

		$this->assertCount(1, $this->page->Reservations);
	}

	public function testGetsScheduleReservationsForTheNextYearByResourceId()
	{
		$publicId = '1';
		$reservationResult = array(new TestReservationItemView(1, Date::Now(), Date::Now()));

		$resourceId = 999;
		$resource = new FakeBookableResource($resourceId);

		$weekAgo = Date::Now()->AddDays(-7);
		$nextYear = Date::Now()->AddDays(365);

		$this->page->ResourceId = $publicId;

		$this->service->expects($this->once())
				->method('GetResource')
				->with($this->equalTo($publicId))
				->will($this->returnValue($resource));

		$this->repo->expects($this->once())
				->method('GetReservationList')
				->with($this->equalTo($weekAgo), $this->equalTo($nextYear), $this->isNull(), ReservationUserLevel::OWNER, $this->isNull(), $resourceId)
				->will($this->returnValue($reservationResult));

		$this->presenter->PageLoad();

		$this->assertCount(1, $this->page->Reservations);
	}

	public function testGetsUserReservationsForTheNextYearByResourceId()
	{
		$publicId = '1';
		$reservationResult = array(new TestReservationItemView(1, Date::Now(), Date::Now()));

		$userId = 999;
		$user = new FakeUser($userId);

		$weekAgo = Date::Now()->AddDays(-7);
		$nextYear = Date::Now()->AddDays(365);

		$this->page->UserId = $publicId;

		$this->service->expects($this->once())
				->method('GetUser')
				->with($this->equalTo($publicId))
				->will($this->returnValue($user));

		$this->repo->expects($this->once())
				->method('GetReservationList')
				->with($this->equalTo($weekAgo), $this->equalTo($nextYear), $this->equalTo($userId), ReservationUserLevel::ALL, $this->isNull(), $this->isNull())
				->will($this->returnValue($reservationResult));

		$this->presenter->PageLoad();

		$this->assertCount(1, $this->page->Reservations);
	}

	public function testGetsResourceGroupReservationsForTheNextYearByGroupId()
	{
		$publicId = '1';
		$reservationResult = array(
				new TestReservationItemView(1, Date::Now(), Date::Now(), 1),
				new TestReservationItemView(2, Date::Now(), Date::Now(), 2),
		);

		$resourceIds = array(2);

		$weekAgo = Date::Now()->AddDays(-7);
		$nextYear = Date::Now()->AddDays(365);

		$this->page->ResourceGroupId = $publicId;

		$this->service->expects($this->once())
				->method('GetResourcesInGroup')
				->with($this->equalTo($publicId))
				->will($this->returnValue($resourceIds));

		$this->repo->expects($this->once())
				->method('GetReservationList')
				->with($this->equalTo($weekAgo), $this->equalTo($nextYear), $this->isNull(), ReservationUserLevel::OWNER, $this->isNull(), $this->isNull())
				->will($this->returnValue($reservationResult));

		$this->presenter->PageLoad();

		$this->assertCount(1, $this->page->Reservations);
	}
}

class FakeCalendarSubscriptionPage implements ICalendarSubscriptionPage
{
	public $ScheduleId;
	public $ResourceId;
	public $ResourceGroupId;

	/**
	 * @vari CalendarReservationView[]
	 */
	public $Reservations;

	public $UserId;

	public $SubscriptionKey = "123";

	public function GetSubscriptionKey()
	{
		return $this->SubscriptionKey;
	}

	public function GetUserId()
	{
		return $this->UserId;
	}

	public function SetReservations($reservations)
	{
		$this->Reservations = $reservations;
	}

	public function GetScheduleId()
	{
		return $this->ScheduleId;
	}

	public function GetResourceId()
	{
		return $this->ResourceId;
	}

	public function GetResourceGroupId()
	{
		return $this->ResourceGroupId;
	}

	public function GetAccessoryIds()
	{
		// TODO: Implement GetAccessoryIds() method.
	}
}
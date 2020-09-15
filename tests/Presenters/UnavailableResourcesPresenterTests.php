<?php
/**
 * Copyright 2017-2020 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Pages/Ajax/UnavailableResourcesPage.php');
require_once(ROOT_DIR . 'Presenters/UnavailableResourcesPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/ResourceAvailability.php');

class UnavailableResourcesPresenterTests extends TestBase
{
	/**
	 * @var FakeResourceAvailabilityStrategy
	 */
	private $resourceAvailability;

	/**
	 * @var FakeAvailableResourcesPage
	 */
	private $page;

	/**
	 * @var UnavailableResourcesPresenter
	 */
	private $presenter;
	/**
	 * @var FakeResourceRepository
	 */
	private $resourceRepository;

	public function setUp(): void
	{
		parent::setup();

		$this->resourceAvailability = new FakeResourceAvailabilityStrategy();
		$this->page = new FakeAvailableResourcesPage($this->fakeUser);
		$this->resourceRepository = new FakeResourceRepository();
		$this->resourceRepository->_ResourceList = array(
				new FakeBookableResource(1),
				new FakeBookableResource(2),
				new FakeBookableResource(3),
				new FakeBookableResource(4),
				new FakeBookableResource(5),
		);

		$this->presenter = new UnavailableResourcesPresenter($this->page, $this->resourceAvailability, $this->fakeUser, $this->resourceRepository);
	}

	public function testGetsUnavailableResourceIdsWhenNotTheSameReservation()
	{
		$available1 = 1;
		$available2 = 2;
		$unavailable = 3;
		$duration = $this->page->GetDuration();

		$this->resourceAvailability->_ReservedItems = array(
				new TestReservationItemView(1, $duration->GetBegin()->AddDays(-1), $duration->GetBegin(), $available1, 'available1'),
				new TestReservationItemView(2, $duration->GetEnd(), $duration->GetEnd()->AddDays(1), $available2, 'available2'),
				new TestReservationItemView(3, $duration->GetBegin(), $duration->GetEnd(), $unavailable, 'conflict'),
				new TestReservationItemView(4, $duration->GetBegin(), $duration->GetEnd(), $unavailable, 'conflict2'),
		);

		$this->presenter->PageLoad();

		$bound = $this->page->_BoundAvailability;

		$this->assertEquals(array($unavailable), $bound);
	}

	public function testGetsUnavailableResourceIdsWhenTheSameReservation()
	{
		$available1 = 1;
		$unavailable = 3;
		$duration = $this->page->GetDuration();
		$this->page->_ReferenceNumber = 'same';

		$this->resourceAvailability->_ReservedItems = array(
				new TestReservationItemView(1, $duration->GetBegin(), $duration->GetEnd(), $available1, $this->page->_ReferenceNumber),
				new TestReservationItemView(2, $duration->GetEnd(), $duration->GetEnd()->AddDays(1), $unavailable, 'available2'),
				new TestReservationItemView(3, $duration->GetBegin(), $duration->GetEnd(), $unavailable, 'conflict'),
		);

		$this->presenter->PageLoad();

		$bound = $this->page->_BoundAvailability;

		$this->assertEquals(array($unavailable), $bound);
	}

	public function testWhenRequestedDurationSpansMultipleDays()
	{
		$available1 = 1;
		$unavailable1 = 2;
		$unavailable2 = 3;
		$unavailable3 = 4;
		$unavailable4 = 5;
		$tz = $this->fakeUser->Timezone;
		$this->page->_StartDate = '2017-05-01';
		$this->page->_StartTime = '06:00';
		$this->page->_EndDate = '2017-05-03';
		$this->page->_EndTime = '10:00';

		$this->resourceAvailability->_ReservedItems = array(
				new TestReservationItemView(1, Date::Parse('2017-05-01 05:00', $tz), Date::Parse('2017-05-01 06:00', $tz), $available1, 'available'),
				new TestReservationItemView(2, Date::Parse('2017-05-01 05:00', $tz), Date::Parse('2017-05-01 08:00', $tz), $unavailable1, 'conflict1'),
				new TestReservationItemView(3, Date::Parse('2017-05-03 09:00', $tz), Date::Parse('2017-05-03 11:00', $tz), $unavailable2, 'conflict2'),
				new TestReservationItemView(4, Date::Parse('2017-05-01 05:00', $tz), Date::Parse('2017-05-03 11:00', $tz), $unavailable3, 'conflict3'),
				new TestReservationItemView(5, Date::Parse('2017-05-02 09:00', $tz), Date::Parse('2017-05-02 11:00', $tz), $unavailable4, 'conflict4'),
		);

		$this->presenter->PageLoad();

		$bound = $this->page->_BoundAvailability;

		$this->assertEquals(array($unavailable1, $unavailable2, $unavailable3, $unavailable4), $bound);
	}

	public function testWhenResourceAllowsConcurrent()
	{
		$resource = new FakeBookableResource(1);
		$resource->SetMaxConcurrentReservations(3);
		$this->resourceRepository->_ResourceList = array($resource);

		$unavailable = 1;
		$duration = $this->page->GetDuration();

		$r1 = new TestReservationItemView(3, $duration->GetBegin(), $duration->GetEnd(), $unavailable, 'conflict');
		$r2 = new TestReservationItemView(4, $duration->GetBegin(), $duration->GetEnd(), $unavailable, 'conflict2');

		$this->resourceAvailability->_ReservedItems = array($r1, $r2,);

		$this->presenter->PageLoad();

		$bound = $this->page->_BoundAvailability;

		$this->assertEquals(array(), $bound);
	}

	public function testUsesMaxBufferForFindingReservations()
	{
		$thirtyMinutes = new FakeBookableResource(1);
		$ninetyMinutes = new FakeBookableResource(1);
		$thirtyMinutes->SetBufferTime(30 * 60);
		$ninetyMinutes->SetBufferTime(90 * 60);

		$this->resourceRepository->_ResourceList = array(
				$thirtyMinutes,
				$ninetyMinutes,
		);
		$duration = $this->page->GetDuration();

		$this->presenter->PageLoad();

		$this->assertEquals($duration->GetBegin()->AddMinutes(-90), $this->resourceAvailability->_Start);
		$this->assertEquals($duration->GetEnd()->AddMinutes(90), $this->resourceAvailability->_End);
	}
}

class FakeAvailableResourcesPage implements IAvailableResourcesPage
{
	public $_StartDate;
	public $_EndDate;
	public $_StartTime;
	public $_EndTime;
	public $_ReferenceNumber;
	public $_BoundAvailability;
	public $_User;

	public function __construct(UserSession $user)
	{
		$this->_StartDate = '2016-11-23';
		$this->_EndDate = '2016-11-24';
		$this->_StartTime = '08:30';
		$this->_EndTime = '17:30';
		$this->_User = $user;
	}

	public function GetDuration()
	{
		return DateRange::Create($this->_StartDate . ' ' . $this->_StartTime, $this->_EndDate . ' ' . $this->_EndTime, $this->_User->Timezone);
	}

	public function GetStartDate()
	{
		return $this->_StartDate;
	}

	public function GetEndDate()
	{
		return $this->_EndDate;
	}

	public function GetReferenceNumber()
	{
		return $this->_ReferenceNumber;
	}

	public function GetStartTime()
	{
		return $this->_StartTime;
	}

	public function GetEndTime()
	{
		return $this->_EndTime;
	}

	public function BindUnavailable($unavailableResourceIds)
	{
		$this->_BoundAvailability = $unavailableResourceIds;
	}
}

<?php
/**
 * Copyright 2017 Nick Korbel
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

require_once(ROOT_DIR . 'Pages/Ajax/AvailableAccessoriesPage.php');
require_once(ROOT_DIR . 'Presenters/AvailableAccessoriesPresenter.php');

class AvailableAccessoriesPresenterTests extends TestBase
{
	/**
	 * @var FakeAccessoryRepository
	 */
	private $accessoryRepo;

	/**
	 * @var FakeAvailableAccessoriesPage
	 */
	private $page;

	/**
	 * @var FakeReservationViewRepository
	 */
	private $reservationRepo;

	/**
	 * @var AvailableAccessoriesPresenter
	 */
	private $presenter;

	public function setup()
	{
		parent::setup();

		$this->accessoryRepo = new FakeAccessoryRepository();
		$this->reservationRepo = new FakeReservationViewRepository();
		$this->page = new FakeAvailableAccessoriesPage();

		$this->presenter = new AvailableAccessoriesPresenter($this->page, $this->accessoryRepo, $this->reservationRepo, $this->fakeUser);
	}
	
	public function testGetsAvailableQuantityWhenNotTheSameReservation()
	{
		$duration = $this->page->GetDuration();
		$this->accessoryRepo->_AllAccessories = array( new Accessory(1, '', 10), new Accessory(2, '', 4), new Accessory(3, '', null) );

		$this->reservationRepo->_AccessoryReservations = array(
				new AccessoryReservation('r1', $duration->GetBegin(), $duration->GetEnd(), 1, 2),
				new AccessoryReservation('r1', $duration->GetBegin(), $duration->GetEnd(), 2, 2),
				new AccessoryReservation('r2', $duration->GetBegin(), $duration->GetEnd(), 1, 2),
				new AccessoryReservation('r2', $duration->GetBegin(), $duration->GetEnd(), 2, 2),
				new AccessoryReservation('r3', $duration->GetBegin(), $duration->GetEnd(), 3, 2),
		);

		$this->presenter->PageLoad();

		$bound = $this->page->_BoundAvailability;

		$this->assertEquals(array(new AccessoryAvailability(1, 6), new AccessoryAvailability(2, 0), new AccessoryAvailability(3, null)), $bound);
	}

	public function testGetsAvailableQuantityWhenTheSameReservation()
	{
		$duration = $this->page->GetDuration();
		$this->accessoryRepo->_AllAccessories = array( new Accessory(1, '', 10), new Accessory(2, '', 4), new Accessory(3, '', null) );

		$this->reservationRepo->_AccessoryReservations = array(
				new AccessoryReservation('r1', $duration->GetBegin(), $duration->GetEnd(), 1, 2),
				new AccessoryReservation('r1', $duration->GetBegin(), $duration->GetEnd(), 2, 2),
				new AccessoryReservation('r2', $duration->GetBegin(), $duration->GetEnd(), 1, 2),
				new AccessoryReservation('r2', $duration->GetBegin(), $duration->GetEnd(), 2, 2),
				new AccessoryReservation('r3', $duration->GetBegin(), $duration->GetEnd(), 3, 2),
		);

		$this->page->_ReferenceNumber = 'r2';
		$this->presenter->PageLoad();

		$bound = $this->page->_BoundAvailability;

		$this->assertEquals(array(new AccessoryAvailability(1, 8), new AccessoryAvailability(2, 2), new AccessoryAvailability(3, null)), $bound);
	}
}

class FakeAvailableAccessoriesPage implements IAvailableAccessoriesPage
{
	public $_StartDate;
	public $_EndDate;
	public $_StartTime;
	public $_EndTime;
	public $_ReferenceNumber;
	public $_BoundAvailability;

	public function __construct()
	{
		$this->_StartDate = '2016-11-23';
		$this->_EndDate = '2016-11-24';
		$this->_StartTime = '08:30';
		$this->_EndTime = '17:30';
	}

	public function GetDuration()
	{
		return DateRange::Create($this->_StartDate . ' ' . $this->_StartTime, $this->_EndDate . ' ' . $this->_EndTime, 'UTC');
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

	public function BindAvailability($realAvailability)
	{
		$this->_BoundAvailability = $realAvailability;
	}
}

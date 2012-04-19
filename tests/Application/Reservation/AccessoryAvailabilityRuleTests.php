<?php
/**
Copyright 2011-2012 Nick Korbel

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

require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/namespace.php');
require_once(ROOT_DIR . 'tests/Domain/Reservation/TestReservationSeries.php');

class AccessoryAvailabilityRuleTests extends TestBase
{
	/**
	 * @var IReservationViewRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	public $reservationRepository;

	/**
	 * @var IAccessoryRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	public $accessoryRepository;

	/**
	 * @var AccessoryAvailabilityRule
	 */
	public $rule;

	public function setup()
	{
		parent::setup();

		$this->reservationRepository = $this->getMock('IReservationViewRepository');
		$this->accessoryRepository = $this->getMock('IAccessoryRepository');

		$this->rule = new AccessoryAvailabilityRule($this->reservationRepository, $this->accessoryRepository, 'UTC');
	}

	public function teardown()
	{
		parent::teardown();
	}
	
	public function testRuleIsValidIfTotalQuantityReservedIsLessThanQuantityAvailable()
	{
		$accessory1 = new ReservationAccessory(1, 5);
		$accessory2 = new ReservationAccessory(2, 5);

		$quantityAvailable = 8;

		$startDate = Date::Parse('2010-04-04', 'UTC');
		$endDate = Date::Parse('2010-04-05', 'UTC');

		$startDate1 = Date::Parse('2010-04-06', 'UTC');
		$endDate1 = Date::Parse('2010-04-07', 'UTC');

		$reservation = new TestReservationSeries();
		$reservation->WithAccessory($accessory1);
		$reservation->WithAccessory($accessory2);
		
		$dr1 = new DateRange($startDate, $endDate);
		$dr2 = new DateRange($startDate1, $endDate1);
		$reservation->WithDuration($dr1);
		$reservation->WithInstanceOn($dr2);

		$accessoryReservation = new AccessoryReservation(2, $startDate, $endDate, $accessory1->AccessoryId, 3);

		$this->accessoryRepository->expects($this->at(0))
			->method('LoadById')
			->with($accessory1->AccessoryId)
			->will($this->returnValue(new Accessory($accessory1->AccessoryId, 'name1', $quantityAvailable)));

		$this->accessoryRepository->expects($this->at(1))
			->method('LoadById')
			->with($accessory2->AccessoryId)
			->will($this->returnValue(new Accessory($accessory2->AccessoryId, 'name1', $quantityAvailable)));

		$this->reservationRepository->expects($this->at(0))
			->method('GetAccessoriesWithin')
			->with($this->equalTo($dr1))
			->will($this->returnValue(array($accessoryReservation)));

		$this->reservationRepository->expects($this->at(1))
			->method('GetAccessoriesWithin')
			->with($this->equalTo($dr2))
			->will($this->returnValue(array()));
			
		$result = $this->rule->Validate($reservation);
		
		$this->assertTrue($result->IsValid());
	}
		
	public function testGetsConflictingReservationTimes()
	{
		$accessory1 = new ReservationAccessory(1, 5);
		$quantityAvailable = 8;

		$startDate = Date::Parse('2010-04-04', 'UTC');
		$endDate = Date::Parse('2010-04-05', 'UTC');

		$reservation = new TestReservationSeries();
		$reservation->WithAccessory($accessory1);
		$dr1 = new DateRange($startDate, $endDate);
		$reservation->WithDuration($dr1);

		$lowerQuantity1 = new AccessoryReservation(2, $startDate, $endDate, $accessory1->AccessoryId, 2);
		$lowerQuantity2 = new AccessoryReservation(3, $startDate, $endDate, $accessory1->AccessoryId, 2);
		$notOnReservation = new AccessoryReservation(4, $startDate, $endDate, 100, 1);

		$this->accessoryRepository->expects($this->at(0))
			->method('LoadById')
			->with($accessory1->AccessoryId)
			->will($this->returnValue(new Accessory($accessory1->AccessoryId, 'name1', $quantityAvailable)));

		$this->reservationRepository->expects($this->at(0))
			->method('GetAccessoriesWithin')
			->with($this->equalTo($dr1))
			->will($this->returnValue(array($lowerQuantity1, $lowerQuantity2, $notOnReservation)));

		$result = $this->rule->Validate($reservation);

		$this->assertFalse($result->IsValid());
		$this->assertFalse(is_null($result->ErrorMessage()));
	}
	
	public function testNoConflictsButTooHigh()
	{
		$accessory1 = new ReservationAccessory(1, 5);
		$quantityAvailable = 4;

		$reservation = new TestReservationSeries();
		$dr1 = new TestDateRange();
		$reservation->WithDuration($dr1);
		$reservation->WithAccessory($accessory1);

		$this->accessoryRepository->expects($this->at(0))
			->method('LoadById')
			->with($accessory1->AccessoryId)
			->will($this->returnValue(new Accessory($accessory1->AccessoryId, 'name1', $quantityAvailable)));

		$this->reservationRepository->expects($this->once(0))
			->method('GetAccessoriesWithin')
			->with($this->anything())
			->will($this->returnValue(array()));

		$result = $this->rule->Validate($reservation);

		$this->assertFalse($result->IsValid());
		$this->assertFalse(is_null($result->ErrorMessage()));
	}

	public function testUnlimitedQuantity()
	{
		$accessory1 = new ReservationAccessory(1, 5);
		$quantityAvailable = null;

		$startDate = Date::Parse('2010-04-04', 'UTC');
		$endDate = Date::Parse('2010-04-05', 'UTC');

		$reservation = new TestReservationSeries();
		$reservation->WithAccessory($accessory1);
		$dr1 = new DateRange($startDate, $endDate);
		$reservation->WithDuration($dr1);

		$this->accessoryRepository->expects($this->at(0))
			->method('LoadById')
			->with($accessory1->AccessoryId)
			->will($this->returnValue(new Accessory($accessory1->AccessoryId, 'name1', $quantityAvailable)));

		$result = $this->rule->Validate($reservation);

		$this->assertTrue($result->IsValid());
	}
}
?>
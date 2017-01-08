<?php
/**
 * Copyright 2011-2014 Nick Korbel
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

require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/namespace.php');

class AccessoryResourceRuleTests extends TestBase
{
	/**
	 * @var FakeAccessoryRepository
	 */
	public $accessoryRepository;

	/**
	 * @var AccessoryResourceRule
	 */
	public $rule;

	public function setup()
	{
		parent::setup();

		$this->accessoryRepository = new FakeAccessoryRepository();

		$this->rule = new AccessoryResourceRule($this->accessoryRepository);
	}

	public function testRuleIsValidIfAccessoryIsNotTiedToAnyResources()
	{
		$accessory1 = new ReservationAccessory(1, 5);

		$this->accessoryRepository->AddAccessory(new Accessory($accessory1->AccessoryId, 'name1', null));

		$reservation = new TestReservationSeries();
		$reservation->WithAccessory($accessory1);
		$reservation->WithResource(new FakeBookableResource(1));

		$result = $this->rule->Validate($reservation, null);

		$this->assertTrue($result->IsValid());
	}

	public function testRuleIsValidIfAccessoryIsTiedToResource_AndQuantityIsMet()
	{
		$resourceId = 1;

		$accessory1 = new ReservationAccessory(1, 5);

		$reservation = new TestReservationSeries();
		$reservation->WithAccessory($accessory1);
		$reservation->WithResource(new FakeBookableResource($resourceId));

		$accessory = new Accessory($accessory1->AccessoryId, 'name1', 2);
		$accessory->AddResource($resourceId, 1, 5);

		$this->accessoryRepository->AddAccessory($accessory);

		$result = $this->rule->Validate($reservation, null);

		$this->assertTrue($result->IsValid());
	}

	public function testRuleIsValidIfAccessoryTiedToMultipleResources_WithNoMinQuantity_AndAtLeastOneResourcePresent()
	{
		$resourceId = 1;
		$accessoryId = 1;

		$reservation = new TestReservationSeries();
		$reservation->WithResource(new FakeBookableResource(1));
		$reservation->AddResource(new FakeBookableResource(2));
		$reservation->WithAccessory(new ReservationAccessory($accessoryId, 10));
		$accessory = new Accessory(1, 'name1', null);
		$accessory->AddResource($resourceId, null, null);

		$this->accessoryRepository->AddAccessory($accessory);

		$result = $this->rule->Validate($reservation, null);

		$this->assertTrue($result->IsValid(), $result->ErrorMessage());
	}

	public function testRuleNotValidIfTiedToResource_AndAccessoryIsBeingReserved_AndResourceNotPresent()
	{
		$resourceId = 1;
		$accessoryId = 1;

		$reservation = new TestReservationSeries();
		$reservation->WithResource(new FakeBookableResource(2));
		$reservation->WithAccessory(new ReservationAccessory($accessoryId, 10));
		$accessory = new Accessory($accessoryId, 'name1', null);
		$accessory->AddResource($resourceId, 1, null);

		$this->accessoryRepository->AddAccessory($accessory);

		$result = $this->rule->Validate($reservation, null);

		$this->assertFalse($result->IsValid());
	}

	public function testRuleIsNotValidIfTiedToResource_AndQuantityMinimumIsNotMet()
	{
		$resourceId = 1;
		$accessoryId = 1;

		$reservation = new TestReservationSeries();
		$reservation->WithResource(new FakeBookableResource($resourceId));
		$reservation->WithAccessory(new ReservationAccessory($accessoryId, 1));
		$accessory = new Accessory($accessoryId, 'name1', 1);
		$accessory->AddResource($resourceId, 2, 10);

		$this->accessoryRepository->AddAccessory($accessory);

		$result = $this->rule->Validate($reservation, null);

		$this->assertFalse($result->IsValid());
	}

	public function testRuleIsNotValidIfTiedToResource_AndQuantityMaximumIsNotMet()
	{
		$resourceId = 1;
		$accessoryId = 1;

		$reservation = new TestReservationSeries();
		$reservation->WithResource(new FakeBookableResource($resourceId));
		$reservation->WithAccessory(new ReservationAccessory($accessoryId, 11));
		$accessory = new Accessory($accessoryId, 'name1', 1);
		$accessory->AddResource($resourceId, 1, 10);

		$this->accessoryRepository->AddAccessory($accessory);

		$result = $this->rule->Validate($reservation, null);

		$this->assertFalse($result->IsValid());
	}

	public function testRuleIsValidWhenAccessoryNotOnReservation_AndTiedToResource()
	{
		$resourceId = 1;
		$reservation = new TestReservationSeries();
		$reservation->WithResource(new FakeBookableResource($resourceId));

		$accessory1 = new Accessory(1, 'name1', null);
		$accessory1->AddResource($resourceId, null, null);

		$accessory2 = new Accessory(1, 'name1', null);
		$accessory2->AddResource(3, 1, 1);
		$accessory2->AddResource(2, 1, 1);

		$this->accessoryRepository->AddAccessory($accessory1);
		$this->accessoryRepository->AddAccessory($accessory2);

		$result = $this->rule->Validate($reservation, null);

		$this->assertTrue($result->IsValid(), $result->ErrorMessage());
	}

	public function testRuleIsNotValidIfAccessoryTiedToResources_ButNoneArePresent()
	{
		$resourceId = 1;
		$accessoryId = 1;

		$reservation = new TestReservationSeries();
		$reservation->WithResource(new FakeBookableResource(10));
		$reservation->AddResource(new FakeBookableResource(20));
		$reservation->WithAccessory(new ReservationAccessory($accessoryId, 10));
		$accessory = new Accessory(1, 'name1', null);
		$accessory->AddResource($resourceId, null, null);

		$this->accessoryRepository->AddAccessory($accessory);

		$result = $this->rule->Validate($reservation, null);

		$this->assertFalse($result->IsValid(), $result->ErrorMessage());
	}
}
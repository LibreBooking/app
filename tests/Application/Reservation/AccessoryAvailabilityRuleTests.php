<?php
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

		$lowerQuantity = new AccessoryReservation(2, $startDate, $endDate, $accessory1->AccessoryId, 4);
		$notOnReservation = new AccessoryReservation(2, $startDate, $endDate, 100, 1);

		$this->accessoryRepository->expects($this->at(0))
			->method('LoadById')
			->with($accessory1->AccessoryId)
			->will($this->returnValue(new Accessory($accessory1->AccessoryId, 'name1', $quantityAvailable)));

		$this->reservationRepository->expects($this->at(0))
			->method('GetAccessoriesWithin')
			->with($this->equalTo($dr1))
			->will($this->returnValue(array($lowerQuantity, $notOnReservation)));

		$result = $this->rule->Validate($reservation);

		$this->assertFalse($result->IsValid());
		$this->assertTrue(!is_null($result->ErrorMessage()));
	}
	
	public function testGetsConflictingReservationTimesForSingleDateMultipleResources()
	{
		$this->markTestIncomplete('working on accessory validation');
		
		$startDate = Date::Parse('2010-04-04', 'UTC');
		$endDate = Date::Parse('2010-04-06', 'UTC');
		$additionalResourceId = 1;
		
		$reservation = new TestReservationSeries();
		$reservation->WithResource(new FakeBookableResource(100));
		$reservation->WithDuration(new DateRange($startDate, $endDate));
		$reservation->AddResource(new FakeBookableResource($additionalResourceId));
		
		$startConflict1 = Date::Parse('2010-04-04', 'UTC');
		$endConflict1 = Date::Parse('2010-04-08', 'UTC');
		
		$startConflict2 = Date::Parse('2010-04-05', 'UTC');
		$endConflict2 = Date::Parse('2010-04-08', 'UTC');
		
		$reservations = array( 
			new TestScheduleReservation(2, $startConflict1, $endConflict1, 2),
			new TestScheduleReservation(3, $startConflict2, $endConflict2, $additionalResourceId),
		);
		
		$reservationRepository = $this->getMock('IReservationRepository');
		
		$reservationRepository->expects($this->once())
			->method('GetWithin')
			->with($this->equalTo($startDate), $this->equalTo($endDate))
			->will($this->returnValue($reservations));
			
		$rule = new ResourceAvailabilityRule($reservationRepository, 'UTC');
		$result = $rule->Validate($reservation);
		
		$this->assertFalse($result->IsValid());
		$this->assertTrue(!is_null($result->ErrorMessage()));
	}
}
?>
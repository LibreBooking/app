<?php
require_once(ROOT_DIR . 'lib/Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Reservation/namespace.php');

class ResourceAvailabilityRuleTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}

	public function teardown()
	{
		parent::teardown();
	}
	
	public function testRuleIsValidIfNoConflictsForTheReservationResources()
	{
		$startDate = Date::Parse('2010-04-04', 'UTC');
		$endDate = Date::Parse('2010-04-05', 'UTC');
		
		$reservation = new Reservation();
		$reservation->Update(1, 100, null, null);
		$reservation->UpdateDuration(new DateRange($startDate, $endDate));
		$reservation->AddResource(101);
		$reservation->AddResource(102);

		$scheduleReservation = new TestScheduleReservation(2, $startDate, $endDate, 1);

		$reservationRepository = $this->getMock('IReservationRepository');
		
		$reservationRepository->expects($this->once())
			->method('GetWithin')
			->with($this->equalTo($startDate), $this->equalTo($endDate))
			->will($this->returnValue(array($scheduleReservation)));
			
		$rule = new ResourceAvailabilityRule($reservationRepository);
		$result = $rule->Validate($reservation);
		
		$this->assertTrue($result->IsValid());
	}
		
	public function testGetsConflictingReservationTimesForSingleDateSingleResource()
	{
		$startDate = Date::Parse('2010-04-04', 'UTC');
		$endDate = Date::Parse('2010-04-05', 'UTC');
		$resourceId = 100;
		
		$reservation = new Reservation();
		$reservation->Update(1, $resourceId, null, null);
		$reservation->UpdateDuration(new DateRange($startDate, $endDate));
		
		$startConflict1 = Date::Parse('2010-04-04', 'UTC');
		$endConflict1 = Date::Parse('2010-04-08', 'UTC');
		
		$startConflict2 = Date::Parse('2010-04-05', 'UTC');
		$endConflict2 = Date::Parse('2010-04-08', 'UTC');
		
		$reservations = array( 
			new TestScheduleReservation(2, $startConflict1, $endConflict1, $resourceId),
			new TestScheduleReservation(3, $startConflict2, $endConflict2, 2),
		);
		
		$reservationRepository = $this->getMock('IReservationRepository');
		
		$reservationRepository->expects($this->once())
			->method('GetWithin')
			->with($this->equalTo($startDate), $this->equalTo($endDate))
			->will($this->returnValue($reservations));
			
		$rule = new ResourceAvailabilityRule($reservationRepository);
		$result = $rule->Validate($reservation);
		
		$this->assertFalse($result->IsValid());
	}
	
	public function testGetsConflictingReservationTimesForSingleDateMultipleResources()
	{
		$startDate = Date::Parse('2010-04-04', 'UTC');
		$endDate = Date::Parse('2010-04-05', 'UTC');
		$additionalResourceId = 1;
		
		$reservation = new Reservation();
		$reservation->Update(1, 100, null, null);
		$reservation->UpdateDuration(new DateRange($startDate, $endDate));
		$reservation->AddResource($additionalResourceId);
		
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
			
		$rule = new ResourceAvailabilityRule($reservationRepository);
		$result = $rule->Validate($reservation);
		
		$this->assertFalse($result->IsValid());
		$this->assertTrue(!is_null($result->ErrorMessage()));
	}
	
	public function testValidatesEachDateThatAReservationRepeatsOn()
	{
		$start = Date::Parse('2010-01-01');
		$end = Date::Parse('2010-01-02');
		$reservationDates = new DateRange($start, $end);
		$twoRepetitions = new WeeklyRepeat(1, 
						$start->AddDays(14), 
						$reservationDates, 
						array($start->Weekday()));
		
		$repeatDates = $twoRepetitions->GetDates();
		
		$reservation = new Reservation();
		$reservation->UpdateDuration($reservationDates);
		$reservation->Repeats($twoRepetitions);
		
		$reservationRepository = new FakeReservationRepository();
		
		$rule = new ResourceAvailabilityRule($reservationRepository);
		$result = $rule->Validate($reservation);
		
		$this->assertEquals(3, count($reservationRepository->_StartDates));
	}
}

class TestScheduleReservation extends ScheduleReservation
{
	public function __construct($id, $startDate, $endDate, $resourceId)
	{
		$this->SetReservationId($id);
		$this->SetStartDate($startDate);
		$this->SetEndDate($endDate);
		$this->SetResourceId($resourceId);
	}
}
?>
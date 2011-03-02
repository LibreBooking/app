<?php
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'tests/Domain/Reservation/TestReservationSeries.php');

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
		
		$reservation = new TestReservationSeries();
		$reservation->WithResourceId(100);
		$reservation->WithDuration(new DateRange($startDate, $endDate));
		$reservation->AddResource(101);
		$reservation->AddResource(102);

		$scheduleReservation = new TestScheduleReservation(2, $startDate, $endDate, 1);

		$reservationRepository = $this->getMock('IReservationRepository');
		
		$reservationRepository->expects($this->once())
			->method('GetWithin')
			->with($this->equalTo($startDate), $this->equalTo($endDate))
			->will($this->returnValue(array($scheduleReservation)));
			
		$rule = new ResourceAvailabilityRule($reservationRepository, 'UTC');
		$result = $rule->Validate($reservation);
		
		$this->assertTrue($result->IsValid());
	}
		
	public function testGetsConflictingReservationTimesForSingleDateSingleResource()
	{
		$startDate = Date::Parse('2010-04-04', 'UTC');
		$endDate = Date::Parse('2010-04-06', 'UTC');
		$resourceId = 100;
		
		$reservation = new TestReservationSeries();
		$reservation->WithResourceId($resourceId);
		$reservation->WithDuration(new DateRange($startDate, $endDate));
		
		$startConflict1 = Date::Parse('2010-04-04', 'UTC');
		$endConflict1 = Date::Parse('2010-04-08', 'UTC');
		
		$startConflict2 = Date::Parse('2010-04-05', 'UTC');
		$endConflict2 = Date::Parse('2010-04-08', 'UTC');
		
		$startNonConflict1 = Date::Parse('2010-04-06', 'UTC');
		$endNonConflict1 = Date::Parse('2010-04-08', 'UTC');
		
		$startNonConflict2 = Date::Parse('2010-04-02', 'UTC');
		$endNonConflict2 = Date::Parse('2010-04-04', 'UTC');
		
		$reservations = array( 
			new TestScheduleReservation(2, $startConflict1, $endConflict1, $resourceId),
			new TestScheduleReservation(3, $startConflict2, $endConflict2, 2),
			new TestScheduleReservation(4, $startNonConflict1, $startNonConflict2, $resourceId),
			new TestScheduleReservation(5, $startNonConflict2, $endNonConflict2, $resourceId),
		);
		
		$reservationRepository = $this->getMock('IReservationRepository');
		
		$reservationRepository->expects($this->once())
			->method('GetWithin')
			->with($this->equalTo($startDate), $this->equalTo($endDate))
			->will($this->returnValue($reservations));
			
		$rule = new ResourceAvailabilityRule($reservationRepository, 'UTC');
		$result = $rule->Validate($reservation);
		
		$this->assertFalse($result->IsValid());
	}
	
	public function testGetsConflictingReservationTimesForSingleDateMultipleResources()
	{
		$startDate = Date::Parse('2010-04-04', 'UTC');
		$endDate = Date::Parse('2010-04-06', 'UTC');
		$additionalResourceId = 1;
		
		$reservation = new TestReservationSeries();
		$reservation->WithResourceId(100);
		$reservation->WithDuration(new DateRange($startDate, $endDate));
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
			
		$rule = new ResourceAvailabilityRule($reservationRepository, 'UTC');
		$result = $rule->Validate($reservation);
		
		$this->assertFalse($result->IsValid());
		$this->assertTrue(!is_null($result->ErrorMessage()));
	}
	
	public function testValidatesEachDateThatAReservationRepeatsOn()
	{
		$start = Date::Parse('2010-01-01');
		$end = Date::Parse('2010-01-02');
		$reservationDates = new DateRange($start, $end);
		$twoRepetitions = new RepeatWeekly(1, 
						$start->AddDays(14), 
						array($start->Weekday()));
		
		$repeatDates = $twoRepetitions->GetDates($reservationDates);
		
		$reservation = new TestReservationSeries();
		$reservation->WithDuration($reservationDates);
		$reservation->WithRepeatOptions($twoRepetitions);
		
		$reservationRepository = $this->getMock('IReservationRepository');
		
		$reservationRepository->expects($this->exactly(1 + count($repeatDates)))
			->method('GetWithin')
			->with($this->anything(), $this->anything())
			->will($this->returnValue(array()));
		
		$rule = new ResourceAvailabilityRule($reservationRepository, 'UTC');
		$result = $rule->Validate($reservation);
	}
}

class TestScheduleReservation extends ScheduleReservation
{
	/**
	 * @param $id
	 * @param $startDate Date
	 * @param $endDate Date
	 * @param $resourceId
	 */
	public function __construct($id, $startDate, $endDate, $resourceId = 1)
	{
		$this->SetReservationId($id);
		$this->SetStartDate($startDate);
		$this->SetEndDate($endDate);
		$this->SetResourceId($resourceId);
	}
}
?>
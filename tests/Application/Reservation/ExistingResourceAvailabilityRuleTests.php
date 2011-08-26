<?php
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'tests/Domain/Reservation/TestReservationSeries.php');

class ExistingResourceAvailabilityRuleTests extends TestBase
{
	private $timezone = 'UTC';
	private $repo;	
	
	public function setup()
	{
		parent::setup();
		
		$this->repo = $this->getMock('IReservationRepository');
	}

	public function teardown()
	{
		parent::teardown();
	}

	public function testDoesNotConflictIfBeingDeletedOrUpdated()
	{
		$now = Date::Now();
		$currentDate = new DateRange($now->AddDays(10), $now->AddDays(15));
		$resourceId = 18;
		$id1 = 100;
		$id2 = 101;
		$currentId = 99;
		$deleted = new TestReservation('ref2', new TestDateRange());
		$deleted->SetReservationId($id1);
		$updated = new TestReservation('ref3', new TestDateRange());
		$updated->SetReservationId($id2);
		$current = new TestReservation('ref', $currentDate);
		$current->SetReservationId($currentId);
		
		$series = new ExistingReservationSeries();
		$series->WithResource(new FakeBookableResource($resourceId));
		$series->WithCurrentInstance($current);	
		$series->WithInstance($deleted);
		$series->WithInstance($updated);
		
		$series->RemoveInstance($deleted);
		$series->UpdateInstance($updated, new DateRange($now->AddDays(20), $now->AddDays(21)));
		
		$reservations = array( 
			new TestScheduleReservation($id1, Date::Now(), Date::Now(), $resourceId),
			new TestScheduleReservation($id2, Date::Now(), Date::Now(), $resourceId),
		);
		
		$this->repo->expects($this->exactly(2))
			->method('GetWithin')
			->with($this->anything(), $this->anything())
			->will($this->returnValue($reservations));
		
		$rule = new ExistingResourceAvailabilityRule($this->repo, $this->timezone);
		$ruleResult = $rule->Validate($series);
		
		$this->assertTrue($ruleResult->IsValid());
	}
	
	public function testDoesNotConflictIfCurrentInstanceBeingUpdated()
	{
		$resourceId = 1;
		$currentId = 19;
		$currentDate = new DateRange(Date::Now()->AddDays(10), Date::Now()->AddDays(15));
		$current = new TestReservation('ref', $currentDate);
		$current->SetReservationId($currentId);
		
		$series = new ExistingReservationSeries();
		$series->WithResource(new FakeBookableResource($resourceId));
		$series->WithCurrentInstance($current);	
		
		$reservations = array( 
			new TestScheduleReservation($currentId, Date::Now(), Date::Now(), $resourceId),
		);
		
		$this->repo->expects($this->once())
			->method('GetWithin')
			->with($this->anything(), $this->anything())
			->will($this->returnValue($reservations));
			
		$rule = new ExistingResourceAvailabilityRule($this->repo, $this->timezone);
		$ruleResult = $rule->Validate($series);
		
		$this->assertTrue($ruleResult->IsValid());
	}
	
	public function testConflictsIfResourceReservationExistsAtSameTime()
	{
		$resourceId = 1;
		$currentId = 19;
		$currentDate = new DateRange(Date::Now()->AddDays(10), Date::Now()->AddDays(15));
		$current = new TestReservation('ref', $currentDate);
		$current->SetReservationId($currentId);
		
		$series = new ExistingReservationSeries();
		$series->WithPrimaryResource(new FakeBookableResource($resourceId));
		$series->WithResource(new FakeBookableResource($resourceId + 1));
		$series->WithCurrentInstance($current);	
		
		$reservations = array( 
			new TestScheduleReservation($currentId+1, Date::Now(), Date::Now(), $resourceId),
		);
		
		$this->repo->expects($this->once())
			->method('GetWithin')
			->with($this->anything(), $this->anything())
			->will($this->returnValue($reservations));
			
		$rule = new ExistingResourceAvailabilityRule($this->repo, $this->timezone);
		$ruleResult = $rule->Validate($series);
		
		$this->assertFalse($ruleResult->IsValid());
	}
	
	public function testNoConflictsIfReservationExistsAtSameTimeForDifferentResource()
	{
		$resourceId1 = 1;
		$resourceId2 = 2;
		$resourceId3 = 3;
		$currentId = 19;
		$currentDate = new DateRange(Date::Now()->AddDays(10), Date::Now()->AddDays(15));
		$current = new TestReservation('ref', $currentDate);
		$current->SetReservationId($currentId);
		
		$series = new ExistingReservationSeries();
		$series->WithPrimaryResource(new FakeBookableResource($resourceId1));
		$series->WithResource(new FakeBookableResource($resourceId2));
		$series->WithCurrentInstance($current);	
		
		$reservations = array( 
			new TestScheduleReservation($currentId+1, Date::Now(), Date::Now(), $resourceId3),
		);
		
		$this->repo->expects($this->once())
			->method('GetWithin')
			->with($this->anything(), $this->anything())
			->will($this->returnValue($reservations));
			
		$rule = new ExistingResourceAvailabilityRule($this->repo, $this->timezone);
		$ruleResult = $rule->Validate($series);
		
		$this->assertTrue($ruleResult->IsValid());
	}
}
?>
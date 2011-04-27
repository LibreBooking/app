<?php
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'tests/Domain/Reservation/TestReservationSeries.php');

class ResourceMinimumDurationRuleTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}

	public function teardown()
	{
		parent::teardown();
	}
	
	public function testNotValidIfTheReservationIsShorterThanTheMinDurationForAnyResource()
	{
		$resourceId1 = 1;
		$resourceId2 = 2;
		
		$resource1 = new FakeResource($resourceId1, "1");
		$resource1->SetMinLength(null);
		
		$resource2 = new FakeResource($resourceId2, "2");
		$resource2->SetMinLength("25:00");
		
		$reservation = new TestReservationSeries();
	
		$duration = new DateRange(Date::Now(), Date::Now()->AddDays(1));
		$reservation->WithDuration($duration);
		$reservation->WithResourceId($resourceId1);
		$reservation->AddResource($resourceId2);
		
		$resourceRepo = $this->getMock('IResourceRepository');
		
		$resourceRepo->expects($this->any())
			->method('LoadById')
			->will($this->onConsecutiveCalls($resource1, $resource2));
			
		$rule = new ResourceMinimumDurationRule($resourceRepo);
		$result = $rule->Validate($reservation);
		
		$this->assertFalse($result->IsValid());
	}
	
	public function testOkIfReservationIsLongerThanTheMinDuration()
	{
		$resource = new FakeResource(1, "2");
		$resource->SetMinLength("23:00");
		
		$resourceRepo = $this->getMock('IResourceRepository');
		
		$resourceRepo->expects($this->any())
			->method('LoadById')
			->will($this->returnValue($resource));
			
		$reservation = new TestReservationSeries();
		
		$duration = new DateRange(Date::Now(), Date::Now()->AddDays(1));
		$reservation->WithDuration($duration);
		
		$rule = new ResourceMinimumDurationRule($resourceRepo);
		$result = $rule->Validate($reservation);
		
		$this->assertTrue($result->IsValid());
	}
}
?>
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
		$resource1 = new FakeBookableResource(1, "1");
		$resource1->SetMinLength(null);
		
		$resource2 = new FakeBookableResource(2, "2");
		$resource2->SetMinLength("25:00");
		
		$reservation = new TestReservationSeries();
	
		$duration = new DateRange(Date::Now(), Date::Now()->AddDays(1));
		$reservation->WithDuration($duration);
		$reservation->WithResource($resource1);
		$reservation->AddResource($resource2);
			
		$rule = new ResourceMinimumDurationRule();
		$result = $rule->Validate($reservation);
		
		$this->assertFalse($result->IsValid());
	}
	
	public function testOkIfReservationIsLongerThanTheMinDuration()
	{
		$resource = new FakeBookableResource(1, "2");
		$resource->SetMinLength("23:00");
			
		$reservation = new TestReservationSeries();
		$reservation->WithResource($resource);
		
		$duration = new DateRange(Date::Now(), Date::Now()->AddDays(1));
		$reservation->WithDuration($duration);
		
		$rule = new ResourceMinimumDurationRule();
		$result = $rule->Validate($reservation);
		
		$this->assertTrue($result->IsValid());
	}
}
?>
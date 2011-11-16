<?php
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'tests/Domain/Reservation/TestReservationSeries.php');

class ResourceMaximumNoticeRuleTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}

	public function teardown()
	{
		parent::teardown();
	}
	
	public function testMaxNoticeIsCheckedAgainstEachReservationInstanceForEachResource()
	{
		$resource1 = new FakeBookableResource(1, "1");
		$resource1->SetMaxNotice(null);
		
		$resource2 = new FakeBookableResource(2, "2");
		$resource2->SetMaxNotice("23h00m");
		
		$reservation = new TestReservationSeries();
		
		$duration = new DateRange(Date::Now(), Date::Now());
		$tooFarInFuture = Date::Now()->AddDays(1);
		$reservation->WithDuration($duration);
		$reservation->WithRepeatOptions(new RepeatDaily(1, $tooFarInFuture));
		$reservation->WithResource($resource1);
		$reservation->AddResource($resource2);
			
		$rule = new ResourceMaximumNoticeRule();
		$result = $rule->Validate($reservation);
		
		$this->assertFalse($result->IsValid());
	}
	
	public function testOkIfLatestInstanceIsBeforeTheMaximumNoticeTime()
	{
		$resource = new FakeBookableResource(1, "2");
		$resource->SetMaxNotice("1h00m");
			
		$reservation = new TestReservationSeries();
		$reservation->WithResource($resource);
		
		$duration = new DateRange(Date::Now(), Date::Now());
		$reservation->WithDuration($duration);
		
		$rule = new ResourceMaximumNoticeRule();
		$result = $rule->Validate($reservation);
		
		$this->assertTrue($result->IsValid());
	}
}
?>
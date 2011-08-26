<?php
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'tests/Domain/Reservation/TestReservationSeries.php');

class ResourceMinimumNoticeRuleTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}

	public function teardown()
	{
		parent::teardown();
	}
	
	public function testMinNoticeIsCheckedAgainstEachReservationInstanceForEachResource()
	{
		$resource1 = new FakeBookableResource(1, "1");
		$resource1->SetMinNotice(null);
		
		$resource2 = new FakeBookableResource(2, "2");
		$resource2->SetMinNotice("25:00");
		
		$reservation = new TestReservationSeries();
		
		$duration = new DateRange(Date::Now(), Date::Now());
		$tooSoon = Date::Now()->AddDays(1);
		$reservation->WithDuration($duration);
		$reservation->WithRepeatOptions(new RepeatDaily(1, $tooSoon));
		$reservation->WithResource($resource1);
		$reservation->AddResource($resource2);
			
		$rule = new ResourceMinimumNoticeRule();
		$result = $rule->Validate($reservation);
		
		$this->assertFalse($result->IsValid());
	}
	
	public function testOkIfLatestInstanceIsBeforeTheMinimumNoticeTime()
	{
		$resource = new FakeBookableResource(1, "2");
		$resource->SetMinNotice("1:00");
			
		$reservation = new TestReservationSeries();
		$reservation->WithResource($resource);
		
		$duration = new DateRange(Date::Now()->AddDays(1), Date::Now()->AddDays(1));
		$reservation->WithDuration($duration);
		
		$rule = new ResourceMinimumNoticeRule();
		$result = $rule->Validate($reservation);
		
		$this->assertTrue($result->IsValid());
	}
}
?>
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
		$resourceId1 = 1;
		$resourceId2 = 2;
		
		$resource1 = new FakeBookableResource($resourceId1, "1");
		$resource1->SetMaxNotice(null);
		
		$resource2 = new FakeBookableResource($resourceId2, "2");
		$resource2->SetMaxNotice("23:00");
		
		$reservation = new TestReservationSeries();
		
		$duration = new DateRange(Date::Now(), Date::Now());
		$tooFarInFuture = Date::Now()->AddDays(1);
		$reservation->WithDuration($duration);
		$reservation->WithRepeatOptions(new RepeatDaily(1, $tooFarInFuture));
		$reservation->WithResourceId($resourceId1);
		$reservation->AddResource($resourceId2);
		
		$resourceRepo = $this->getMock('IResourceRepository');
		
		$resourceRepo->expects($this->any())
			->method('LoadById')
			->will($this->onConsecutiveCalls($resource1, $resource2));
			
		$rule = new ResourceMaximumNoticeRule($resourceRepo);
		$result = $rule->Validate($reservation);
		
		$this->assertFalse($result->IsValid());
	}
	
	public function testOkIfLatestInstanceIsBeforeTheMaximumNoticeTime()
	{
		$resource = new FakeBookableResource(1, "2");
		$resource->SetMaxNotice("1:00");
		
		$resourceRepo = $this->getMock('IResourceRepository');
		
		$resourceRepo->expects($this->any())
			->method('LoadById')
			->will($this->returnValue($resource));
			
		$reservation = new TestReservationSeries();
		
		$duration = new DateRange(Date::Now(), Date::Now());
		$reservation->WithDuration($duration);
		
		$rule = new ResourceMaximumNoticeRule($resourceRepo);
		$result = $rule->Validate($reservation);
		
		$this->assertTrue($result->IsValid());
	}
}
?>
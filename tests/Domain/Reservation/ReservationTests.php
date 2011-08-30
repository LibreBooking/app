<?php
require_once(ROOT_DIR . 'Domain/namespace.php');

class ReservationTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}

	public function teardown()
	{
		parent::teardown();
	}

	public function testCreatingNewSeriesSetsAllSharedDataAndCreatesInstances()
	{
		$userId = 32;
		$resourceId = 10;
		$scheduleId = 19;
		$title = 'Title';
		$description = 'some long decription';
		
		$startDateCst = '2010-02-02 12:15';
		$endDateCst = '2010-02-04 17:15';
		
		$startDateUtc = Date::Parse($startDateCst, 'CST')->ToUtc();
		$endDateUtc = Date::Parse($endDateCst, 'CST')->ToUtc();
		
		$dateRange = DateRange::Create($startDateCst, $endDateCst, 'CST');
		$repeatedDate = DateRange::Create('2010-01-01', '2010-01-02', 'UTC');
		
		$repeatOptions = $this->getMock('IRepeatOptions');
		$repeatDates = array($repeatedDate);
		
		$repeatOptions->expects($this->once())
			->method('GetDates')
			->with($this->equalTo($dateRange))
			->will($this->returnValue($repeatDates));

		$userSession = new FakeUserSession();

		$resource = new FakeBookableResource($resourceId);
		$series = ReservationSeries::Create(
			$userId,
			$resource,
			$scheduleId, 
			$title, 
			$description, 
			$dateRange, 
			$repeatOptions,
			$userSession);
		
		$this->assertEquals($userId, $series->UserId());
		$this->assertEquals($resource, $series->Resource());
		$this->assertEquals($scheduleId, $series->ScheduleId());
		$this->assertEquals($title, $series->Title());
		$this->assertEquals($description, $series->Description());
		$this->assertTrue($series->IsRecurring());
		$this->assertEquals($repeatOptions, $series->RepeatOptions());
		
		$instances = array_values($series->Instances());
		
		$this->assertEquals(count($repeatDates) + 1, count($instances), "should have original plus instances");
		$this->assertTrue($startDateUtc->Equals($instances[0]->StartDate()));
		$this->assertTrue($endDateUtc->Equals($instances[0]->EndDate()));
		
		$this->assertTrue($repeatedDate->GetBegin()->Equals($instances[1]->StartDate()));
		$this->assertTrue($repeatedDate->GetEnd()->Equals($instances[1]->EndDate()));
	}
	
	public function testCanGetSpecificInstanceByDate()
	{
		$startDate = Date::Parse('2010-02-02 12:15', 'UTC');
		$endDate = $startDate->AddDays(1);
		$dateRange = new DateRange($startDate, $endDate);
		
		$repeatOptions = $this->getMock('IRepeatOptions');
		
		$series = ReservationSeries::Create(1, new FakeBookableResource(1), 1, null, null, $dateRange, $repeatOptions, new FakeUserSession());
		
		$instance = $series->CurrentInstance();
		
		$this->assertEquals($startDate, $instance->StartDate());
		$this->assertEquals($endDate, $instance->EndDate());
	}

	public function testStatusIsCreatedWhenBookedByAdmin()
	{
		$resource = new FakeBookableResource(1);
		$resource->RequiresApproval(true);
		
		$series = ReservationSeries::Create(1, $resource, 1, null, null, new TestDateRange(), new RepeatNone(), new FakeUserSession(true));

		$this->assertEquals(ReservationStatus::Created, $series->StatusId());
	}

	public function testStatusIsPendingWhenRequiresApprovalAndNotAdmin()
	{
		$resource = new FakeBookableResource(1);
		$resource->RequiresApproval(true);

		$series = ReservationSeries::Create(1, $resource, 1, null, null, new TestDateRange(), new RepeatNone(), new FakeUserSession(false));

		$this->assertEquals(ReservationStatus::Pending, $series->StatusId());
	}
}
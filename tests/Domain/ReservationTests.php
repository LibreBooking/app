<?php
require_once(ROOT_DIR . 'lib/Domain/namespace.php');

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

	public function testUpdatingANewReservation()
	{
		$userId = 32;
		$resourceId = 10;
		$title = 'Title';
		$description = 'some long decription';
		
		$startDateCst = '2010-02-02 12:15';
		$endDateCst = '2010-02-04 17:15';
		
		$startDateUtc = Date::Parse($startDateCst, 'CST')->ToUtc();
		$endDateUtc = Date::Parse($endDateCst, 'CST')->ToUtc();
		
		$dateRange = DateRange::Create($startDateCst, $endDateCst, 'CST');
		
		$repeatOptions = $this->getMock('IRepeatOptions');
		$repeatDates = array();
		
		$repeatOptions->expects($this->once())
			->method('GetDates')
			->will($this->returnValue($repeatDates));
			
		$reservation = new Reservation();
		$reservation->Update($userId, $resourceId, $title, $description);
		$reservation->UpdateDuration($dateRange);
		$reservation->Repeats($repeatOptions);
		
		$this->assertEquals($userId, $reservation->UserId());
		$this->assertEquals($resourceId, $reservation->ResourceId());
		$this->assertEquals($title, $reservation->Title());
		$this->assertEquals($description, $reservation->Description());
		$this->assertEquals($startDateUtc, $reservation->StartDate());
		$this->assertEquals($endDateUtc, $reservation->EndDate());
		$this->assertEquals($repeatDates, $reservation->RepeatedDates());
		$this->assertEquals($repeatOptions, $reservation->RepeatOptions());
	}
}
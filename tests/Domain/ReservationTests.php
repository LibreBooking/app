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
		
		$reservation = new Reservation();
		$reservation->Update($userId, $resourceId, $title, $description);
		$reservation->UpdateDuration($dateRange);

		$this->assertEquals($userId, $reservation->UserId());
		$this->assertEquals($resourceId, $reservation->ResourceId());
		$this->assertEquals($title, $reservation->Title());
		$this->assertEquals($description, $reservation->Description());
		$this->assertEquals($startDateUtc, $reservation->StartDate());
		$this->assertEquals($endDateUtc, $reservation->EndDate());
	}
	
//	public function testConfigureRepeatOptionsWithANewReservation()
//	{				
//		$startDateCst = '2010-02-02 12:15';
//		$endDateCst = '2010-02-04 17:15';
//		
//		$dateRange = DateRange::Create($startDateCst, $endDateCst, 'CST');
//		
//		$repeatOptions = new NoRepetion();
//		
//		//TODO need a whole fixture just for repetition
//		$reservation = new Reservation();
//		$reservation->UpdateDuration($dateRange);
//		$reservation->Repeats($repeatOptions);
//		
//		$this->assertEquals($repeatedDates, $reservation->RepeatedDates());
//	}
}
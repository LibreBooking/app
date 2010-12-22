<?php 
require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');

class DailyLayoutTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}
	
	public function teardown()
	{
		parent::teardown();
	}
	
	public function testGetLayoutReturnsBuiltSlotsFromScheduleReservationList()
	{
		$date = Date::Parse('2009-09-02', 'UTC');
		$resourceId = 1;
		$targetTimezone = 'CST';
		
		$scheduleLayout = $this->getMock('IScheduleLayout');
		$scheduleLayout = new ScheduleLayout($targetTimezone);
		$scheduleLayout->AppendPeriod(new Time(5, 0, 0, $targetTimezone), new Time(6, 0, 0, $targetTimezone));
		
		$listing = $this->getMock('IReservationListing');
		$dateListing = $this->getMock('IDateReservationListing');
		$resourceListing = $this->getMock('IResourceReservationListing');
		
		$startDate = Date::Parse('2009-09-02 17:00:00', 'UTC');
		$endDate = Date::Parse('2009-09-02 18:00:00', 'UTC');
		$reservation = new ScheduleReservation(1, $startDate, $endDate, 1, 's', null, $resourceId, 100, 'f', 'l');
		$reservations = array($reservation);		

		$listing->expects($this->once())
			->method('OnDate')
			->with($this->equalTo($date))
			->will($this->returnValue($dateListing));
			
		$dateListing->expects($this->once())
			->method('ForResource')
			->with($this->equalTo($resourceId))
			->will($this->returnValue($resourceListing));
		
		$resourceListing->expects($this->once())
			->method('Reservations')
			->will($this->returnValue($reservations));			
			
		$layout = new DailyLayout($listing, $scheduleLayout);
		$layoutSlots = $layout->GetLayout($date, $resourceId);
		
		$reservationList = new ScheduleReservationList($reservations, $scheduleLayout, $date);
		$expectedSlots = $reservationList->BuildSlots();
		
		$this->assertEquals($expectedSlots, $layoutSlots);
	}
}
?>
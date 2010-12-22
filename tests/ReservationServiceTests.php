<?php
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');

class ReservationServiceTests extends TestBase
{	
	public function setup()
	{
		parent::setup();
	}
	
	public function teardown()
	{
		parent::teardown();
	}
		
	public function testGetReservationsPullsReservationFromTheRepositoryAndAddsThemToTheCoordinator()
	{
		$timezone = 'UTC';
		$startDate = Date::Now();
		$endDate = Date::Now();
		$scheduleId = 100;
		
		$range = new DateRange($startDate, $endDate);
		
		$repository = $this->getMock('IReservationRepository');
		$reservationListing = $this->getMock('IMutableReservationListing');
		$listingFactory = $this->getMock('IReservationListingFactory');
		
		$rows = FakeReservationRepository::GetReservationRows();
		$res1 = ReservationFactory::CreateForSchedule($rows[0]);
		$res2 = ReservationFactory::CreateForSchedule($rows[1]);
		$res3 = ReservationFactory::CreateForSchedule($rows[2]);
		
		$repository
			->expects($this->once())
			->method('GetWithin')
			->with($this->equalTo($startDate), $this->equalTo($endDate), $this->equalTo($scheduleId))
			->will($this->returnValue(array($res1, $res2, $res3)));

		$listingFactory
			->expects($this->once())
			->method('CreateReservationListing')
			->with($timezone)
			->will($this->returnValue($reservationListing));

		$reservationListing
			->expects($this->at(0))
			->method('Add')
			->with($res1);

		$reservationListing
			->expects($this->at(1))
			->method('Add')
			->with($res2);
						
		$reservationListing
			->expects($this->at(2))
			->method('Add')
			->with($res3);
			
		$service = new ReservationService($repository, $listingFactory);
		
		$listing = $service->GetReservations($range, $scheduleId, $timezone);
		
		$this->assertEquals($reservationListing, $listing);
	}
	
}
?>
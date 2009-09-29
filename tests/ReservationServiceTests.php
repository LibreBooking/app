<?php
require_once(ROOT_DIR . 'lib/Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Schedule/namespace.php');

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
		$coordinator = $this->getMock('ReservationCoordinator');
		$reservationListing = $this->getMock('IReservationListing');
		$coordinatorFactory = $this->getMock('IReservationCoordinatorFactory');
		
		$rows = FakeReservationRepository::GetReservationRows();
		$res1 = ReservationFactory::CreateForSchedule($rows[0]);
		$res2 = ReservationFactory::CreateForSchedule($rows[1]);
		$res3 = ReservationFactory::CreateForSchedule($rows[2]);
		
		$repository
			->expects($this->once())
			->method('GetWithin')
			->with($this->equalTo($startDate), $this->equalTo($endDate), $this->equalTo($scheduleId))
			->will($this->returnValue(array($res1, $res2, $res3)));

		$coordinatorFactory
			->expects($this->once())
			->method('CreateCoordinator')
			->will($this->returnValue($coordinator));

		$coordinator
			->expects($this->at(0))
			->method('AddReservation')
			->with($res1);

		$coordinator
			->expects($this->at(1))
			->method('AddReservation')
			->with($res2);
						
		$coordinator
			->expects($this->at(2))
			->method('AddReservation')
			->with($res3);

		$coordinator
			->expects($this->once())
			->method('Arrange')
			->with($this->equalTo($timezone), $this->equalTo($range))
			->will($this->returnValue($reservationListing));
			
		$service = new ReservationService($repository, $coordinatorFactory);
		
		$listing = $service->GetReservations($range, $scheduleId, $timezone);
		
		$this->assertEquals($reservationListing, $listing);
	}
	
}
?>
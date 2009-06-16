<?php
require_once(ROOT_DIR . 'lib/Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Schedule/namespace.php');

class ReservationServiceTests extends TestBase
{
	/**
	 * @var IReservationCoordinator 
	 */
	private $coordinator;
	
	/**
	 * @var IReservationRepository 
	 */
	private $repository;
	
	/**
	 * @var IReservationListing
	 */
	private $reservationListing;
	
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
		$this->fail("finish this test first");
		
		$timezone = 'UTC';
		$startDate = Date::Now();
		$endDate = Date::Now();
		
		$range = new DateRange($startDate, $endDate);
		
		$this->repository = $this->getMock('IReservationRepository');
				
		$rows = FakeReservationRepository::GetReservationRows();
		$row1 = $rows[0];
		$row2 = $rows[1];
		$row3 = $rows[2];
		
		$this->repository
			->expects($this->once())
			->method('GetWithin')
			->with($this->equalTo($startDate), $this->equalTo($endDate), $this->equalTo($scheduleId))
			->will($this->returnValue(array($row1, $row2, $row3)));
		
		$this->coordinator = $this->getMock('ReservationCoordinator');
		$coordinatorFactory = $this->getMock('IReservationCoordinatorFactory');
		
		$coordinatorFactory
			->expects($this->once())
			->method('CreateCoordinator')
			->will($this->returnValue($this->coordinator));
		
		$this->coordinator
			->expects($this->once())
			->method('AddReservation')
			->with($res1);
		
		$this->coordinator
			->expects($this->once())
			->method('AddReservation')
			->with($res2);
			
		$this->coordinator
			->expects($this->once())
			->method('AddReservation')
			->with($res3);
			
		$this->reservationListing = $this->getMock('IReservationListing');
		
		$this->coordinator
			->expects($this->once())
			->method('Arrange')
			->with($this->equalTo($timezone), $this->equalTo($range))
			->will($this->returnValue($this->reservationListing));
			
		$service = new ReservationService($this->repository, $coordinatorFactory);
		
		$service->GetReservations($range, $scheduleId, $timezone);
	}
	
}

interface IReservationCoordinatorFactory
{
	/**
	 * @return IReservationCoordinator
	 */
	function CreateCoordinator();
}
?>
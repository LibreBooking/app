<?php
require_once(ROOT_DIR . 'Presenters/Dashboard/UpcomingReservationsPresenter.php');

class UpcomingReservationsPresenterTests extends TestBase
{
	/**
	 * @var UpcomingReservationsPresenter
	 */
	private $presenter;
	
	/**
	 * @var IUpcomingReservationsControl
	 */
	private $control;
	
	/**
	 * @var IReservationViewRepository
	 */
	private $repository;
	
	public function setup()
	{
		parent::setup();
		
		$this->control = $this->getMock('IUpcomingReservationsControl');
		$this->repository = $this->getMock('IReservationViewRepository');
	}
	
	public function teardown()
	{
		parent::teardown();
	}
	
	public function testGetsReservationsThatCurrentUserScheduled()
	{
		$startDate = Date::Now();
		$endDate = Date::Now()->AddDays(14);
		$userId = $this->fakeUser->UserId;
		
		$reservations = array();
		
		$this->repository->expects($this->once())
			->method('GetReservationList')
			->with($this->equalTo($startDate), $this->equalTo($endDate), $this->equalTo($userId))
			->will($this->returnValue($reservations));
		
		$this->control->expects($this->once())
			->method('BindReservations')
			->with($this->equalTo($reservations));
			
		$presenter = new UpcomingReservationsPresenter($this->control, $this->repository);
		$presenter->PageLoad();
	}
}
?>
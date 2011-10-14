<?php
require_once(ROOT_DIR . 'Presenters/ReservationDeletePresenter.php');
require_once(ROOT_DIR . 'Pages/Ajax/ReservationDeletePage.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

class ReservationDeletePresenterTests extends TestBase
{	
	private $userId;
	
	/**
	 * @var UserSession
	 */
	private $user;
	
	/**
	 * @var IReservationDeletePage
	 */
	private $page;
	
	/**
	 * @var IDeleteReservationPersistenceService
	 */
	private $persistenceService;
	
	/**
	 * @var IReservationHandler
	 */
	private $handler;
	
	/**
	 * @var ReservationDeletePresenter
	 */
	private $presenter;
	
	public function setup()
	{
		parent::setup();
		
		$this->user = $this->fakeServer->UserSession;
		$this->userId = $this->user->UserId;
		
		$this->persistenceService = $this->getMock('IDeleteReservationPersistenceService');
		$this->handler = $this->getMock('IReservationHandler');
		
		$this->page = $this->getMock('IReservationDeletePage');
		
		$this->presenter = new ReservationDeletePresenter(
								$this->page, 
								$this->persistenceService, 
								$this->handler);
	}
	
	public function teardown()
	{
		parent::teardown();
	}
	
	public function testLoadsExistingReservationAndDeletesIt()
	{
		$reservationId = 109809;
		$seriesUpdateScope = SeriesUpdateScope::ThisInstance;
		
		$expectedSeries = $this->getMock('ExistingReservationSeries');	

		$this->page->expects($this->once())
			->method('GetReservationId')
			->will($this->returnValue($reservationId));
		
		$this->page->expects($this->once())
			->method('GetSeriesUpdateScope')
			->will($this->returnValue($seriesUpdateScope));
		
		$this->persistenceService->expects($this->once())
			->method('LoadByInstanceId')
			->with($this->equalTo($reservationId))
			->will($this->returnValue($expectedSeries));	
			
		$expectedSeries->expects($this->once())
			->method('Delete')
			->with($this->user);
			
		$expectedSeries->expects($this->once())
			->method('ApplyChangesTo')
			->with($this->equalTo($seriesUpdateScope));
			
		$existingSeries = $this->presenter->BuildReservation();
	}
	
	public function testHandlingReservationCreationDelegatesToServicesForValidationAndPersistenceAndNotification()
	{
		$builder = new ExistingReservationSeriesBuilder();
		$series = $builder->Build();
		$instance = new Reservation($series, NullDateRange::Instance());
		$series->WithCurrentInstance($instance);
		
		$this->handler->expects($this->once())
			->method('Handle')
			->with($this->equalTo($series), $this->equalTo($this->page))
			->will($this->returnValue(true));
					

		$this->presenter->HandleReservation($series);	
	}	
}
?>
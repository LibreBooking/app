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
	 * @var IDeleteReservationValidationService
	 */
	private $validationService;
	
	/**
	 * @var IDeleteReservationNotificationService
	 */
	private $notificationService;
	
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
		$this->validationService = $this->getMock('IDeleteReservationValidationService');
		$this->notificationService = $this->getMock('IDeleteReservationNotificationService');
		
		$this->page = $this->getMock('IReservationDeletePage');
		
		$this->presenter = new ReservationDeletePresenter(
								$this->page, 
								$this->persistenceService, 
								$this->validationService, 
								$this->notificationService);
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
		
		$timezone = $this->user->Timezone;
		
		$this->persistenceService->expects($this->once())
			->method('LoadByInstanceId')
			->with($this->equalTo($reservationId))
			->will($this->returnValue($expectedSeries));	
			
		$expectedSeries->expects($this->once())
			->method('Delete');
			
		$expectedSeries->expects($this->once())
			->method('ApplyChangesTo')
			->with($this->equalTo($seriesUpdateScope));
			
		$existingSeries = $this->presenter->BuildReservation();
	}
	
	public function testHandlingReservationCreationDelegatesToServicesForValidationAndPersistanceAndNotification()
	{
		$builder = new ExistingReservationSeriesBuilder();
		$series = $builder->Build();
		$instance = new Reservation($series, NullDateRange::Instance());
		$series->WithCurrentInstance($instance);
		
		$validationResult = new ReservationValidationResult();

		$this->validationService->expects($this->once())
			->method('Validate')
			->with($this->equalTo($series))
			->will($this->returnValue($validationResult));

		$this->persistenceService->expects($this->once())
			->method('Persist')
			->with($this->equalTo($series));
			
		$this->notificationService->expects($this->once())
			->method('Notify')
			->with($this->equalTo($series));
			
		$this->page->expects($this->once())
			->method('SetSaveSuccessfulMessage')
			->with($this->equalTo(true));
		
		$this->page->expects($this->once())
			->method('ShowWarnings')
			->with($this->equalTo($validationResult->GetWarnings()));

		$this->presenter->HandleReservation($series);	
	}	
}
?>
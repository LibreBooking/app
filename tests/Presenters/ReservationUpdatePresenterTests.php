<?php
require_once(ROOT_DIR . 'Presenters/ReservationUpdatePresenter.php');
require_once(ROOT_DIR . 'Pages/Ajax/ReservationSavePage.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

class ReservationUpdatePresenterTests extends TestBase
{	
	private $userId;
	
	/**
	 * @var UserSession
	 */
	private $user;
	
	/**
	 * @var FakeReservationUpdatePage
	 */
	private $page;
	
	/**
	 * @var IReservationUpdatePersistenceService
	 */
	private $persistenceService;
	
	/**
	 * @var IReservationUpdateValidationService
	 */
	private $validationService;
	
	/**
	 * @var IReservationUpdateNotificationService
	 */
	private $notificationService;
	
	public function setup()
	{
		parent::setup();
		
		$this->user = $this->fakeServer->UserSession;
		$this->userId = $this->user->UserId;
		
		$this->persistenceService = $this->getMock('IReservationUpdatePersistenceService');
		$this->validationService = $this->getMock('IReservationUpdateValidationService');
		$this->notificationService = $this->getMock('IReservationUpdateNotificationService');
		
		$this->page = new FakeReservationUpdatePage();
	}
	
	public function teardown()
	{
		parent::teardown();
	}
	
	public function testLoadsExistingReservationAndUpdatesData()
	{
		$timezone = $this->user->Timezone;
		
		$this->presenter = new ReservationUpdatePresenter(
								$this->page, 
								$this->persistenceService, 
								$this->validationService, 
								$this->notificationService);
		
		$existingSeries = $this->presenter->BuildReservation();
	}

}

class FakeReservationUpdatePage extends FakeReservationSavePage implements IReservationUpdatePage
{
	public $reservationId = 100;
	
	public function GetReservationId()
	{
		return $this->reservationid;
	}
	
	public function GetSeriesUpdateScope()
	{
		return SeriesUpdateScope::ThisInstance;
	}
}
?>
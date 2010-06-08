<?php
require_once(ROOT_DIR . 'Presenters/ReservationSavePresenter.php');
require_once(ROOT_DIR . 'Pages/ReservationSavePage.php');
require_once(ROOT_DIR . 'lib/Reservation/namespace.php');

class ReservationSavePresenterTests extends TestBase
{
	/**
	 * @var UserSession
	 */
	private $_user;

	/**
	 * @var int
	 */
	private $_userId;
	
	/**
	 * @var IReservationSavePage
	 */
	private $_page;

	public function setup()
	{
		parent::setup();

		$this->_user = $this->fakeServer->UserSession;
		$this->_userId = $this->_user->UserId;
		
		$this->_page = $this->getMock('IReservationSavePage');
	}

	public function teardown()
	{
		parent::teardown();
	}
	
	public function testSaveCreatesReservation_AndValidates_AndPersists_AndNotifies_AndPresentsResultOnPage()
	{
		throw Exception("should there be one presenter per action?");
		
		$validationFactory = $this->getMock('IReservationValidationFactory');
		$validationService = $this->getMock('IReservationValidationService');
		$validationResult = new ReservationValidResult();
		
		$notificationFactory = $this->getMock('IReservationNotificationFactory');
		$notificationService = $this->getMock('IReservationNotificationService');
		
		$persistenceFactory->expects($this->once())
			->method('Create')
			->with($this->equalTo(ReservationAction::Create))
			->will($this->returnValue($persistenceService));
	
		$persistenceService->expects($this->once())
			->method('Load')
			->with($this->equalTo($reservationId))
			->will($this->returnValue($reservation));
		
		$validationFactory->expects($this->once())
			->method('Create')
			->with($this->equalTo(ReservationAction::Create))
			->will($this->returnValue($validationService));
		
		$validationService->expects($this->once())
			->method('Validate')
			->with($this->equalTo($reservation))
			->will($this->returnValue($validationResult));
		
		// apply updates
		
		$persistenceService->expects($this->once())
			->method('Update')
			->with($this->equalTo($reservation));
		
		$notificationFactory->expects($this->once())
			->method('Create')
			->with($this->equalTo(ReservationAction::Create))
			->will($this->returnValue($notificationService));
			
		$notificationService->expects($this->once())
			->method('Notify')
			->with($this->equalTo($reservation));	
			
		$this->_page->expects($this->once())
			->method('SetSaveSuccessfulMessage')
			->with($this->equalTo(true));
			
		$this->_page->expects($this->once())
			->method('ShowWarnings')
			->with($this->equalTo($validationResult->GetWarnings()));
						
		$presenter = new ReservationSavePresenter($page);
		$presenter->PageLoad();	
	}
}
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
	
	public function testSaveChecksBasicInformationAndPermissionAndAvailabilityAndOtherProvidedChecks()
	{
		$validationFactory = $this->getMock('IReservationValidationFactory');
		$validationService = $this->getMock('IReservationValidationService');
		$validationResult = new ReservationValidResult();
		
		$notificationFactory = $this->getMock('IReservationNotificationFactory');
		$notificationService = $this->getMock('IReservationNotificationService');
		
		$validationFactory->expects($this->once())
			->method('Create')
			->with($this->equalTo('createNew'))
			->will($this->returnValue($validationService));
		
		$validationService->expects($this->once())
			->method('Validate')
			->with($this->equalTo($reservation))
			->will($this->returnValue($validationResult));
			
		$notificationFactory->expects($this->once())
			->method('Create')
			->with($this->equalTo('createNew'))
			->will($this->returnValue($notificationService));
			
		$notificationService->expects($this->once())
			->method('Notify')
			->with($this->equalTo($reservation));	
			
		$this->_page->expects($this->once())
			->method('SetSaveSuccessfulMessage')
			->with($this->equalTo(true));
						
		$presenter = new ReservationSavePresenter($page);
		$presenter->PageLoad();	
	}
}
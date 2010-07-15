<?php
require_once(ROOT_DIR . 'Presenters/ReservationSavePresenter.php');
require_once(ROOT_DIR . 'Pages/Ajax/ReservationSavePage.php');
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
	
	public function testSaveWithMinimalData()
	{
		$userId = 120;
		$resourceId = 329;
		$title = 'title';
		$description = 'description';
		
		$startDate = '2010-04-10';
		$endDate = '2010-04-11';
		$startTime = '12:30';
		$endTime = '15:30';
		$timezone = $this->_user->Timezone;
		
		$duration = DateRange::Create($startDate . ' ' . $startTime, $endDate . ' ' . $endTime, $timezone);
		
		$persistenceFactory = $this->getMock('IReservationPersistenceFactory');
		$persistenceService = $this->getMock('IReservationPersistenceService');
		
		$reservation = $this->getMock('Reservation');
		$repeatOptions = $this->getMock('IRepeatOptions');
		
		$validationFactory = $this->getMock('IReservationValidationFactory');
		$validationService = $this->getMock('IReservationValidationService');
		$validationResult = new ReservationValidResult();
		
		$notificationFactory = $this->getMock('IReservationNotificationFactory');
		$notificationService = $this->getMock('IReservationNotificationService');
				
		$persistenceFactory->expects($this->once())
			->method('Create')
			->with($this->equalTo(ReservationAction::Create))
			->will($this->returnValue($persistenceService));
	
		$this->_page->expects($this->once())
			->method('GetReservationId')
			->will($this->returnValue(null));
			
		$this->_page->expects($this->once())
			->method('GetUserId')
			->will($this->returnValue($userId));
			
		$this->_page->expects($this->once())
			->method('GetResourceId')
			->will($this->returnValue($resourceId));
			
		$this->_page->expects($this->once())
			->method('GetTitle')
			->will($this->returnValue($title));
			
		$this->_page->expects($this->once())
			->method('GetDescription')
			->will($this->returnValue($description));
		
		$this->_page->expects($this->once())
			->method('GetStartDate')
			->will($this->returnValue($startDate));
		
		$this->_page->expects($this->once())
			->method('GetStartTime')
			->will($this->returnValue($startTime));
			
		$this->_page->expects($this->once())
			->method('GetEndDate')
			->will($this->returnValue($endDate));
		
		$this->_page->expects($this->once())
			->method('GetEndTime')
			->will($this->returnValue($endTime));
			
		$persistenceService->expects($this->once())
			->method('Load')
			->with($this->equalTo(null))
			->will($this->returnValue($reservation));
		
		$reservation->expects($this->once())
			->method('Update')
			->with($this->equalTo($userId), $this->equalTo($resourceId), $this->equalTo($title), $this->equalTo($description));
		
		$reservation->expects($this->once())
			->method('UpdateDuration')
			->with($this->equalTo($duration));
		
		$this->_page->expects($this->once())
			->method('GetRepeatOptions')
			->will($this->returnValue($repeatOptions));
			
		$reservation->expects($this->once())
			->method('Repeats')
			->with($this->equalTo($repeatOptions));
			
		$validationFactory->expects($this->once())
			->method('Create')
			->with($this->equalTo(ReservationAction::Create))
			->will($this->returnValue($validationService));
		
		$validationService->expects($this->once())
			->method('Validate')
			->with($this->equalTo($reservation))
			->will($this->returnValue($validationResult));
		
		$persistenceService->expects($this->once())
			->method('Persist')
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
						
		$presenter = new ReservationSavePresenter($this->_page, $persistenceFactory, $validationFactory, $notificationFactory);
		$presenter->PageLoad();	
	}
}
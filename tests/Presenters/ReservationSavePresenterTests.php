<?php
require_once(ROOT_DIR . 'Presenters/ReservationSavePresenter.php');
require_once(ROOT_DIR . 'Pages/Ajax/ReservationSavePage.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

class ReservationSavePresenterTests extends TestBase
{
	/**
	 * @var UserSession
	 */
	private $user;

	/**
	 * @var int
	 */
	private $userId;

	/**
	 * @var IReservationSavePage
	 */
	private $page;
	
	/**
	 * @var ReservationSavePresenter
	 */
	private $presenter;

	/**
	 * @var IReservationPersistenceFactory
	 */
	private $persistenceFactory;

	/**
	 * @var IReservationPersistenceService
	 */
	private $persistenceService;

	/**
	 * @var IReservationValidationFactory
	 */
	private $validationFactory;
	
	/**
	 * @var IReservationValidationService
	 */
	private $validationService;

	/**
	 * @var IReservationNotificationFactory
	 */
	private $notificationFactory;
	
	/**
	 * @var IReservationNotificationService
	 */
	private $notificationService;
	
	public function setup()
	{
		parent::setup();

		$this->user = $this->fakeServer->UserSession;
		$this->userId = $this->user->UserId;

		$this->page = new FakeReservationSavePage();

		$this->persistenceFactory = $this->getMock('IReservationPersistenceFactory');
		$this->persistenceService = $this->getMock('IReservationPersistenceService');

		$this->validationFactory = $this->getMock('IReservationValidationFactory');
		$this->validationService = $this->getMock('IReservationValidationService');
		
		$this->notificationFactory = $this->getMock('IReservationNotificationFactory');
		$this->notificationService = $this->getMock('IReservationNotificationService');
		
		$this->presenter = new ReservationSavePresenter($this->page, $this->persistenceFactory, $this->validationFactory, $this->notificationFactory);
	}

	public function teardown()
	{
		parent::teardown();
	}

	public function testBuildingWhenCreationBuildsReservationFromPageData()
	{
		throw new Exception("change this presenter to be custom to create/update/delete");
		$timezone = $this->user->Timezone;
		
		$userId = $this->page->GetUserId();
		$resourceId = $this->page->GetResourceId();
		$scheduleId = $this->page->GetScheduleId();
		$title = $this->page->GetTitle();
		$description = $this->page->GetDescription();

		$startDate = $this->page->GetStartDate();
		$endDate = $this->page->GetEndDate();
		$startTime = $this->page->GetStartTime();
		$endTime = $this->page->GetEndTime();
		$additionalResources = $this->page->GetResources();

		$reservationAction = $this->page->GetReservationAction();
		$repeatOptions = $this->page->GetRepeatOptions(null);
		$seriesUpdateScope = $this->page->GetSeriesUpdateScope();
		
		$duration = DateRange::Create($startDate . ' ' . $startTime, $endDate . ' ' . $endTime, $timezone);
		
		$reservation = $this->getMock('ReservationSeries');
		
		$this->persistenceFactory->expects($this->once())
			->method('Create')
			->with($this->equalTo($reservationAction))
			->will($this->returnValue($this->persistenceService));

		$this->persistenceService->expects($this->once())
			->method('Load')
			->with($this->equalTo(null))
			->will($this->returnValue($reservation));

		$reservation->expects($this->once())
			->method('Update')
			->with( $this->equalTo($userId),
					$this->equalTo($resourceId),
					$this->equalTo($scheduleId),
					$this->equalTo($title),
					$this->equalTo($description));

		$reservation->expects($this->once())
			->method('UpdateDuration')
			->with($this->equalTo($duration));
				
		$reservation->expects($this->once())
			->method('Repeats')
			->with($this->equalTo($repeatOptions));
		
		$reservation->expects($this->once())
			->method('ApplyChangesTo')
			->with($this->equalTo($seriesUpdateScope));

		$actualReservation = $this->presenter->BuildReservation();
		
		$this->assertEquals($reservation, $actualReservation);
	}

	public function testHandlingReservationCreationDelegatesToServicesForValidationAndPersistanceAndNotification()
	{
		$action = $this->page->GetReservationAction();
		
		$reservation = $this->getMock('ReservationSeries');
		$instance = new Reservation($reservation, NullDateRange::Instance());
		$validationResult = new ReservationValidationResult();
			
		$this->validationFactory->expects($this->once())
			->method('Create')
			->with($this->equalTo($action))
			->will($this->returnValue($this->validationService));

		$this->validationService->expects($this->once())
			->method('Validate')
			->with($this->equalTo($reservation))
			->will($this->returnValue($validationResult));

		$this->persistenceFactory->expects($this->once())
			->method('Create')
			->with($this->equalTo($action))
			->will($this->returnValue($this->persistenceService));
			
		$this->persistenceService->expects($this->once())
			->method('Persist')
			->with($this->equalTo($reservation));

		$this->notificationFactory->expects($this->once())
			->method('Create')
			->with($this->equalTo($action))
			->will($this->returnValue($this->notificationService));
			
		$this->notificationService->expects($this->once())
			->method('Notify')
			->with($this->equalTo($reservation));

		$reservation->expects($this->once())
			->method('GetInstance')
			->with($this->anything())
			->will($this->returnValue($instance));
			
		$this->presenter->HandleReservation($reservation);
		
		$this->assertEquals(true, $this->page->saveSuccessful);
		$this->assertEquals($validationResult->GetWarnings(), $this->page->warnings);
	}
	
	public function testPreventsPersistenceAndNotificationAndShowsFailedMessageWhenValidationFails()
	{
		$errorMessage1 = 'e1';
		$errorMessage2 = 'e2';
		$errors = array($errorMessage1, $errorMessage2);
		$action = $this->page->GetReservationAction();
		
		$reservation = new ReservationSeries();
		$validationResult = new ReservationValidationResult(false, $errors);	
		
		$this->validationFactory->expects($this->once())
			->method('Create')
			->with($this->equalTo($action))
			->will($this->returnValue($this->validationService));

		$this->validationService->expects($this->once())
			->method('Validate')
			->with($this->equalTo($reservation))
			->will($this->returnValue($validationResult));
		
		$this->persistenceFactory->expects($this->never())
			->method('Create');

		$this->notificationFactory->expects($this->never())
			->method('Create');
					
		$this->presenter->HandleReservation($reservation);
		
		$this->assertEquals(false, $this->page->saveSuccessful);
		$this->assertEquals($errors, $this->page->errors);
	}
}

class FakeReservationSavePage implements IReservationSavePage
{
	public $action = ReservationAction::Create;
	public $reservationId = 100;
	public $userId = 110;
	public $resourceId = 120;
	public $scheduleId = 123;
	public $title = 'title';
	public $description = 'description';
	public $startDate = '2010-01-01';
	public $endDate = '2010-01-02';
	public $startTime = '05:30';
	public $endTime = '04:00';
	public $resourceIds = array(11, 22);
	public $repeatType = RepeatType::Daily;
	public $repeatInterval = 2;
	public $repeatWeekdays = array(0, 1, 2);
	public $repeatMonthlyType = RepeatMonthlyType::DayOfMonth;
	public $repeatTerminationDate = '2010-10-10';
	public $repeatOptions;
	public $saveSuccessful = false;
	public $errors = array();
	public $warnings = array();
	
	public function __construct()
	{
		$this->repeatOptions = new RepeatNone();
	}
	
	public function GetReservationAction()
	{
		return $this->action;
	}

	public function GetReservationId()
	{
		return $this->reservationid;
	}
	
	public function GetUserId()
	{
		return $this->userId;
	}
	
	public function GetResourceId()
	{
		return $this->resourceId;
	}
	
	public function GetScheduleId()
	{
		return $this->scheduleId;
	}
	
	public function GetTitle()
	{
		return $this->title;
	}
	
	public function GetDescription()
	{
		return $this->description;
	}
	
	public function GetStartDate()
	{
		return $this->startDate;
	}
	
	public function GetEndDate()
	{
		return $this->endDate;
	}
	
	public function GetStartTime()
	{
		return $this->startTime;
	}
	
	public function GetEndTime()
	{
		return $this->endTime;
	}
	
	public function GetResources()
	{
		return $this->resourceIds;
	}
	
	public function GetRepeatType()
	{
		return $this->repeatType;
	}
	
	public function GetRepeatInterval()
	{
		return $this->repeatInterval;
	}
	
	public function GetRepeatWeekdays()
	{
		return $this->repeatWeekdays;
	}
	
	public function GetRepeatMonthlyType()
	{
		return $this->repeatMonthlyType;
	}
	
	public function GetRepeatTerminationDate()
	{
		return $this->repeatTerminationDate;
	}

	public function GetRepeatOptions($initialReservationDates)
	{
		return $this->repeatOptions;
	}
	
	public function GetSeriesUpdateScope()
	{
		return SeriesUpdateScope::ThisInstance;
	}
	
	public function SetSaveSuccessfulMessage($succeeded)
	{
		$this->saveSuccessful = $succeeded;
	}
	
	public function SetReferenceNumber($referenceNumber)
	{}
	
	public function ShowErrors($errors)
	{
		$this->errors = $errors;
	}
	
	public function ShowWarnings($warnings)
	{
		$this->warnings = $warnings;
	}
}
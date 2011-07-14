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
	 * @var IReservationPersistenceService
	 */
	private $persistenceService;
	
	/**
	 * @var IReservationValidationService
	 */
	private $validationService;
	
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

		$this->persistenceService = $this->getMock('IReservationPersistenceService');
		$this->validationService = $this->getMock('IReservationValidationService');
		$this->notificationService = $this->getMock('IReservationNotificationService');
		
		$this->presenter = new ReservationSavePresenter($this->page, $this->persistenceService, $this->validationService, $this->notificationService);
	}

	public function teardown()
	{
		parent::teardown();
	}

	public function testBuildingWhenCreationBuildsReservationFromPageData()
	{
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

		$repeatOptions = $this->page->GetRepeatOptions();

		$participants = $this->page->GetParticipants();
		
		$duration = DateRange::Create($startDate . ' ' . $startTime, $endDate . ' ' . $endTime, $timezone);
		
		$expected = ReservationSeries::Create($userId, $resourceId, $scheduleId, $title, $description, $duration, $repeatOptions);
		$expected->AddResource($additionalResources[0]);
		$expected->AddResource($additionalResources[1]);
		$expected->ChangeParticipants($participants);

		$actualReservation = $this->presenter->BuildReservation();
		
		$this->assertEquals($userId, $actualReservation->UserId());
		$this->assertEquals($resourceId, $actualReservation->ResourceId());
		$this->assertEquals($scheduleId, $actualReservation->ScheduleId());
		$this->assertEquals($title, $actualReservation->Title());
		$this->assertEquals($description, $actualReservation->Description());
		$this->assertEquals($duration, $actualReservation->CurrentInstance()->Duration());
		$this->assertEquals($repeatOptions, $actualReservation->RepeatOptions());
		$this->assertEquals($participants, $actualReservation->AddedParticipants());
	}

	public function testHandlingReservationCreationDelegatesToServicesForValidationAndPersistanceAndNotification()
	{
		$series = new TestReservationSeries();
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

		$this->presenter->HandleReservation($series);
		
		$this->assertEquals(true, $this->page->saveSuccessful);
		$this->assertEquals($validationResult->GetWarnings(), $this->page->warnings);
		$this->assertEquals($instance->ReferenceNumber(), $this->page->referenceNumber);
	}
	
	public function testPreventsPersistenceAndNotificationAndShowsFailedMessageWhenValidationFails()
	{
		$errorMessage1 = 'e1';
		$errorMessage2 = 'e2';
		$errors = array($errorMessage1, $errorMessage2);
		
		$reservation = new TestReservationSeries();
		$validationResult = new ReservationValidationResult(false, $errors);

		$this->validationService->expects($this->once())
			->method('Validate')
			->with($this->equalTo($reservation))
			->will($this->returnValue($validationResult));
		
		$this->persistenceService->expects($this->never())
			->method('Persist');

		$this->notificationService->expects($this->never())
			->method('Notify');
					
		$this->presenter->HandleReservation($reservation);
		
		$this->assertEquals(false, $this->page->saveSuccessful);
		$this->assertEquals($errors, $this->page->errors);
	}
}

class FakeReservationSavePage implements IReservationSavePage
{
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
	public $referenceNumber;
	public $participants = array(1, 2, 4);
	
	public function __construct()
	{
		$this->repeatOptions = new RepeatNone();
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

	public function GetRepeatOptions()
	{
		return $this->repeatOptions;
	}
	
	public function SetSaveSuccessfulMessage($succeeded)
	{
		$this->saveSuccessful = $succeeded;
	}
	
	public function SetReferenceNumber($referenceNumber)
	{
		$this->referenceNumber = $referenceNumber;
	}
	
	public function ShowErrors($errors)
	{
		$this->errors = $errors;
	}
	
	public function ShowWarnings($warnings)
	{
		$this->warnings = $warnings;
	}

	public function GetParticipants()
	{
		return $this->participants;
	}
}
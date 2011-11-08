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
	 * @var IReservationSavePage|FakeReservationSavePage
	 */
	private $page;
	
	/**
	 * @var ReservationSavePresenter
	 */
	private $presenter;

	/**
	 * @var IReservationPersistenceService|PHPUnit_Framework_MockObject_MockObject
	 */
	private $persistenceService;
	
	/**
	 * @var IReservationHandler|PHPUnit_Framework_MockObject_MockObject
	 */
	private $handler;

	/**
	 * @var IResourceRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $resourceRepository;
	
	public function setup()
	{
		parent::setup();

		$this->user = $this->fakeServer->UserSession;
		$this->userId = $this->user->UserId;

		$this->page = new FakeReservationSavePage();

		$this->persistenceService = $this->getMock('IReservationPersistenceService');
		$this->handler = $this->getMock('IReservationHandler');
		$this->resourceRepository = $this->getMock('IResourceRepository');
		
		$this->presenter = new ReservationSavePresenter(
			$this->page,
			$this->persistenceService,
			$this->handler,
			$this->resourceRepository);
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
		$title = $this->page->GetTitle();
		$description = $this->page->GetDescription();

		$startDate = $this->page->GetStartDate();
		$endDate = $this->page->GetEndDate();
		$startTime = $this->page->GetStartTime();
		$endTime = $this->page->GetEndTime();
		$additionalResources = $this->page->GetResources();
		$pageAccessories = $this->page->GetAccessories();

		$repeatOptions = $this->page->GetRepeatOptions();

		$participants = $this->page->GetParticipants();
		$invitees = $this->page->GetInvitees();

		$resource = new FakeBookableResource($resourceId, 'r1');
		$additionalResource1 = new FakeBookableResource($additionalResources[0], 'r2');
		$additionalResource2 = new FakeBookableResource($additionalResources[1], 'r3');

		$accessories = array();
		foreach ($pageAccessories as $pa)
		{
			$accessories[] = new ReservationAccessory($pa->Id, $pa->Quantity);
		}
		
		$this->resourceRepository->expects($this->at(0))
			->method('LoadById')
			->with($this->equalTo($resourceId))
			->will($this->returnValue($resource));

		$this->resourceRepository->expects($this->at(1))
			->method('LoadById')
			->with($this->equalTo($additionalResources[0]))
			->will($this->returnValue($additionalResource1));

		$this->resourceRepository->expects($this->at(2))
			->method('LoadById')
			->with($this->equalTo($additionalResources[1]))
			->will($this->returnValue($additionalResource2));

		$duration = DateRange::Create($startDate . ' ' . $startTime, $endDate . ' ' . $endTime, $timezone);

		$actualReservation = $this->presenter->BuildReservation();
		
		$this->assertEquals($userId, $actualReservation->UserId());
		$this->assertEquals($resourceId, $actualReservation->ResourceId());
		$this->assertEquals($title, $actualReservation->Title());
		$this->assertEquals($description, $actualReservation->Description());
		$this->assertEquals($duration, $actualReservation->CurrentInstance()->Duration());
		$this->assertEquals($repeatOptions, $actualReservation->RepeatOptions());
		$this->assertEquals($participants, $actualReservation->CurrentInstance()->AddedParticipants());
		$this->assertEquals($invitees, $actualReservation->CurrentInstance()->AddedInvitees());
		$this->assertEquals($accessories, $actualReservation->Accessories());
	}

	public function testHandlingReservationCreationDelegatesToHandler()
	{
		$series = new TestReservationSeries();
		$instance = new Reservation($series, NullDateRange::Instance());
		$series->WithCurrentInstance($instance);

		$this->handler->expects($this->once())
			->method('Handle')
			->with($this->equalTo($series), $this->isInstanceOf('FakeReservationSavePage'))
			->will($this->returnValue(true));

		$this->presenter->HandleReservation($series);
		
		$this->assertEquals($instance->ReferenceNumber(), $this->page->referenceNumber);
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
	public $participants = array(10, 20, 40);
	public $invitees = array(11, 21, 41);
	public $accessories = array();

	public function __construct()
	{
		$now = Date::Now();
		$this->startDate = $now->AddDays(5)->Format('Y-m-d');
		$this->endDate = $now->AddDays(6)->Format('Y-m-d');
		$this->repeatTerminationDate = $now->AddDays(60)->Format('Y-m-d');
		$this->repeatOptions = new RepeatNone();
		$this->accessories = array(new FakeAccessoryFormElement(1, 2));
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

	public function GetInvitees()
	{
		return $this->invitees;
	}

	/**
	 * @return AccessoryFormElement[]
	 */
	public function GetAccessories()
	{
		return $this->accessories;
	}
}

class FakeAccessoryFormElement extends AccessoryFormElement
{
	public function __construct($id, $quantity)
	{
		$this->Id = $id;
		$this->Quantity = $quantity;
	}
}
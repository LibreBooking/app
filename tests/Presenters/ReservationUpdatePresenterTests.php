<?php
require_once(ROOT_DIR . 'Presenters/ReservationUpdatePresenter.php');
require_once(ROOT_DIR . 'Pages/Ajax/ReservationUpdatePage.php');
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
	 * @var IUpdateReservationPersistenceService
	 */
	private $persistenceService;
	
	/**
	 * @var IUpdateReservationValidationService
	 */
	private $validationService;
	
	/**
	 * @var IUpdateReservationNotificationService
	 */
	private $notificationService;

	/**
	 * @var IResourceRepository
	 */
	private $resourceRepository;

	/**
	 * @var ReservationUpdatePresenter
	 */
	private $presenter;
	
	public function setup()
	{
		parent::setup();
		
		$this->user = $this->fakeServer->UserSession;
		$this->userId = $this->user->UserId;
		
		$this->persistenceService = $this->getMock('IUpdateReservationPersistenceService');
		$this->validationService = $this->getMock('IUpdateReservationValidationService');
		$this->notificationService = $this->getMock('IUpdateReservationNotificationService');
		$this->resourceRepository = $this->getMock('IResourceRepository');

		$this->page = new FakeReservationUpdatePage();
		
		$this->presenter = new ReservationUpdatePresenter(
								$this->page, 
								$this->persistenceService, 
								$this->validationService, 
								$this->notificationService,
								$this->resourceRepository);
	}
	
	public function teardown()
	{
		parent::teardown();
	}
	
	public function testLoadsExistingReservationAndUpdatesData()
	{
		$seriesId = 109809;
		$expectedSeries = new ExistingReservationSeries();	
		$currentDuration = new DateRange(Date::Now()->AddDays(1), Date::Now()->AddDays(2), 'UTC');
		$removedResourceId = 190;

		$resource = new FakeBookableResource(1);
		$additionalId1 = $this->page->resourceIds[0];
		$additionalId2 = $this->page->resourceIds[1];
		$additional1 = new FakeBookableResource($additionalId1);
		$additional2 = new FakeBookableResource($additionalId2);

		$reservation = new Reservation($expectedSeries, $currentDuration);		
		$expectedSeries->WithId($seriesId);
		$expectedSeries->WithCurrentInstance($reservation);
		$expectedSeries->WithResource(new FakeBookableResource($removedResourceId));
		
		$reservationId = $this->page->reservationId;
		
		$timezone = $this->user->Timezone;
		
		$this->persistenceService->expects($this->once())
			->method('LoadByInstanceId')
			->with($this->equalTo($reservationId))
			->will($this->returnValue($expectedSeries));

		$this->resourceRepository->expects($this->at(0))
			->method('LoadById')
			->with($this->equalTo($this->page->resourceId))
			->will($this->returnValue($resource));

		$this->resourceRepository->expects($this->at(1))
			->method('LoadById')
			->with($this->equalTo($additionalId1))
			->will($this->returnValue($additional1));

		$this->resourceRepository->expects($this->at(2))
			->method('LoadById')
			->with($this->equalTo($additionalId2))
			->will($this->returnValue($additional2));

		$this->page->repeatOptions = new RepeatDaily(1, Date::Now());
			
		$expectedDuration = DateRange::Create(
			$this->page->GetStartDate() . " " . $this->page->GetStartTime(),
			$this->page->GetEndDate() . " " . $this->page->GetEndTime(),
			$timezone);
			
		$existingSeries = $this->presenter->BuildReservation();

		$this->assertEquals($seriesId, $existingSeries->SeriesId());
		$this->assertEquals($this->page->seriesUpdateScope, $existingSeries->SeriesUpdateScope());
		$this->assertEquals($this->page->title, $existingSeries->Title());
		$this->assertEquals($this->page->description, $existingSeries->Description());
		$this->assertEquals($this->page->userId, $existingSeries->UserId());
		$this->assertEquals($resource, $existingSeries->Resource());
		$this->assertEquals($this->page->repeatOptions, $existingSeries->RepeatOptions());
		$this->assertEquals(array($additional1, $additional2), $existingSeries->AdditionalResources());
		$this->assertEquals($this->page->participants, $existingSeries->CurrentInstance()->AddedParticipants());
		$this->assertEquals($this->page->invitees, $existingSeries->CurrentInstance()->AddedInvitees());
		$this->assertTrue($expectedDuration->Equals($existingSeries->CurrentInstance()->Duration()), "Expected: $expectedDuration Actual: {$existingSeries->CurrentInstance()->Duration()}");
	}
	
	public function testHandlingReservationCreationDelegatesToServicesForValidationAndPersistenceAndNotification()
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
		
		$builder = new ExistingReservationSeriesBuilder();
		$series = $builder->Build();
		
		$validationResult = new ReservationValidationResult(false, $errors);

		$this->validationService->expects($this->once())
			->method('Validate')
			->with($this->equalTo($series))
			->will($this->returnValue($validationResult));
		
		$this->persistenceService->expects($this->never())
			->method('Persist');

		$this->notificationService->expects($this->never())
			->method('Notify');
					
		$this->presenter->HandleReservation($series);
		
		$this->assertEquals(false, $this->page->saveSuccessful);
		$this->assertEquals($errors, $this->page->errors);
	}

}

class FakeReservationUpdatePage extends FakeReservationSavePage implements IReservationUpdatePage
{
	public $reservationId = 100;
	public $seriesUpdateScope = SeriesUpdateScope::FullSeries;

	public function __construct()
	{
	    parent::__construct();
	}
	
	public function GetReservationId()
	{
		return $this->reservationId;
	}
	
	public function GetSeriesUpdateScope()
	{
		return $this->seriesUpdateScope;
	}
}
?>
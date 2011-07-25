<?php
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

require_once(ROOT_DIR . 'Pages/ReservationPage.php');
require_once(ROOT_DIR . 'Pages/NewReservationPage.php');
require_once(ROOT_DIR . 'Pages/ExistingReservationPage.php');

require_once(ROOT_DIR . 'lib/Application/Reservation/ExistingReservationInitializer.php');

class ExistingReservationInitializerTests extends TestBase
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
	 * @var IScheduleRepository
	 */
	private $_scheduleRepository;
	
	/**
	 * @var IScheduleUserRepository
	 */
	private $_scheduleUserRepository;

	/**
	 * @var IUserRepository
	 */
	private $_userRepository;
	
	public function setup()
	{
		parent::setup();

		$this->_user = $this->fakeServer->UserSession;
		$this->_userId = $this->_user->UserId;

		$this->_scheduleRepository = $this->getMock('IScheduleRepository');
		$this->_scheduleUserRepository = $this->getMock('IScheduleUserRepository');
		$this->_userRepository = $this->GetMock('IUserRepository');
	}

	public function teardown()
	{
		parent::teardown();
	}
	
	public function testExistingReservationIsLoadedAndBoundToView()
	{
		$referenceNumber = '1234';
		$timezone = $this->_user->Timezone;

		$reservationId = 928;
		$resourceId = 10;
		$scheduleId = 100;
		$startDateUtc = '2010-01-01 10:11:12';
		$endDateUtc = '2010-01-02 10:11:12';
		$ownerId = 987;
		$additionalResourceIds = array (10, 20, 30);	
		$participants = array (
			new ReservationUserView(10, 'p1', 'l', null, ReservationUserLevel::PARTICIPANT),
			new ReservationUserView(11, 'p2', 'l', null, ReservationUserLevel::PARTICIPANT)
		);
		$invitees = array (
			new ReservationUserView($this->_userId, 'i1', 'l', null, ReservationUserLevel::INVITEE),
			new ReservationUserView(110, 'i2', 'l', null, ReservationUserLevel::INVITEE)
		);
		$title = 'title';
		$description = 'description';

		$firstName = 'fname';
		$lastName = 'lastName';
		
		$repeatType = RepeatType::Monthly;
		$repeatInterval = 2;
		$repeatWeekdays = array(1, 2, 3);
		$repeatMonthlyType = 'dayOfMonth';
		$repeatTerminationDate = Date::Parse('2010-01-04', 'UTC');

		$expectedStartDate = Date::Parse($startDateUtc, 'UTC');
		$expectedEndDate = Date::Parse($endDateUtc, 'UTC');	
				
		$reservationView = new ReservationView();
		$reservationView->ReservationId = $reservationId;
		$reservationView->ReferenceNumber = $referenceNumber;
		$reservationView->ResourceId = $resourceId;
		$reservationView->ScheduleId = $scheduleId;
		$reservationView->StartDate = $expectedStartDate;
		$reservationView->EndDate = $expectedEndDate;
		$reservationView->OwnerId = $ownerId;
		$reservationView->OwnerFirstName = $firstName;
		$reservationView->OwnerLastName = $lastName;
		$reservationView->AdditionalResourceIds = $additionalResourceIds;
		$reservationView->Participants = $participants;
		$reservationView->Invitees = $invitees;
		$reservationView->Title = $title;
		$reservationView->Description = $description;
		$reservationView->RepeatType = $repeatType;
		$reservationView->RepeatInterval = $repeatInterval;
		$reservationView->RepeatWeekdays = $repeatWeekdays;
		$reservationView->RepeatMonthlyType = $repeatMonthlyType;
		$reservationView->RepeatTerminationDate = $repeatTerminationDate;
		
		$page = $this->getMock('IExistingReservationPage');
		
		// DATA			
		// users
		$schedUser = new UserDto($ownerId, $firstName, $lastName, 'email');

		$this->_userRepository->expects($this->once())
			->method('GetById')
			->with($ownerId)
			->will($this->returnValue($schedUser));
			
		// resources
		$schedResource = new ScheduleResource($resourceId, 'resource 1');
		$otherResource = new ScheduleResource(2, 'resource 2');
		$resourceList = array($otherResource, $schedResource);
		$scheduleUser = $this->getMock('IScheduleUser');

		$this->_scheduleUserRepository->expects($this->once())
			->method('GetUser')
			->with($this->equalTo($ownerId))
			->will($this->returnValue($scheduleUser));
			
		$scheduleUser->expects($this->once())
			->method('GetAllResources')
			->will($this->returnValue($resourceList));
			
		// periods
		$periods = array(new SchedulePeriod($expectedStartDate->SetTime(new Time(1, 0, 0)), $expectedStartDate->SetTime(new Time(2, 0, 0))));
		$layout = $this->getMock('IScheduleLayout');

		$this->_scheduleRepository->expects($this->once())
			->method('GetLayout')
			->with($this->equalTo($scheduleId), $this->equalTo(new ReservationLayoutFactory($timezone)))
			->will($this->returnValue($layout));
			
		$layout->expects($this->once())
			->method('GetLayout')
			->with($this->equalTo($expectedStartDate->ToTimezone($timezone)))
			->will($this->returnValue($periods));
		
		// BINDING
		$page->expects($this->once())
			->method('BindPeriods')
			->with($this->equalTo($periods));

		$resourceListWithoutReservationResource = array($otherResource);
		$page->expects($this->once())
			->method('BindAvailableResources')
			->with($this->equalTo($resourceListWithoutReservationResource));
		
		// Reservation Data
		
		$page->expects($this->once())
			->method('SetReservationUser')
			->with($this->equalTo($schedUser));
			
		$page->expects($this->once())
			->method('SetReservationResource')
			->with($this->equalTo($schedResource));
		
		$page->expects($this->once())
			->method('SetAdditionalResources')
			->with($this->equalTo($additionalResourceIds));
		
		$page->expects($this->once())
			->method('SetParticipants')
			->with($this->equalTo($participants));

		$page->expects($this->once())
			->method('SetInvitees')
			->with($this->equalTo($invitees));
		
		$page->expects($this->once())
			->method('SetTitle')
			->with($this->equalTo($title));
		
		$page->expects($this->once())
			->method('SetDescription')
			->with($this->equalTo($description));
		
		$page->expects($this->once())
			->method('SetSelectedStart')
			->with($this->equalTo($expectedStartDate->ToTimezone($timezone)));

		$page->expects($this->once())
			->method('SetSelectedEnd')
			->with($this->equalTo($expectedEndDate->ToTimezone($timezone)));
			
		$page->expects($this->once())
			->method('SetRepeatType')
			->with($this->equalTo($repeatType));
			
		$page->expects($this->once())
			->method('SetRepeatInterval')
			->with($this->equalTo($repeatInterval));
			
		$page->expects($this->once())
			->method('SetRepeatMonthlyType')
			->with($this->equalTo($repeatMonthlyType));
			
		$page->expects($this->any())
			->method('SetRepeatTerminationDate')
			->with($this->anything());
		
		$page->expects($this->once())
			->method('SetRepeatWeekdays')
			->with($this->equalTo($repeatWeekdays));
		
		$isEditable = true;
		
		$editableCriteria = $this->getMock('IEditableCriteria');
		$editableCriteria->expects($this->once())
			->method('IsEditable')
			->with($this->equalTo($reservationView))
			->will($this->returnValue($isEditable));

		$isParticipating = false;
		$page->expects($this->once())
			->method('SetCurrentUserParticipating')
			->with($this->equalTo($isParticipating));

		$isInvited = true;
		$page->expects($this->once())
			->method('SetCurrentUserInvited')
			->with($this->equalTo($isInvited));
		
		$initializer = new ExistingReservationInitializer(
			$page, 
			$this->_scheduleUserRepository, 
			$this->_scheduleRepository, 
			$this->_userRepository,
			$reservationView,
			$editableCriteria);
			
		$initializer->Initialize();
	}
	
	public function testPageIsEditableIfReservationHasNotEnded()
	{
		$endsInFuture = Date::Now()->AddDays(1);
		
		$criteria = new EditableViewCriteria();
		
		$reservationView = new ReservationView();
		$reservationView->OwnerId = $this->_userId;
		$reservationView->EndDate = $endsInFuture;
		
		$isEditable = $criteria->IsEditable($reservationView);
		
		$this->assertTrue($isEditable);
	}
	
	public function testPageIsNotEditableIfReservationHasEnded()
	{
		$endsInPast = Date::Now()->AddDays(-1);
		
		$criteria = new EditableViewCriteria();
		
		$reservationView = new ReservationView();
		$reservationView->OwnerId = $this->_userId;
		$reservationView->EndDate = $endsInPast;
		
		$isEditable = $criteria->IsEditable($reservationView);
		
		$this->assertFalse($isEditable);	
	}
	
	public function testPageIsNotEditableIfCurrentUserIsNotTheOwner()
	{
		$endsInPast = Date::Now()->AddDays(-1);
		
		$criteria = new EditableViewCriteria();
		
		$reservationView = new ReservationView();
		$reservationView->OwnerId = 92929;
		$reservationView->EndDate = $endsInPast;
		
		$isEditable = $criteria->IsEditable($reservationView);
		
		$this->assertFalse($isEditable);
	}
	
	public function testPageIsEditableIfCurrentUserIsAnAdmin()
	{
		$endsInFuture = Date::Now()->AddDays(1);
		$this->_user->IsAdmin = true;
		
		$criteria = new EditableViewCriteria();
		
		$reservationView = new ReservationView();
		$reservationView->OwnerId = 92929;
		$reservationView->EndDate = $endsInFuture;
		
		$isEditable = $criteria->IsEditable($reservationView);
		
		$this->assertTrue($isEditable);
	}
}
?>
<?php
require_once(ROOT_DIR . 'Presenters/ReservationPresenter.php');
require_once(ROOT_DIR . 'Pages/ReservationPage.php');

class ReservationPresenterTests extends TestBase
{
	//TODO: Inject some sort of ReservationPageSetup to populate selected values? 
	// (INewReservationPage, IExistingReservationPage w/ GetStartDate(), etc)
	
	public function setup()
	{
		parent::setup();
	}

	public function teardown()
	{
		parent::teardown();
	}
	
	public function testPageLoadSetsDefaultsForSelectedUserAndResourceAndDate()
	{
		$user = $this->fakeServer->UserSession;
		$userId = $user->UserId;
		$timezone = $user->Timezone;
		
		$resourceId = 10;
		$scheduleId = 100;
		$dateInUserTimezone = '2010-01-01';
		$periodId = 1;
		
		$firstName = 'fname';
		$lastName = 'lastName';
		
		$expectedStartDate = Date::Parse($dateInUserTimezone, $timezone);
		$expectedEndDate = Date::Parse($dateInUserTimezone, $timezone);
		
		$page = $this->getMock('IReservationPage');
		
		$page->expects($this->once())
			->method('GetRequestedResourceId')
			->will($this->returnValue($resourceId));
			
		$page->expects($this->once())
			->method('GetRequestedScheduleId')
			->will($this->returnValue($scheduleId));
		
		$page->expects($this->once())
			->method('GetRequestedDate')
			->will($this->returnValue($dateInUserTimezone));
			
		$page->expects($this->once())
			->method('GetRequestedPeriod')
			->will($this->returnValue($periodId));
		
		// DATA
			// users
		$schedUser = new UserDto($userId, $firstName, $lastName);
		$otherUser = new UserDto(109, 'other', 'user');
		$userList = array($otherUser, $schedUser);
		$userRepository = $this->GetMock('IUserRepository');
		$userRepository->expects($this->once())
			->method('GetAll')
			->will($this->returnValue($userList));
			
			// resources
		$schedResource = new ScheduleResource($resourceId, 'resource 1');
		$otherResource = new ScheduleResource(2, 'resource 2');
		$resourceList = array($otherResource, $schedResource);
		$scheduleUser = $this->getMock('IScheduleUser');
		$scheduleUserRepository = $this->getMock('IScheduleUserRepository');
		
		$scheduleUserRepository->expects($this->once())
			->method('GetUser')
			->with($this->equalTo($userId))
			->will($this->returnValue($scheduleUser));
			
		$scheduleUser->expects($this->once())
			->method('GetAllResources')
			->will($this->returnValue($resourceList));
			
			// periods
		$periods = array(new SchedulePeriod(new Time(1, 0, 0), new Time(2, 0, 0)));
		$layout = $this->getMock('IScheduleLayout');
		$scheduleRepository = $this->getMock('IScheduleRepository');
		$scheduleRepository->expects($this->once())
			->method('GetLayout')
			->with($this->equalTo($scheduleId), $this->equalTo($user->Timezone))
			->will($this->returnValue($layout));
			
		$layout->expects($this->once())
			->method('GetLayout')
			->will($this->returnValue($periods));
		
		// BINDING
		$page->expects($this->once())
			->method('BindPeriods')
			->with($this->equalTo($periods));

		$resourceListWithoutReservationResource = array($otherResource);
		$page->expects($this->once())
			->method('BindAvailableResources')
			->with($this->equalTo($resourceListWithoutReservationResource));
		
		$userListWithoutReservationOwner = array($otherUser);
		$page->expects($this->once())
			->method('BindAvailableUsers')
			->with($this->equalTo($userListWithoutReservationOwner));
			
		// SETUP
		$page->expects($this->once())
			->method('SetStartDate')
			->with($this->equalTo($expectedStartDate));
		
		$page->expects($this->once())
			->method('SetEndDate')
			->with($this->equalTo($expectedEndDate));
		
		$page->expects($this->once())
			->method('SetStartPeriod')
			->with($this->equalTo($periodId));
		
		$page->expects($this->once())
			->method('SetEndPeriod')
			->with($this->equalTo($periodId));
		
		$page->expects($this->once())
			->method('SetReservationUserName')
			->with($this->equalTo("$firstName $lastName"));
		
		$page->expects($this->once())
			->method('SetReservationResource')
			->with($this->equalTo($schedResource));	// may want this to be a real object
		
		$presenter = new ReservationPresenter($page, $scheduleUserRepository, $scheduleRepository, $userRepository);
		
		$presenter->PageLoad();
	}
}
?>
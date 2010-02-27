<?php
require_once(ROOT_DIR . 'Presenters/ReservationPresenter.php');
require_once(ROOT_DIR . 'Pages/ReservationPage.php');

class ReservationPresenterTests extends TestBase
{
	//TODO: Inject some sort of ReservationPageSetup to populate selected values?
	// (INewReservationPage, IExistingReservationPage w/ GetStartDate(), etc)

	/**
	 * @var UserSession
	 */
	private $_user;

	/**
	 * @var int
	 */
	private $_userId;

	/**
	 * @var IPermissionServiceFactory
	 */
	private $_permissionServiceFactory;

	/**
	 * @var IPermissionService
	 */
	private $_permissionService;
	
	/**
	 * @var IScheduleRepository
	 */
	private $_scheduleRepository;
	
	/**
	 * @var IScheduleUserRepository
	 */
	private $_scheduleUserRepository;

	public function setup()
	{
		parent::setup();

		$this->_user = $this->fakeServer->UserSession;
		$this->_userId = $this->_user->UserId;

		$this->_permissionServiceFactory = $this->getMock('IPermissionServiceFactory');
		$this->_permissionService = $this->getMock('IPermissionService');
		$this->_scheduleRepository = $this->getMock('IScheduleRepository');
		$this->_scheduleUserRepository = $this->getMock('IScheduleUserRepository');
		$this->_userRepository = $this->GetMock('IUserRepository');
				
		$this->_permissionServiceFactory->expects($this->once())
			->method('GetPermissionService')
			->with($this->equalTo($this->_userId))
			->will($this->returnValue($this->_permissionService));
	}

	public function teardown()
	{
		parent::teardown();
	}

	public function testPageLoadSetsDefaultsForSelectedUserAndResourceAndDate()
	{
		$timezone = $this->_user->Timezone;

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

		$this->_permissionService->expects($this->once())
			->method('CanAccessResource')
			->with($this->anything())
			->will($this->returnValue(true));
			
		// DATA
		// users
		$schedUser = new UserDto($this->_userId, $firstName, $lastName);
		$otherUser = new UserDto(109, 'other', 'user');
		$userList = array($otherUser, $schedUser);

		$this->_userRepository->expects($this->once())
			->method('GetAll')
			->will($this->returnValue($userList));
			
		// resources
		$schedResource = new ScheduleResource($resourceId, 'resource 1');
		$otherResource = new ScheduleResource(2, 'resource 2');
		$resourceList = array($otherResource, $schedResource);
		$scheduleUser = $this->getMock('IScheduleUser');

		$this->_scheduleUserRepository->expects($this->once())
			->method('GetUser')
			->with($this->equalTo($this->_userId))
			->will($this->returnValue($scheduleUser));
			
		$scheduleUser->expects($this->once())
			->method('GetAllResources')
			->will($this->returnValue($resourceList));
			
		// periods
		$periods = array(new SchedulePeriod(new Time(1, 0, 0), new Time(2, 0, 0)));
		$layout = $this->getMock('IScheduleLayout');

		$this->_scheduleRepository->expects($this->once())
			->method('GetLayout')
			->with($this->equalTo($scheduleId), $this->equalTo($this->_user->Timezone))
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

		$presenter = new ReservationPresenter($page, $this->_scheduleUserRepository, $this->_scheduleRepository, $this->_userRepository, $this->_permissionServiceFactory);

		$presenter->PageLoad();
	}

	public function testRedirectsWithErrorMessageIfUserDoesNotHavePermission()
	{
		$resourceId = 123;
		$resource = new ReservationResource($resourceId);
				
		$lastPage = 'last/page.php?a=b&c=d';
		$errorMessage = ErrorMessages::INSUFFICIENT_PERMISSIONS;
		
		$page = $this->getMock('IReservationPage');

		$page->expects($this->once())
			->method('GetRequestedResourceId')
			->will($this->returnValue($resourceId));

		$this->_permissionService->expects($this->once())
			->method('CanAccessResource')
			->with($this->equalTo($resource))
			->will($this->returnValue(false));

		$page->expects($this->once())
			->method('GetLastPage')
			->will($this->returnValue($lastPage));
			
		$page->expects($this->once())
			->method('RedirectToError')
			->with($this->equalTo($errorMessage), $this->equalTo($lastPage));
			
		$presenter = new ReservationPresenter($page, $this->_scheduleUserRepository, $this->_scheduleRepository, $this->_userRepository, $this->_permissionServiceFactory);
		$presenter->PageLoad();
	}
}
?>
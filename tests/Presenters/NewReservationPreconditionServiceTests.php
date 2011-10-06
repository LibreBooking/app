<?php 
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'Pages/ReservationPage.php');

class NewReservationPreconditionServiceTests extends TestBase
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
	 * @var IPermissionServiceFactory|PHPUnit_Framework_MockObject_MockObject
	 */
	private $_permissionServiceFactory;
	
	public function setup()
	{
		parent::setup();

		$this->_user = $this->fakeServer->UserSession;
		$this->_userId = $this->_user->UserId;
		
		$this->_permissionServiceFactory = $this->getMock('IPermissionServiceFactory');
	}
	
	public function teardown()
	{
		parent::teardown();
	}
	
	public function testRedirectsWithErrorMessageIfUserDoesNotHavePermission()
	{
		$resourceId = 123;
		$resource = new ReservationResource($resourceId);

		$errorMessage = ErrorMessages::INSUFFICIENT_PERMISSIONS;
		
		$page = $this->getMock('INewReservationPage');

		$page->expects($this->once())
			->method('GetRequestedScheduleId')
			->will($this->returnValue(1));
			
		$page->expects($this->once())
			->method('GetRequestedResourceId')
			->will($this->returnValue($resourceId));

		$permissionService = $this->getMock('IPermissionService');
			
		$this->_permissionServiceFactory->expects($this->once())
			->method('GetPermissionService')
			->will($this->returnValue($permissionService));			
			
		$permissionService->expects($this->once())
			->method('CanAccessResource')
			->with($this->equalTo($resource), $this->equalTo($this->_user))
			->will($this->returnValue(false));
			
		$page->expects($this->once())
			->method('RedirectToError')
			->with($this->equalTo($errorMessage));
			
		$preconditionService = new NewReservationPreconditionService($this->_permissionServiceFactory);
		$preconditionService->CheckAll($page, $this->_user);
	}
	
	public function testBouncesWhenNoScheduleIdProvided()
	{
		$errorMessage = ErrorMessages::MISSING_SCHEDULE;
		
		$page = $this->getMock('INewReservationPage');

		$page->expects($this->once())
			->method('GetRequestedResourceId')
			->will($this->returnValue(1));
			
		$page->expects($this->once())
			->method('GetRequestedScheduleId')
			->will($this->returnValue(null));
			
		$page->expects($this->once())
			->method('RedirectToError')
			->with($this->equalTo($errorMessage));
		
		$preconditionService = new NewReservationPreconditionService($this->_permissionServiceFactory);
		$preconditionService->CheckAll($page, $this->_user);
	}
	
	public function testBouncesWhenNoResourceIdProvided()
	{
		$errorMessage = ErrorMessages::MISSING_RESOURCE;
		
		$page = $this->getMock('INewReservationPage');

		$page->expects($this->once())
			->method('GetRequestedScheduleId')
			->will($this->returnValue(1));
			
		$page->expects($this->once())
			->method('GetRequestedResourceId')
			->will($this->returnValue(null));
			
		$page->expects($this->once())
			->method('RedirectToError')
			->with($this->equalTo($errorMessage));
		
		$preconditionService = new NewReservationPreconditionService($this->_permissionServiceFactory);
		$preconditionService->CheckAll($page, $this->_user);
	}	
}
<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/
 
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
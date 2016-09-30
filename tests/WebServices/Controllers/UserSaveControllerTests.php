<?php
/**
Copyright 2013-2016 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'WebServices/Controllers/UserSaveController.php');

class UserSaveControllerTests extends TestBase
{
	/**
	 * @var UserSaveController
	 */
	private $controller;

	/**
	 * @var IManageUsersServiceFactory
	 */
	private $manageUserServiceFactory;

	/**
	 * @var IManageUsersService
	 */
	private $manageUsersService;

	/**
	 * @var IUserRequestValidator
	 */
	private $requestValidator;

	public function setup()
	{
		parent::setup();

		$this->manageUserServiceFactory = $this->getMock('IManageUsersServiceFactory');
		$this->manageUsersService = $this->getMock('IManageUsersService');
		$this->requestValidator = $this->getMock('IUserRequestValidator');

		$this->controller = new UserSaveController($this->manageUserServiceFactory, $this->requestValidator);
	}

	public function testCreatesNewUser()
	{
		$createdUserId = 123;
		$createdUser = new FakeUser($createdUserId);

		$request = CreateUserRequest::Example();
		$session = new FakeWebServiceUserSession(123);

		$this->requestValidator->expects($this->once())
				->method('ValidateCreateRequest')
				->with($this->equalTo($request))
				->will($this->returnValue(null));

		$this->manageUserServiceFactory->expects($this->once())
				->method('CreateAdmin')
				->will($this->returnValue($this->manageUsersService));

		$this->manageUsersService->expects($this->once())
				->method('AddUser')
				->with($this->equalTo($request->userName),
					   $this->equalTo($request->emailAddress),
					   $this->equalTo($request->firstName),
					   $this->equalTo($request->lastName),
					   $this->equalTo($request->password),
					   $this->equalTo($request->timezone),
					   $this->equalTo($request->language),
					   $this->equalTo(Pages::DEFAULT_HOMEPAGE_ID),
					   $this->equalTo(array(UserAttribute::Phone => $request->phone, UserAttribute::Organization => $request->organization, UserAttribute::Position => $request->position)),
					   $this->equalTo(array(new AttributeValue($request->customAttributes[0]->attributeId, $request->customAttributes[0]->attributeValue))))
				->will($this->returnValue($createdUser));

		$result = $this->controller->Create($request, $session);

		$expectedResult = new UserControllerResult($createdUserId);
		$this->assertEquals($expectedResult, $result);
		$this->assertTrue($result->WasSuccessful());
	}

	public function testValidatesCreateRequest()
	{
		$request = CreateUserRequest::Example();
		$session = new FakeWebServiceUserSession(123);

		$errors = array('error');

		$this->requestValidator->expects($this->once())
				->method('ValidateCreateRequest')
				->with($this->equalTo($request))
				->will($this->returnValue($errors));

		$result = $this->controller->Create($request, $session);

		$this->assertFalse($result->WasSuccessful());
		$this->assertEquals($errors, $result->Errors());
	}

	public function testUpdatesUser()
	{
		$userId = 123;
		$user = new FakeUser($userId);
		$request = UpdateUserRequest::Example();
		$session = new FakeWebServiceUserSession(123);

		$this->requestValidator->expects($this->once())
				->method('ValidateUpdateRequest')
				->with($this->equalTo($userId), $this->equalTo($request))
				->will($this->returnValue(null));

		$this->manageUserServiceFactory->expects($this->once())
				->method('CreateAdmin')
				->will($this->returnValue($this->manageUsersService));

		$this->manageUsersService->expects($this->once())
				->method('UpdateUser')
				->with($this->equalTo($userId),
					   $this->equalTo($request->userName),
					   $this->equalTo($request->emailAddress),
					   $this->equalTo($request->firstName),
					   $this->equalTo($request->lastName),
					   $this->equalTo($request->timezone),
					   $this->equalTo(array(UserAttribute::Phone => $request->phone, UserAttribute::Organization => $request->organization, UserAttribute::Position => $request->position)))
				->will($this->returnValue($user));

		$this->manageUsersService->expects($this->once())
				->method('ChangeAttributes')
				->with($this->equalTo($userId),
					   $this->equalTo(array(new AttributeValue($request->customAttributes[0]->attributeId, $request->customAttributes[0]->attributeValue))));

		$result = $this->controller->Update($userId, $request, $session);

		$expectedResult = new UserControllerResult($userId);
		$this->assertEquals($expectedResult, $result);
		$this->assertTrue($result->WasSuccessful());
	}

	public function testValidatesUpdateRequest()
	{
		$request = UpdateUserRequest::Example();
		$session = new FakeWebServiceUserSession(123);

		$errors = array('error');

		$this->requestValidator->expects($this->once())
				->method('ValidateUpdateRequest')
				->with($this->equalTo(1), $this->equalTo($request))
				->will($this->returnValue($errors));

		$result = $this->controller->Update(1, $request, $session);

		$this->assertFalse($result->WasSuccessful());
		$this->assertEquals($errors, $result->Errors());
	}

	public function testDeletesUser()
	{
		$userId = 99;
		$session = new FakeWebServiceUserSession(123);

		$this->manageUserServiceFactory->expects($this->once())
				->method('CreateAdmin')
				->will($this->returnValue($this->manageUsersService));

		$this->manageUsersService->expects($this->once())
				->method('DeleteUser')
				->with($this->equalTo($userId));

		$result = $this->controller->Delete($userId, $session);

		$this->assertTrue($result->WasSuccessful());
	}
}

?>
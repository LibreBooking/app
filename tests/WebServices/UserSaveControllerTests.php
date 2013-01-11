<?php
/**
Copyright 2013 Nick Korbel

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

	public function setup()
	{
		parent::setup();

		$this->manageUserServiceFactory = $this->getMock('IManageUsersServiceFactory');
		$this->controller = new UserSaveController($this->manageUserServiceFactory);
	}

	public function testCreatesNewUser()
	{
		/** @var $presenter IManageUsersService */
		$manageUsersService = $this->getMock('IManageUsersService');

		$request = $this->GetCreateUserRequest();
		$session = new FakeWebServiceUserSession(123);

		$this->manageUserServiceFactory->expects($this->once())
				->method('CreateAdmin')
				->will($this->returnValue($this->manageUsersService));

		$this->manageUsersService->expects($this->once())
						->method('AddUser')
						->with($this->equalTo($request->userName),
							   $this->equalTo($email),
							   $this->equalTo($fname),
							   $this->equalTo($lname),
							   $this->equalTo($password),
							   $this->equalTo($timezone),
							   $this->equalTo($lang),
							   $this->equalTo(Pages::DEFAULT_HOMEPAGE_ID),
							   $this->equalTo(array()),
							   $this->equalTo(array(new AttributeValue($attributeId, $attributeValue))));

		$result = $this->controller->Create($request, $session);

//		$expectedResult = new UserControllerResult($createdUserId)
//		$this->assertEquals($expectedResult, $result);
	}

	public function testValidatesRequest()
	{
		$this->markTestIncomplete('next');
	}

	/**
	 * @return CreateUserRequest
	 */
	private function GetCreateUserRequest()
	{
		$userRequest = new CreateUserRequest();
		$userRequest->firstName = 'first';
		$userRequest->lastName = 'last';
		$userRequest->emailAddress = 'email';
		$userRequest->userName = 'username';
		$userRequest->timezone = 'tz';
		$userRequest->language = 'lang';
		$userRequest->password = 'password';
		$userRequest->customAttributes = array(new AttributeValueRequest(99, 'attval'));

		return $userRequest;
	}
}

?>
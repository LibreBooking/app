<?php
/**
Copyright 2012 Nick Korbel

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

require_once(ROOT_DIR . 'WebServices/UsersWebService.php');

class UsersWebServiceTests extends TestBase
{
	/**
	 * @var FakeRestServer
	 */
	private $server;

	/**
	 * @var UsersWebService
	 */
	private $service;

	/**
	 * @var IUserRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $userRepository;

	/**
	 * @var IUserRepositoryFactory|PHPUnit_Framework_MockObject_MockObject
	 */
	private $userRepositoryFactory;

	/**
	 * @var IAttributeService|PHPUnit_Framework_MockObject_MockObject
	 */
	private $attributeService;

	public function setup()
	{
		parent::setup();

		$this->server = new FakeRestServer();
		$this->userRepository = $this->getMock('IUserRepository');
		$this->userRepositoryFactory = $this->getMock('IUserRepositoryFactory');
		$this->attributeService = $this->getMock('IAttributeService');

		$this->service = new UsersWebService($this->server, $this->userRepositoryFactory, $this->attributeService);
	}

	public function testGetsAllUsers()
	{
		$userId = 123232;
		$userItemView = new UserItemView();
		$userItemView->Id = $userId;
		$userItemView->DateCreated = Date::Now();
		$userItemView->LastLogin = Date::Now();

		$userList = array($userItemView);
		$users = new PageableData($userList);
		$attributes = $this->getMock('IEntityAttributeList');

		$this->userRepositoryFactory->expects($this->once())
				->method('Create')
				->with($this->equalTo($this->server->GetSession()))
				->will($this->returnValue($this->userRepository));

		$this->userRepository->expects($this->once())
				->method('GetList')
				->with($this->isNull(), $this->isNull())
				->will($this->returnValue($users));

		$this->attributeService->expects($this->once())
				->method('GetAttributes')
				->with($this->equalTo(CustomAttributeCategory::USER), $this->equalTo(array($userId)))
				->will($this->returnValue($attributes));

		$expectedResponse = new UsersResponse($this->server, $userList, $attributes);

		$this->service->GetUsers();

		$this->assertEquals($expectedResponse, $this->server->_LastResponse);
	}

	public function testGetsASingleUserIfAllowed()
	{
		$sessionUserId = $this->server->GetSession()->UserId;

		$userId = 999;
		$this->HideUsers(true);

		$user = new FakeUser($userId);
		$me = new FakeUser($sessionUserId);
		$me->_SetIsAdminForUser(true);

		$attributes = $this->getMock('IEntityAttributeList');

		$this->userRepositoryFactory->expects($this->once())
				->method('Create')
				->with($this->equalTo($this->server->GetSession()))
				->will($this->returnValue($this->userRepository));

		$this->userRepository->expects($this->at(0))
				->method('LoadById')
				->with($this->equalTo($userId))
				->will($this->returnValue($user));

		$this->userRepository->expects($this->at(1))
				->method('LoadById')
				->with($this->equalTo($sessionUserId))
				->will($this->returnValue($me));

		$this->attributeService->expects($this->once())
				->method('GetAttributes')
				->with($this->equalTo(CustomAttributeCategory::USER), $this->equalTo(array($userId)))
				->will($this->returnValue($attributes));

		$expectedResponse = new UserResponse($this->server, $user, $attributes);

		$this->service->GetUser($userId);

		$this->assertEquals($expectedResponse, $this->server->_LastResponse);
	}

	public function testGetsASingleUserIfCurrentUserIdMatches()
	{
		$userId = $this->server->GetSession()->UserId;
		$user = new FakeUser($userId);

		$this->HideUsers(true);

		$attributes = $this->getMock('IEntityAttributeList');

		$this->userRepositoryFactory->expects($this->once())
				->method('Create')
				->with($this->equalTo($this->server->GetSession()))
				->will($this->returnValue($this->userRepository));

		$this->userRepository->expects($this->at(0))
				->method('LoadById')
				->with($this->equalTo($userId))
				->will($this->returnValue($user));

		$this->attributeService->expects($this->once())
				->method('GetAttributes')
				->with($this->equalTo(CustomAttributeCategory::USER), $this->equalTo(array($userId)))
				->will($this->returnValue($attributes));

		$expectedResponse = new UserResponse($this->server, $user, $attributes);

		$this->service->GetUser($userId);

		$this->assertEquals($expectedResponse, $this->server->_LastResponse);
	}

	public function testWhenUserIsNotFound()
	{
		$userId = 999;
		$this->HideUsers(false);

		$this->userRepositoryFactory->expects($this->once())
				->method('Create')
				->with($this->equalTo($this->server->GetSession()))
				->will($this->returnValue($this->userRepository));

		$this->userRepository->expects($this->at(0))
				->method('LoadById')
				->with($this->equalTo($userId))
				->will($this->returnValue(User::Null()));

		$expectedResponse = RestResponse::NotFound();

		$this->service->GetUser($userId);

		$this->assertEquals($expectedResponse, $this->server->_LastResponse);
		$this->assertEquals(RestResponse::NOT_FOUND_CODE, $this->server->_LastResponseCode);
	}

	public function testWhenNotAllowedToGetUser()
	{
		$sessionUserId = $this->server->GetSession()->UserId;

		$userId = 999;
		$this->HideUsers(true);

		$user = new FakeUser($userId);
		$me = new FakeUser($sessionUserId);
		$me->_SetIsAdminForUser(false);
		$attributes = $this->getMock('IEntityAttributeList');

		$this->userRepositoryFactory->expects($this->once())
				->method('Create')
				->with($this->equalTo($this->server->GetSession()))
				->will($this->returnValue($this->userRepository));

		$this->userRepository->expects($this->at(0))
				->method('LoadById')
				->with($this->equalTo($userId))
				->will($this->returnValue($user));

		$this->userRepository->expects($this->at(1))
				->method('LoadById')
				->with($this->equalTo($sessionUserId))
				->will($this->returnValue($me));

		$this->attributeService->expects($this->once())
				->method('GetAttributes')
				->with($this->equalTo(CustomAttributeCategory::USER), $this->equalTo(array($userId)))
				->will($this->returnValue($attributes));

		$this->service->GetUser($userId);

		$this->assertEquals(RestResponse::Unauthorized(), $this->server->_LastResponse);
		$this->assertEquals(RestResponse::UNAUTHORIZED_CODE, $this->server->_LastResponseCode);
	}

	public function testWhenNotHidingUserDetails()
	{
		$this->HideUsers(false);

		$userId = 999;
		$user = new FakeUser($userId);

		$attributes = $this->getMock('IEntityAttributeList');

		$this->userRepositoryFactory->expects($this->once())
				->method('Create')
				->with($this->equalTo($this->server->GetSession()))
				->will($this->returnValue($this->userRepository));

		$this->userRepository->expects($this->at(0))
				->method('LoadById')
				->with($this->equalTo($userId))
				->will($this->returnValue($user));

		$this->attributeService->expects($this->once())
				->method('GetAttributes')
				->with($this->equalTo(CustomAttributeCategory::USER), $this->equalTo(array($userId)))
				->will($this->returnValue($attributes));

		$expectedResponse = new UserResponse($this->server, $user, $attributes);

		$this->service->GetUser($userId);

		$this->assertEquals($expectedResponse, $this->server->_LastResponse);
	}

	private function HideUsers($hide)
	{
		$this->fakeConfig->SetSectionKey(ConfigSection::PRIVACY, ConfigKeys::PRIVACY_HIDE_USER_DETAILS, $hide);
	}
}

?>
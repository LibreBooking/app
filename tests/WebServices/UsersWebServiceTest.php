<?php

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

	public function setUp(): void
	{
		parent::setup();

		$this->server = new FakeRestServer();
		$this->userRepository = $this->createMock('IUserRepository');
		$this->userRepositoryFactory = $this->createMock('IUserRepositoryFactory');
		$this->attributeService = $this->createMock('IAttributeService');

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
		$attributes = array(new FakeCustomAttribute(1), new FakeCustomAttribute(2));

		$username = 'username';
		$position = 'position';
		$att1 = 'att1';

		$this->server->SetQueryString(WebServiceQueryStringKeys::USERNAME, $username);
		$this->server->SetQueryString(WebServiceQueryStringKeys::POSITION, $position);
		$this->server->SetQueryString('att1', $att1);

		$expectedFilter = new UserFilter($username, null, null, null, null, null, $position, array(new Attribute($attributes[0], $att1)));

		$this->userRepositoryFactory->expects($this->once())
				->method('Create')
				->with($this->equalTo($this->server->GetSession()))
				->will($this->returnValue($this->userRepository));

		$this->userRepository->expects($this->once())
				->method('GetList')
				->with($this->isNull(), $this->isNull(), $this->isNull(), $this->isNull(), $expectedFilter->GetFilter(), AccountStatus::ACTIVE)
				->will($this->returnValue($users));

		$this->attributeService->expects($this->once())
				->method('GetByCategory')
				->with($this->equalTo(CustomAttributeCategory::USER))
				->will($this->returnValue($attributes));

		$expectedResponse = new UsersResponse($this->server, $userList, array(1=>'fakeCustomAttribute1', 2=>'fakeCustomAttribute2'));

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

		$attributes = $this->createMock('IEntityAttributeList');

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

		$attributes = $this->createMock('IEntityAttributeList');

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
		$attributes = $this->createMock('IEntityAttributeList');

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

		$attributes = $this->createMock('IEntityAttributeList');

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

<?php

require_once(ROOT_DIR . 'lib/Application/Authorization/namespace.php');

class AuthorizationServiceTests extends TestBase
{
	/**
	 * @var AuthorizationService
	 */
	private $authorizationService;

	/**
	 * @var IUserRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $userRepository;

	public function setup()
	{
		parent::setup();

		$this->userRepository = $this->getMock('IUserRepository');
		$this->authorizationService = new AuthorizationService($this->userRepository);
	}

	public function testCanReserveForOthersIfUserIsAdminOrGroupAdmin()
	{
		$userId = 123;

		$adminUser = new FakeUserSession(true);
		$user = new FakeUserSession(false, null, $userId);

		$groupAdmin = $this->getMock('User');
		$normalDude = $this->getMock('User');

		$groupAdmin->expects($this->once())
				->method('IsGroupAdmin')
				->will($this->returnValue(true));

		$normalDude->expects($this->once())
				->method('IsGroupAdmin')
				->will($this->returnValue(false));

		$this->userRepository->expects($this->at(0))
				->method('LoadById')
				->with($this->equalTo($userId))
				->will($this->returnValue($groupAdmin));

		$this->userRepository->expects($this->at(1))
				->method('LoadById')
				->with($this->equalTo($userId))
				->will($this->returnValue($normalDude));

		$asAdmin = $this->authorizationService->CanReserveForOthers($adminUser);
		$asGroupAdmin = $this->authorizationService->CanReserveForOthers($user);
		$asNormalDude = $this->authorizationService->CanReserveForOthers($user);

		$this->assertTrue($asAdmin);
		$this->assertTrue($asGroupAdmin);
		$this->assertFalse($asNormalDude);
	}

	public function testCanReserveForAnotherUserIfAdminOrGroupAdmin()
	{
		$userId = 123;
		$reserveForId = 222;

		$adminUser = new FakeUserSession(true);
		$user = new FakeUserSession(false, null, $userId);

		$groupAdmin = $this->getMock('User');
		$normalDude = $this->getMock('User');

		$reserveForUser = $this->getMock('User');

		// group admin
		$this->userRepository->expects($this->at(0))
				->method('LoadById')
				->with($this->equalTo($userId))
				->will($this->returnValue($groupAdmin));

		$this->userRepository->expects($this->at(1))
				->method('LoadById')
				->with($this->equalTo($reserveForId))
				->will($this->returnValue($reserveForUser));

		$groupAdmin->expects($this->once())
				->method('IsAdminFor')
				->with($this->equalTo($reserveForUser))
				->will($this->returnValue(true));

		// normal dude
		$this->userRepository->expects($this->at(2))
				->method('LoadById')
				->with($this->equalTo($userId))
				->will($this->returnValue($normalDude));

		$this->userRepository->expects($this->at(3))
				->method('LoadById')
				->with($this->equalTo($reserveForId))
				->will($this->returnValue($reserveForUser));

		$normalDude->expects($this->once())
				->method('IsAdminFor')
				->with($this->equalTo($reserveForUser))
				->will($this->returnValue(false));

		$asAdmin = $this->authorizationService->CanReserveFor($adminUser, $reserveForId);
		$asGroupAdmin = $this->authorizationService->CanReserveFor($user, $reserveForId);
		$asNormalDude = $this->authorizationService->CanReserveFor($user, $reserveForId);

		$this->assertTrue($asAdmin);
		$this->assertTrue($asGroupAdmin);
		$this->assertFalse($asNormalDude);
	}

	public function testCanApproveForAnotherUserIfAdminOrGroupAdmin()
	{
		$userId = 123;
		$reserveForId = 222;

		$adminUser = new FakeUserSession(true);
		$user = new FakeUserSession(false, null, $userId);

		$groupAdmin = $this->getMock('User');
		$normalDude = $this->getMock('User');

		$reserveForUser = $this->getMock('User');

		// group admin
		$this->userRepository->expects($this->at(0))
				->method('LoadById')
				->with($this->equalTo($userId))
				->will($this->returnValue($groupAdmin));

		$this->userRepository->expects($this->at(1))
				->method('LoadById')
				->with($this->equalTo($reserveForId))
				->will($this->returnValue($reserveForUser));

		$groupAdmin->expects($this->once())
				->method('IsAdminFor')
				->with($this->equalTo($reserveForUser))
				->will($this->returnValue(true));

		// normal dude
		$this->userRepository->expects($this->at(2))
				->method('LoadById')
				->with($this->equalTo($userId))
				->will($this->returnValue($normalDude));

		$this->userRepository->expects($this->at(3))
				->method('LoadById')
				->with($this->equalTo($reserveForId))
				->will($this->returnValue($reserveForUser));

		$normalDude->expects($this->once())
				->method('IsAdminFor')
				->with($this->equalTo($reserveForUser))
				->will($this->returnValue(false));

		$asAdmin = $this->authorizationService->CanApproveFor($adminUser, $reserveForId);
		$asGroupAdmin = $this->authorizationService->CanApproveFor($user, $reserveForId);
		$asNormalDude = $this->authorizationService->CanApproveFor($user, $reserveForId);

		$this->assertTrue($asAdmin);
		$this->assertTrue($asGroupAdmin);
		$this->assertFalse($asNormalDude);
	}
	
	public function testIsApplicationAdministratorIfAtLeastOneGroupCanAdministerApplication()
	{
		$userId = 123;
		$expectedIsAdmin = true;

		$groups = array(
			new UserGroup(1, null, null, RoleLevel::APPLICATION_ADMIN),
			new UserGroup(3, null, null, RoleLevel::APPLICATION_ADMIN),
		);

		$this->userRepository->expects($this->once())
						->method('LoadGroups')
						->with($this->equalTo($userId), $this->equalTo(RoleLevel::APPLICATION_ADMIN))
						->will($this->returnValue($groups));

		$actualIsAdmin = $this->authorizationService->IsApplicationAdministrator(new AuthorizationUser($userId, 'email'));

		$this->assertEquals($expectedIsAdmin, $actualIsAdmin);
	}

	public function testIsApplicationAdminIfConfigured()
	{
		$email = 'abc123@email.com';
		
		$this->fakeConfig->SetKey(ConfigKeys::ADMIN_EMAIL, $email);
		$actualIsAdmin = $this->authorizationService->IsApplicationAdministrator(new AuthorizationUser(1, $email));

		$this->assertTrue($actualIsAdmin);
	}
}

?>
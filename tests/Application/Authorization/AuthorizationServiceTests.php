<?php

require_once(ROOT_DIR . 'lib/Application/Authorization/namespace.php');

class AuthorizationServiceTests extends TestBase
{
	/**
	 * @var AuthorizationService
	 */
	private $authorizationService;

	/**
	 * @var IScheduleUserRepository
	 */
	private $scheduleUserRepository;

	public function setup()
	{
		parent::setup();

		$this->scheduleUserRepository = $this->getMock('IScheduleUserRepository');
		$this->authorizationService = new AuthorizationService($this->scheduleUserRepository);
	}

	public function testCanReserveForOthersIfUserIsAdminOrGroupAdmin()
	{
		$userId = 123;

		$adminUser = new FakeUserSession(true);
		$user = new FakeUserSession(false, null, $userId);

		$groupAdmin = $this->getMock('IScheduleUser');
		$normalDude = $this->getMock('IScheduleUser');

		$groupAdmin->expects($this->once())
				->method('IsGroupAdmin')
				->will($this->returnValue(true));

		$normalDude->expects($this->once())
				->method('IsGroupAdmin')
				->will($this->returnValue(false));

		$this->scheduleUserRepository->expects($this->at(0))
				->method('GetUser')
				->with($this->equalTo($userId))
				->will($this->returnValue($groupAdmin));

		$this->scheduleUserRepository->expects($this->at(1))
				->method('GetUser')
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
		$reserveFor = 222;

		$adminUser = new FakeUserSession(true);
		$user = new FakeUserSession(false, null, $userId);

		$groupAdmin = $this->getMock('IScheduleUser');
		$normalDude = $this->getMock('IScheduleUser');

		$groupAdmin->expects($this->once())
				->method('IsGroupAdmin')
				->will($this->returnValue(true));

		$normalDude->expects($this->once())
				->method('IsGroupAdmin')
				->will($this->returnValue(false));

		$this->scheduleUserRepository->expects($this->at(0))
				->method('GetUser')
				->with($this->equalTo($userId))
				->will($this->returnValue($groupAdmin));

		$this->scheduleUserRepository->expects($this->at(1))
				->method('GetUser')
				->with($this->equalTo($userId))
				->will($this->returnValue($normalDude));

		$asAdmin = $this->authorizationService->CanReserveFor($adminUser, $reserveFor);
		$asGroupAdmin = $this->authorizationService->CanReserveFor($user, $reserveFor);
		$asNormalDude = $this->authorizationService->CanReserveFor($user, $reserveFor);

		$this->assertTrue($asAdmin);
		$this->assertTrue($asGroupAdmin);
		$this->assertFalse($asNormalDude);
	}

	public function testCanApproveForAnotherUserIfAdminOrGroupAdmin()
	{
		$userId = 123;
		$reserveFor = 222;

		$adminUser = new FakeUserSession(true);
		$user = new FakeUserSession(false, null, $userId);

		$groupAdmin = $this->getMock('IScheduleUser');
		$normalDude = $this->getMock('IScheduleUser');

		$groupAdmin->expects($this->once())
				->method('IsGroupAdmin')
				->will($this->returnValue(true));

		$normalDude->expects($this->once())
				->method('IsGroupAdmin')
				->will($this->returnValue(false));

		$this->scheduleUserRepository->expects($this->at(0))
				->method('GetUser')
				->with($this->equalTo($userId))
				->will($this->returnValue($groupAdmin));

		$this->scheduleUserRepository->expects($this->at(1))
				->method('GetUser')
				->with($this->equalTo($userId))
				->will($this->returnValue($normalDude));

		$asAdmin = $this->authorizationService->CanApproveFor($adminUser, $reserveFor);
		$asGroupAdmin = $this->authorizationService->CanApproveFor($user, $reserveFor);
		$asNormalDude = $this->authorizationService->CanApproveFor($user, $reserveFor);

		$this->assertTrue($asAdmin);
		$this->assertTrue($asGroupAdmin);
		$this->assertFalse($asNormalDude);
	}
}

?>
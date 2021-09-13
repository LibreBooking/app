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

    public function setUp(): void
    {
        parent::setup();

        $this->userRepository = $this->createMock('IUserRepository');
        $this->authorizationService = new AuthorizationService($this->userRepository);
    }

    public function testCanReserveForOthersIfUserIsAdminOrGroupAdmin()
    {
        $userId = 123;

        $adminUser = new FakeUserSession(true);
        $user = new FakeUserSession(false, null, $userId);

        $groupAdmin = $this->createMock('User');
        $normalDude = $this->createMock('User');

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
        $user->IsGroupAdmin = true;

        $groupAdmin = $this->createMock('User');
        $normalDude = $this->createMock('User');
        $reserveForUser = $this->createMock('User');

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
        $user->IsGroupAdmin = true;

        $groupAdmin = $this->createMock('User');
        $normalDude = $this->createMock('User');

        $reserveForUser = $this->createMock('User');

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

        $groups = [
            new UserGroup(1, null, null, RoleLevel::APPLICATION_ADMIN),
            new UserGroup(3, null, null, RoleLevel::APPLICATION_ADMIN),
        ];

        $user = new User();
        $user->WithGroups($groups);


        $actualIsAdmin = $this->authorizationService->IsApplicationAdministrator($user);

        $this->assertEquals($expectedIsAdmin, $actualIsAdmin);
    }

    public function testIsApplicationAdminIfConfigured()
    {
        $email = 'abc123@email.com';
        $user = new User();
        $user->ChangeEmailAddress($email);

        $this->fakeConfig->SetKey(ConfigKeys::ADMIN_EMAIL, $email);
        $actualIsAdmin = $this->authorizationService->IsApplicationAdministrator($user);

        $this->assertTrue($actualIsAdmin);
    }

    public function testIsResourceAdminIfAtLeastOneGroupHasResourceAdminRole()
    {
        $userId = 123;
        $expectedIsAdmin = true;

        $groups = [
            new UserGroup(1, null, null, RoleLevel::APPLICATION_ADMIN),
            new UserGroup(3, null, null, RoleLevel::RESOURCE_ADMIN),
        ];

        $user = new User();
        $user->WithGroups($groups);

        $actualIsAdmin = $this->authorizationService->IsResourceAdministrator($user);

        $this->assertEquals($expectedIsAdmin, $actualIsAdmin);
    }

    public function testIsGroupAdminIfAtLeastOneGroupHasResourceAdminRole()
    {
        $userId = 123;
        $expectedIsAdmin = true;

        $groups = [
            new UserGroup(1, null, null, RoleLevel::APPLICATION_ADMIN),
            new UserGroup(3, null, null, RoleLevel::GROUP_ADMIN),
        ];

        $user = new User();
        $user->WithGroups($groups);

        $actualIsAdmin = $this->authorizationService->IsGroupAdministrator($user);

        $this->assertEquals($expectedIsAdmin, $actualIsAdmin);
    }

    public function testCanEditReservationOnResourceIfUserIsAdminOfThatResource()
    {
        $userId = 1234;
        $userSession = new UserSession($userId);
        $userSession->IsResourceAdmin = true;

        $groupAdmin = $this->createMock('User');
        $resource = $this->createMock('IResource');

        $this->userRepository->expects($this->at(0))
                ->method('LoadById')
                ->with($this->equalTo($userId))
                ->will($this->returnValue($groupAdmin));

        $groupAdmin->expects($this->once())
                ->method('IsResourceAdminFor')
                ->with($this->equalTo($resource))
                ->will($this->returnValue(true));

        $canEdit = $this->authorizationService->CanEditForResource($userSession, $resource);

        $this->assertTrue($canEdit, "should be able to edit because user is in admin group");
    }

    public function testCanApproveReservationOnResourceIfUserIsAdminOfThatResource()
    {
        $userId = 1234;
        $userSession = new UserSession($userId);
        $userSession->IsResourceAdmin = true;

        $groupAdmin = $this->createMock('User');
        $resource = $this->createMock('IResource');

        $this->userRepository->expects($this->at(0))
                ->method('LoadById')
                ->with($this->equalTo($userId))
                ->will($this->returnValue($groupAdmin));

        $groupAdmin->expects($this->once())
                ->method('IsResourceAdminFor')
                ->with($this->equalTo($resource))
                ->will($this->returnValue(true));

        $canApprove = $this->authorizationService->CanApproveForResource($userSession, $resource);

        $this->assertTrue($canApprove, "should be able to approve because user is in admin group");
    }
}

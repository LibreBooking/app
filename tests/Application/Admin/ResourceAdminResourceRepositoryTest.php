<?php

require_once(ROOT_DIR . 'lib/Application/Admin/namespace.php');

class ResourceAdminResourceRepositoryTests extends TestBase
{
    /**
     * @var IUserRepository|PHPUnit_Framework_MockObject_MockObject
     */
    private $userRepository;

    public function setUp(): void
    {
        $this->userRepository = $this->createMock('IUserRepository');

        parent::setup();
    }
    public function testOnlyGetsResourcesWhereUserIsAdmin()
    {
        $user = $this->createMock('User');
        $this->userRepository->expects($this->once())
                        ->method('LoadById')
                        ->with($this->equalTo($this->fakeUser->UserId))
                        ->will($this->returnValue($user));

        $ra = new FakeResourceAccess();
        $this->db->SetRows($ra->GetRows());

        $user->expects($this->at(0))
                    ->method('IsResourceAdminFor')
                    ->with($this->equalTo($ra->_Resources[0]))
                    ->will($this->returnValue(false));

        $user->expects($this->at(1))
                    ->method('IsResourceAdminFor')
                    ->with($this->equalTo($ra->_Resources[1]))
                    ->will($this->returnValue(true));

        $repo = new ResourceAdminResourceRepository($this->userRepository, $this->fakeUser);
        $resources = $repo->GetResourceList();

        $this->assertTrue($this->db->ContainsCommand(new GetAllResourcesCommand()));
        $this->assertEquals(1, count($resources));
        $this->assertEquals(2, $resources[0]->GetId());
    }

    public function testOnlyGetsPageableResourcesWhereUserIsAdmin()
    {
        $pageNum = 10;
        $pageSize = 100;
        $existingFilter = new SqlFilterEquals('a', 'b');

        $groups = [new UserGroup(1, 'g1', null, RoleLevel::SCHEDULE_ADMIN), new UserGroup(2, 'g2', null, RoleLevel::RESOURCE_ADMIN)];

        $scheduleAdminGroupIds = [1];
        $resourceAdminGroupIds = [2];

        $this->userRepository->expects($this->once())
                    ->method('LoadGroups')
                    ->with($this->equalTo($this->fakeUser->UserId), $this->equalTo([RoleLevel::SCHEDULE_ADMIN, RoleLevel::RESOURCE_ADMIN]))
                    ->will($this->returnValue($groups));

        $repo = new ResourceAdminResourceRepository($this->userRepository, $this->fakeUser);
        $repo->GetList($pageNum, $pageSize, null, null, $existingFilter);

        $additionalFilter = new SqlFilterIn(new SqlFilterColumn(TableNames::SCHEDULES_ALIAS, ColumnNames::SCHEDULE_ADMIN_GROUP_ID), $scheduleAdminGroupIds);
        $expectedFilter = $existingFilter->_And($additionalFilter->_Or(new SqlFilterIn(ColumnNames::RESOURCE_ADMIN_GROUP_ID, $resourceAdminGroupIds)));

        $expectedCommand = new FilterCommand(new GetAllResourcesCommand(), $expectedFilter);
        $lastCommand = $this->db->_LastCommand;

        $this->assertEquals($expectedCommand->GetQuery(), $lastCommand->GetQuery());
    }

    public function testDoesNotUpdateResourceIfUserDoesNotHaveAccess()
    {
        $user = $this->createMock('User');
        $this->userRepository->expects($this->once())
                        ->method('LoadById')
                        ->with($this->equalTo($this->fakeUser->UserId))
                        ->will($this->returnValue($user));

        $repo = new ResourceAdminResourceRepository($this->userRepository, $this->fakeUser);
        $resource = new FakeBookableResource(1);
        $resource->SetAdminGroupId(2);

        $user->expects($this->at(0))
                            ->method('IsResourceAdminFor')
                            ->with($this->equalTo($resource))
                            ->will($this->returnValue(false));

        $actualEx = null;
        try {
            $repo->Update($resource);
        } catch (Exception $ex) {
            $actualEx = $ex;
        }
        $this->assertNotEmpty($actualEx, "should have thrown an exception");
    }

    public function testGetsScheduleResourcesUserHasAdminRightsTo()
    {
        $scheduleId = 100;
        $user = $this->createMock('User');
        $this->userRepository->expects($this->once())
                        ->method('LoadById')
                        ->with($this->equalTo($this->fakeUser->UserId))
                        ->will($this->returnValue($user));

        $ra = new FakeResourceAccess();
        $this->db->SetRows($ra->GetRows());

        $user->expects($this->at(0))
                    ->method('IsResourceAdminFor')
                    ->with($this->equalTo($ra->_Resources[0]))
                    ->will($this->returnValue(false));

        $user->expects($this->at(1))
                    ->method('IsResourceAdminFor')
                    ->with($this->equalTo($ra->_Resources[1]))
                    ->will($this->returnValue(true));

        $repo = new ResourceAdminResourceRepository($this->userRepository, $this->fakeUser);
        $resources = $repo->GetScheduleResources($scheduleId);

        $this->assertEquals(1, count($resources));
        $this->assertEquals(2, $resources[0]->GetId());
    }
}

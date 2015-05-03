<?php
/**
Copyright 2012-2015 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Application/Admin/namespace.php');

class ResourceAdminResourceRepositoryTests extends TestBase
{
	/**
	 * @var IUserRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $userRepository;

	public function setup()
	{
		$this->userRepository = $this->getMock('IUserRepository');

		parent::setup();
	}
	public function testOnlyGetsResourcesWhereUserIsAdmin()
	{
		$user = $this->getMock('User');
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

		$groups = array(new UserGroup(1, 'g1', null, RoleLevel::SCHEDULE_ADMIN), new UserGroup(2,'g2', null, RoleLevel::RESOURCE_ADMIN));

		$scheduleAdminGroupIds = array(1);
		$resourceAdminGroupIds = array(2);

		$this->userRepository->expects($this->once())
					->method('LoadGroups')
					->with($this->equalTo($this->fakeUser->UserId), $this->equalTo(array(RoleLevel::SCHEDULE_ADMIN, RoleLevel::RESOURCE_ADMIN)))
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
		$user = $this->getMock('User');
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
        try
        {
            $repo->Update($resource);
        }
        catch(Exception $ex)
        {
            $actualEx = $ex;

        }
        $this->assertNotEmpty($actualEx, "should have thrown an exception");
    }

	public function testGetsScheduleResourcesUserHasAdminRightsTo()
	{
		$scheduleId = 100;
		$user = $this->getMock('User');
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

		$this->assertTrue($this->db->ContainsCommand(new GetScheduleResourcesCommand($scheduleId)));
		$this->assertEquals(1, count($resources));
		$this->assertEquals(2, $resources[0]->GetId());
	}
}
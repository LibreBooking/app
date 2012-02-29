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
		$groups = array(
			new UserGroup(1, '1'),
			new UserGroup(5, '5'),
			new UserGroup(9, '9'),
			new UserGroup(22, '22'),
		);

		$this->userRepository->expects($this->once())
				->method('LoadGroups')
				->with($this->equalTo($this->fakeUser->UserId), $this->equalTo(RoleLevel::RESOURCE_ADMIN))
				->will($this->returnValue($groups));

		$ra = new FakeResourceAccess();
		$this->db->SetRows($ra->GetRows());

		$repo = new ResourceAdminResourceRepository($this->userRepository, $this->fakeUser);
		$resources = $repo->GetResourceList();

		$this->assertTrue($this->db->ContainsCommand(new GetAllResourcesCommand()));
		$this->assertEquals(1, count($resources));
		$this->assertEquals(2, $resources[0]->GetId());
	}

    public function testDoesNotUpdateResourceIfUserDoesNotHaveAccess()
    {
        $this->fakeUser->IsResourceAdmin = false;

        $repo = new ResourceAdminResourceRepository($this->userRepository, $this->fakeUser);
        $resource = new FakeBookableResource(1);
        $resource->SetAdminGroupId(2);

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
}

?>
<?php
/**
Copyright 2011-2013 Nick Korbel

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

require_once(ROOT_DIR . 'Domain/namespace.php');

class ResourcePermissionStoreTests extends TestBase
{
	public function testRepositoryIsAccessedForUserPermissionInformation()
	{
		$userId = 99;

		$rid1 = 1;
		$rid2 = 2;
		$r1 = new ScheduleResource($rid1, 'resource 1');
		$r2 = new ScheduleResource($rid2, 'resource 2');
		$resources = array($r1, $r2);

		$rid3 = 3;
		$rid4 = 4;
		$r3 = new ScheduleResource($rid3, 'resource 3');
		$r4 = new ScheduleResource($rid4, 'resource 4');

		$g1 = new ScheduleGroup(100, array($r1, $r3));
		$g2 = new ScheduleGroup(200, array($r1, $r4, $r3));
		$groups = array($g1, $g2);

		$user = $this->getMock('IScheduleUser');

		$user->expects($this->once())
			->method('GetAllResources')
			->will($this->returnValue(array($r1, $r2, $r3, $r4)));

		$userRepository = $this->getMock('IScheduleUserRepository');

		$userRepository->expects($this->once())
			->method('GetUser')
			->with($this->equalTo($userId))
			->will($this->returnValue($user));

		$rps = new ResourcePermissionStore($userRepository);

		$permittedResources = $rps->GetPermittedResources($userId);

		$this->assertEquals(4, count($permittedResources));
		$this->assertContains($rid1, $permittedResources);
		$this->assertContains($rid2, $permittedResources);
		$this->assertContains($rid3, $permittedResources);
		$this->assertContains($rid4, $permittedResources);
	}
}
?>
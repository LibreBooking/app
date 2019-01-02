<?php
/**
Copyright 2011-2019 Nick Korbel

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

class PermissionServiceTests extends TestBase
{
	public function testAsksStoreForAllowedResourcesAndReturnsTrueIfItExists()
	{
		$userId = 99;
		$user = new FakeUserSession();
		$user->UserId = $userId;

		$resource = new FakeBookableResource(1, 'whatever');
		$resourceIdList = array(3, 1, 4);

		$store = $this->getMock('IResourcePermissionStore');
		$ps = new PermissionService($store);

		$store->expects($this->once())
			->method('GetAllResources')
			->with($this->equalTo($userId))
			->will($this->returnValue($resourceIdList));

		$canAccess = $ps->CanAccessResource($resource, $user);

		$this->assertTrue($canAccess);
	}

	public function testCachesPermissionsPerUserForThisInstance()
	{
		$userId = 99;
		$user = new FakeUserSession();
		$user->UserId = $userId;

		$resource = new FakeBookableResource(1, 'whatever');
		$resourceIdList = array(3, 1, 4);

		$store = $this->getMock('IResourcePermissionStore');
		$ps = new PermissionService($store);

		$store->expects($this->once())
			->method('GetAllResources')
			->with($this->equalTo($userId))
			->will($this->returnValue($resourceIdList));

		$canAccess1 = $ps->CanAccessResource($resource, $user);
		$canAccess2 = $ps->CanAccessResource($resource, $user);

		$this->assertTrue($canAccess1);
		$this->assertTrue($canAccess2);
	}
}
?>
<?php
/**
 * Copyright 2011-2013 Nick Korbel
 *
 * This file is part of phpScheduleIt.
 *
 * phpScheduleIt is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * phpScheduleIt is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/Application/Schedule/ResourceService.php');

class ResourceServiceTests extends TestBase
{
	/**
	 * @var IPermissionService|PHPUnit_Framework_MockObject_MockObject
	 */
	private $permissionService;

	/**
	 * @var IResourceRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $resourceRepository;

	/**
	 * @var IAttributeService|PHPUnit_Framework_MockObject_MockObject
	 */
	private $attributeService;

	/**
	 * @var IUserRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $userRepository;

	/**
	 * @var ResourceService
	 */
	private $resourceService;

	public function setup()
	{
		$this->permissionService = $this->getMock('IPermissionService');
		$this->resourceRepository = $this->getMock('IResourceRepository');
		$this->attributeService = $this->getMock('IAttributeService');
		$this->userRepository = $this->getMock('IUserRepository');

		$this->resourceService = new ResourceService($this->resourceRepository, $this->permissionService, $this->attributeService, $this->userRepository);

		parent::setup();
	}

	public function testResourceServiceChecksPermissionForEachResource()
	{
		$scheduleId = 100;
		$user = $this->fakeUser;

		$resource1 = new FakeBookableResource(1, 'resource1');
		$resource2 = new FakeBookableResource(2, 'resource2');
		$resource3 = new FakeBookableResource(3, 'resource3');
		$resource4 = new FakeBookableResource(4, 'resource4');
		$resources = array($resource1, $resource2, $resource3, $resource4);

		$this->resourceRepository
				->expects($this->once())
				->method('GetScheduleResources')
				->with($this->equalTo($scheduleId))
				->will($this->returnValue($resources));

		$this->permissionService
				->expects($this->at(0))
				->method('CanAccessResource')
				->with($this->equalTo($resource1),
					   $this->equalTo($user))
				->will($this->returnValue(true));

		$this->permissionService
				->expects($this->at(1))
				->method('CanAccessResource')
				->with($this->equalTo($resource2),
					   $this->equalTo($user))
				->will($this->returnValue(true));

		$this->permissionService
				->expects($this->at(2))
				->method('CanAccessResource')
				->with($this->equalTo($resource3),
					   $this->equalTo($user))
				->will($this->returnValue(true));

		$this->permissionService
				->expects($this->at(3))
				->method('CanAccessResource')
				->with($this->equalTo($resource4),
					   $this->equalTo($user))
				->will($this->returnValue(false));

		$resourceDto1 = new ResourceDto(1, 'resource1', true, $resource1->GetScheduleId(), $resource1->GetMinLength());
		$resourceDto2 = new ResourceDto(2, 'resource2', true, $resource2->GetScheduleId(), $resource2->GetMinLength());
		$resourceDto3 = new ResourceDto(3, 'resource3', true, $resource3->GetScheduleId(), $resource3->GetMinLength());
		$resourceDto4 = new ResourceDto(4, 'resource4', false, $resource4->GetScheduleId(), $resource4->GetMinLength());

		$expected = array($resourceDto1, $resourceDto2, $resourceDto3, $resourceDto4);

		$actual = $this->resourceService->GetScheduleResources($scheduleId, true, $user);

		$this->assertEquals($expected, $actual);
	}

	public function testGetAllChecksPermissionForEachResource()
	{
		$session = $this->fakeUser;

		$resource1 = new FakeBookableResource(1, 'resource1');
		$resource2 = new FakeBookableResource(2, 'resource2');
		$resources = array($resource1, $resource2);

		$user = new FakeUser();
		$user->_IsResourceAdmin = true;

		$this->resourceRepository
				->expects($this->once())
				->method('GetResourceList')
				->will($this->returnValue($resources));

		$this->permissionService
				->expects($this->at(0))
				->method('CanAccessResource')
				->with($this->equalTo($resource1),
					   $this->equalTo($session))
				->will($this->returnValue(false));

		$this->permissionService
				->expects($this->at(1))
				->method('CanAccessResource')
				->with($this->equalTo($resource2),
					   $this->equalTo($session))
				->will($this->returnValue(true));

		$this->userRepository->expects($this->any())
							->method('LoadById')
							->with($this->equalTo($session->UserId))
							->will($this->returnValue($user));

		$resourceDto1 = new ResourceDto(1, 'resource1', false, $resource1->GetScheduleId(), $resource1->GetMinLength());
		$resourceDto2 = new ResourceDto(2, 'resource2', true, $resource2->GetScheduleId(), $resource2->GetMinLength());

		$expected = array($resourceDto1, $resourceDto2);

		$actual = $this->resourceService->GetAllResources(true, $session);

		$this->assertEquals($expected, $actual);
	}

	public function testChecksStatusOfEachResourceWhenGettingAll()
	{
		$scheduleId = 100;
		$session = $this->fakeUser;

		$user = new FakeUser();
		$user->_IsResourceAdmin = false;

		$resource1 = new FakeBookableResource(1, 'resource1');
		$resource1->ChangeStatus(ResourceStatus::UNAVAILABLE);
		$resources = array($resource1);

		$this->resourceRepository
				->expects($this->once())
				->method('GetScheduleResources')
				->with($this->equalTo($scheduleId))
				->will($this->returnValue($resources));

		$this->permissionService
				->expects($this->at(0))
				->method('CanAccessResource')
				->with($this->equalTo($resource1),
					   $this->equalTo($session))
				->will($this->returnValue(true));
		
		$this->userRepository->expects($this->once())
					->method('LoadById')
					->with($this->equalTo($session->UserId))
					->will($this->returnValue($user));

		$resourceDto1 = new ResourceDto(1, 'resource1', false, $resource1->GetScheduleId(), $resource1->GetMinLength());

		$expected = array($resourceDto1);

		$actual = $this->resourceService->GetScheduleResources($scheduleId, true, $session);

		$this->assertEquals($expected, $actual);
	}

	public function testResourcesAreNotReturnedIfNotIncludingInaccessibleResources()
	{
		$scheduleId = 100;
		$user = $this->fakeUser;

		$resource1 = new FakeBookableResource(1, 'resource1');

		$this->resourceRepository
				->expects($this->once())
				->method('GetScheduleResources')
				->with($this->equalTo($scheduleId))
				->will($this->returnValue(array($resource1)));

		$this->permissionService
				->expects($this->at(0))
				->method('CanAccessResource')
				->with($this->equalTo($resource1))
				->will($this->returnValue(false));

		$includeInaccessibleResources = false;
		$actual = $this->resourceService->GetScheduleResources($scheduleId, $includeInaccessibleResources, $user);

		$this->assertEquals(0, count($actual));
	}

	public function testGetsAccessoriesFromRepository()
	{
		$accessoryDtos = array(new AccessoryDto(4, "lksjdf", 23));

		$this->resourceRepository
				->expects($this->once())
				->method('GetAccessoryList')
				->will($this->returnValue($accessoryDtos));

		$actualAccessories = $this->resourceService->GetAccessories();

		$this->assertEquals($accessoryDtos, $actualAccessories);
	}

	public function testFiltersResources()
	{
		$scheduleId = 122;
		$resourceId = 4;

		$resource1 = new FakeBookableResource(1, 'resource1');
		$resource2 = new FakeBookableResource(2, 'resource2');
		$resource3 = new FakeBookableResource(3, 'resource3');
		$resource4 = new FakeBookableResource(4, 'resource4');
		$resources = array($resource1, $resource2, $resource3, $resource4);

		$this->resourceRepository
				->expects($this->once())
				->method('GetScheduleResources')
				->with($this->equalTo($scheduleId))
				->will($this->returnValue($resources));

		$this->permissionService
				->expects($this->any())
				->method('CanAccessResource')
				->with($this->anything(), $this->anything())
				->will($this->returnValue(true));

		$filter = $this->getMock('IScheduleResourceFilter');

		$filter->expects($this->once())
			   ->method('FilterResources')
			   ->with($this->equalTo($resources), $this->equalTo($this->resourceRepository))
			   ->will($this->returnValue(array($resourceId)));

		$resources = $this->resourceService->GetScheduleResources($scheduleId, true, $this->fakeUser, $filter);

		$this->assertEquals(1, count($resources));
		$this->assertEquals(4, $resources[0]->GetId());
	}

	public function testGetsResourceCustomAttributes()
	{
		$customAttributes = array(new FakeCustomAttribute(1));

		$this->attributeService->expects($this->once())
							   ->method('GetByCategory')
							   ->with($this->equalTo(CustomAttributeCategory::RESOURCE))
							   ->will($this->returnValue($customAttributes));

		$attributes = $this->resourceService->GetResourceAttributes();

		$this->assertEquals(1, count($attributes));
		$this->assertEquals($customAttributes[0]->Id(), $attributes[0]->Id());
	}

	public function testGetsResourceTypeCustomAttributes()
	{
		$customAttributes = array(new FakeCustomAttribute(1));

		$this->attributeService->expects($this->once())
							   ->method('GetByCategory')
							   ->with($this->equalTo(CustomAttributeCategory::RESOURCE_TYPE))
							   ->will($this->returnValue($customAttributes));

		$attributes = $this->resourceService->GetResourceTypeAttributes();

		$this->assertEquals(1, count($attributes));
		$this->assertEquals($customAttributes[0]->Id(), $attributes[0]->Id());
	}

	public function testFiltersResourcesWhenGettingResourceGroups()
	{
		$scheduleId = 18;
		$expectedGroups = new FakeResourceGroupTree();
		$expectedGroups->AddGroup(new ResourceGroup(1, 'g'));

		$this->resourceRepository->expects($this->once())
								 ->method('GetResourceGroups')
								 ->with($this->equalTo($scheduleId), $this->anything())
								 ->will($this->returnValue($expectedGroups));

		$groups = $this->resourceService->GetResourceGroups($scheduleId, $this->fakeUser);

		$this->assertEquals($expectedGroups, $groups);
	}
}

?>
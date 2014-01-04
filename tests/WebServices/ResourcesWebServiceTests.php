<?php
/**
Copyright 2012-2014 Nick Korbel

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

require_once(ROOT_DIR . 'WebServices/ResourcesWebService.php');

class ResourcesWebServiceTests extends TestBase
{
	/**
	 * @var FakeRestServer
	 */
	private $server;

	/**
	 * @var IResourceRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $repository;

	/**
	 * @var IAttributeService|PHPUnit_Framework_MockObject_MockObject
	 */
	private $attributeService;

	/**
	 * @var ResourcesWebService
	 */
	private $service;

	public function setup()
	{
		parent::setup();

		$this->server = new FakeRestServer();
		$this->repository = $this->getMock('IResourceRepository');
		$this->attributeService = $this->getMock('IAttributeService');

		$this->service = new ResourcesWebService($this->server, $this->repository, $this->attributeService);
	}

	public function testGetsResourceById()
	{
		$resourceId = 8282;
		$resource = new FakeBookableResource($resourceId);
		$resource->SetBufferTime(3600);

		$attributes = new AttributeList();

		$this->repository->expects($this->once())
				->method('LoadById')
				->with($this->equalTo($resourceId))
				->will($this->returnValue($resource));

		$this->attributeService->expects($this->once())
				->method('GetAttributes')
				->with($this->equalTo(CustomAttributeCategory::RESOURCE), $this->equalTo(array($resourceId)))
				->will($this->returnValue($attributes));

		$this->service->GetResource($resourceId);

		$this->assertEquals(new ResourceResponse($this->server, $resource, $attributes), $this->server->_LastResponse);
	}

	public function testWhenNotFound()
	{
		$resourceId = 8282;
		$this->repository->expects($this->once())
				->method('LoadById')
				->with($this->equalTo($resourceId))
				->will($this->returnValue(BookableResource::Null()));

		$this->service->GetResource($resourceId);

		$this->assertEquals(RestResponse::NotFound(), $this->server->_LastResponse);
	}

	public function testGetsResourceList()
	{
		$resourceId = 123;
		$resources[] = new FakeBookableResource($resourceId);
		$attributes = new AttributeList();

		$this->repository->expects($this->once())
				->method('GetResourceList')
				->will($this->returnValue($resources));

		$this->attributeService->expects($this->once())
				->method('GetAttributes')
				->with($this->equalTo(CustomAttributeCategory::RESOURCE), $this->equalTo(array($resourceId)))
				->will($this->returnValue($attributes));

		$this->service->GetAll();

		$this->assertEquals(new ResourcesResponse($this->server, $resources, $attributes), $this->server->_LastResponse);
	}

	public function testGetsStatuses()
	{
		$this->service->GetStatuses();

		$this->assertEquals(new ResourceStatusResponse(), $this->server->_LastResponse);
	}

	public function testGetsStatusReasons()
	{
		$reasons = array(new ResourceStatusReason(1, ResourceStatus::AVAILABLE));

		$this->repository->expects($this->once())
						->method('GetStatusReasons')
						->will($this->returnValue($reasons));

		$this->service->GetStatusReasons();

		$this->assertEquals(new ResourceStatusReasonsResponse($this->server, $reasons), $this->server->_LastResponse);
	}
}

?>
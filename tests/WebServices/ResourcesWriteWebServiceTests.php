<?php
/**
Copyright 2013-2020 Nick Korbel

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

require_once(ROOT_DIR . 'WebServices/ResourcesWriteWebService.php');

class ResourcesWriteWebServiceTests extends TestBase
{
	/**
	 * @var ResourcesWriteWebService
	 */
	private $service;

	/**
	 * @var FakeRestServer
	 */
	private $server;

	/**
	 * @var PHPUnit_Framework_MockObject_MockObject|IResourceSaveController
	 */
	private $controller;

	public function setUp(): void
	{
		parent::setup();

		$this->server = new FakeRestServer();
		$this->controller = $this->createMock('IResourceSaveController');

		$this->service = new ResourcesWriteWebService($this->server, $this->controller);
	}

	public function testCanCreateNewResource()
	{
		$resourceId = '1';

		$request = new ResourceRequest();
		$this->server->SetRequest($request);

		$controllerResult = new ResourceControllerResult($resourceId);

		$this->controller->expects($this->once())
				->method('Create')
				->with($this->equalTo($request), $this->equalTo($this->server->GetSession()))
				->will($this->returnValue($controllerResult));

		$this->service->Create();

		$this->assertEquals(new ResourceCreatedResponse($this->server, $resourceId), $this->server->_LastResponse);
	}

	public function testFailedCreate()
	{
		$request = new ResourceRequest();
		$this->server->SetRequest($request);

		$errors = array('error');
		$controllerResult = new ResourceControllerResult(null, $errors);

		$this->controller->expects($this->once())
				->method('Create')
				->with($this->equalTo($request), $this->equalTo($this->server->GetSession()))
				->will($this->returnValue($controllerResult));

		$this->service->Create();

		$this->assertEquals(new FailedResponse($this->server, $errors), $this->server->_LastResponse);
		$this->assertEquals(RestResponse::BAD_REQUEST_CODE, $this->server->_LastResponseCode);
	}

	public function testCanUpdateResource()
	{
		$resourceId = '1';

		$request = new ResourceRequest();
		$this->server->SetRequest($request);

		$controllerResult = new ResourceControllerResult($resourceId);

		$this->controller->expects($this->once())
				->method('Update')
				->with($this->equalTo($resourceId), $this->equalTo($request),
					   $this->equalTo($this->server->GetSession()))
				->will($this->returnValue($controllerResult));

		$this->service->Update($resourceId);

		$this->assertEquals(new ResourceUpdatedResponse($this->server, $resourceId), $this->server->_LastResponse);
	}

	public function testFailedUpdate()
	{
		$resourceId = 123;
		$request = new ResourceRequest();
		$this->server->SetRequest($request);

		$errors = array('error');
		$controllerResult = new ResourceControllerResult(null, $errors);

		$this->controller->expects($this->once())
				->method('Update')
				->with($this->equalTo($resourceId), $this->equalTo($request),
					   $this->equalTo($this->server->GetSession()))
				->will($this->returnValue($controllerResult));

		$this->service->Update($resourceId);

		$this->assertEquals(new FailedResponse($this->server, $errors), $this->server->_LastResponse);
		$this->assertEquals(RestResponse::BAD_REQUEST_CODE, $this->server->_LastResponseCode);
	}

	public function testCanDeleteResource()
	{
		$resourceId = '1';

		$controllerResult = new ResourceControllerResult($resourceId);

		$this->controller->expects($this->once())
				->method('Delete')
				->with($this->equalTo($resourceId), $this->equalTo($this->server->GetSession()))
				->will($this->returnValue($controllerResult));

		$this->service->Delete($resourceId);

		$this->assertEquals(new DeletedResponse(), $this->server->_LastResponse);
	}

	public function testFailedDelete()
	{
		$resourceId = 123;

		$errors = array('error');
		$controllerResult = new ResourceControllerResult(null, $errors);

		$this->controller->expects($this->once())
				->method('Delete')
				->with($this->equalTo($resourceId), $this->equalTo($this->server->GetSession()))
				->will($this->returnValue($controllerResult));

		$this->service->Delete($resourceId);

		$this->assertEquals(new FailedResponse($this->server, $errors), $this->server->_LastResponse);
		$this->assertEquals(RestResponse::BAD_REQUEST_CODE, $this->server->_LastResponseCode);
	}
}

?>
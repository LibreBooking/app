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

require_once(ROOT_DIR . 'WebServices/ResourcesWebService.php');

class ResourcesWebServiceTests extends TestBase
{
	/**
	 * @var FakeRestServer
	 */
	private $server;

	/**
	 * @var IResourceRepository
	 */
	private $repository;

	/**
	 * @var ResourcesWebService
	 */
	private $service;

	public function setup()
	{
		parent::setup();

		$this->server = new FakeRestServer();
		$this->repository = $this->getMock('IResourceRepository');

		$this->service = new ResourcesWebService($this->server, $this->repository);
	}

	public function testGetsResourceById()
	{
		$resourceId = 8282;
		$resource = new FakeBookableResource($resourceId);

		$this->repository->expects($this->once())
					->method('LoadById')
					->with($this->equalTo($resourceId))
					->will($this->returnValue($resource));

		$this->service->GetResource($resourceId);

		$this->assertEquals(new ResourceResponse($this->server, $resource), $this->server->_LastResponse);
	}
}
?>
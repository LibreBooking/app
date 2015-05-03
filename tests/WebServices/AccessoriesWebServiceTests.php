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

require_once(ROOT_DIR . 'WebServices/AccessoriesWebService.php');


class AccessoriesWebServiceTests extends TestBase
{
	/**
	 * @var AccessoriesWebService
	 */
	private $service;

	/**
	 * @var FakeRestServer
	 */
	private $server;

	/**
	 * @var IResourceRepository
	 */
	private $resourceRepository;

	/**
	 * @var IAccessoryRepository
	 */
	private $accessoryRepository;

	public function setup()
	{
		$this->server = new FakeRestServer();
		$this->resourceRepository = $this->getMock('IResourceRepository');
		$this->accessoryRepository = $this->getMock('IAccessoryRepository');

		$this->service = new AccessoriesWebService($this->server, $this->resourceRepository, $this->accessoryRepository);
		parent::setup();
	}

	public function testGetsAllAccessories()
	{
		$accessories = array(new AccessoryDto(1, 'name', 23));

		$this->resourceRepository->expects($this->once())
				->method('GetAccessoryList')
				->will($this->returnValue($accessories));

		$this->service->GetAll();

		$this->assertEquals(new AccessoriesResponse($this->server, $accessories), $this->server->_LastResponse);
		$this->assertEquals(RestResponse::OK_CODE, $this->server->_LastResponseCode);
	}

	public function testGetsAccessoryById()
	{
		$accessoryId = 1233;

		$accessory = new Accessory($accessoryId, 'name', 123);

		$this->accessoryRepository->expects($this->once())
				->method('LoadById')
				->with($this->equalTo($accessoryId))
				->will($this->returnValue($accessory));

		$this->service->GetAccessory($accessoryId);

		$this->assertEquals(new AccessoryResponse($this->server, $accessory), $this->server->_LastResponse);
		$this->assertEquals(RestResponse::OK_CODE, $this->server->_LastResponseCode);
	}

	public function testWhenAccessoryNotFound()
	{
		$accessoryId = 1233;

		$this->accessoryRepository->expects($this->once())
				->method('LoadById')
				->with($this->equalTo($accessoryId))
				->will($this->returnValue(null));

		$this->service->GetAccessory($accessoryId);

		$this->assertEquals(RestResponse::NotFound(), $this->server->_LastResponse);
		$this->assertEquals(RestResponse::NOT_FOUND_CODE, $this->server->_LastResponseCode);
	}
}
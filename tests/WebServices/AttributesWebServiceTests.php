<?php
/**
Copyright 2012-2017 Nick Korbel

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

require_once(ROOT_DIR . 'WebServices/AttributesWebService.php');

class AttributesWebServiceTests extends TestBase
{
	/**
	 * @var IAttributeService|PHPUnit_Framework_MockObject_MockObject
	 */
	private $attributeService;

	/**
	 * @var AttributesWebService
	 */
	private $service;

	/**
	 * @var FakeRestServer
	 */
	private $server;

	public function setup()
	{
		parent::setup();

		$this->attributeService = $this->getMock('IAttributeService');
		$this->server = new FakeRestServer();

		$this->service = new AttributesWebService($this->server, $this->attributeService);
	}


	public function testGetsSingleAttribute()
	{
		$attributeId = 123;
		$attribute = new TestCustomAttribute($attributeId, 'label');

		$this->attributeService->expects($this->once())
				->method('GetById')
				->with($this->equalTo($attributeId))
				->will($this->returnValue($attribute));

		$expectedResponse = new CustomAttributeDefinitionResponse($this->server, $attribute);

		$this->service->GetAttribute($attributeId);

		$this->assertEquals($expectedResponse, $this->server->_LastResponse);
	}

	public function testWhenAttributeNotFound()
	{
		$attributeId = 123;

		$this->attributeService->expects($this->once())
				->method('GetById')
				->with($this->equalTo($attributeId))
				->will($this->returnValue(null));

		$this->service->GetAttribute($attributeId);

		$this->assertEquals(RestResponse::NotFound(), $this->server->_LastResponse);
	}

	public function testGetsAttributesByCategory()
	{
		$attributes = array(new TestCustomAttribute(1, 'label'));

		$categoryId = CustomAttributeCategory::RESERVATION;
		$this->attributeService->expects($this->once())
				->method('GetByCategory')
				->with($this->equalTo($categoryId))
				->will($this->returnValue($attributes));

		$expectedResponse = new CustomAttributesResponse($this->server, $attributes);

		$this->service->GetAttributes($categoryId);

		$this->assertEquals($expectedResponse, $this->server->_LastResponse);
	}

}

?>
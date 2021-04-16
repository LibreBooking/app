<?php

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

	public function setUp(): void
	{
		parent::setup();

		$this->attributeService = $this->createMock('IAttributeService');
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

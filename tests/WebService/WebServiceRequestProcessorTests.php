<?php
require_once(ROOT_DIR . 'lib/WebService/RestRequestProcessor.php');

class WebServiceRequestProcessorTests extends TestBase
{
	/**
	 * @var IRestService|PHPUnit_Framework_MockObject_MockObject
	 */
	private $service;

	/**
	 * @var IRestServer|PHPUnit_Framework_MockObject_MockObject
	 */
	private $server;

	/**
	 * @var RestRequestProcessor
	 */
	private $processor;

	public function setup()
	{
		parent::setup();

		$this->service = $this->getMock('IRestService');
		$this->server = $this->getMock('IRestServer');
		$this->processor = new RestRequestProcessor($this->service, $this->server);
	}
	
	public function testRoutesPostRequestsToPostServiceMethod()
	{
		$response = new RestResponse();

		$this->server->expects($this->once())
				->method('IsPost')
				->will($this->returnValue(true));

		$this->server->expects($this->any())
				->method('IsGet')
				->will($this->returnValue(false));


		$this->service->expects($this->once())
				->method('HandlePost')
				->with($this->equalTo($this->server))
				->will($this->returnValue($response));

		$this->server->expects($this->once())
				->method('Respond')
				->with($this->equalTo($response));

		$this->processor->ProcessRequest();
	}

	public function testRoutesGetRequestsToGetServiceMethod()
	{
		$response = new RestResponse();

		$this->server->expects($this->any())
				->method('IsPost')
				->will($this->returnValue(false));

		$this->server->expects($this->any())
				->method('IsGet')
				->will($this->returnValue(true));

		$this->service->expects($this->once())
				->method('HandleGet')
				->with($this->equalTo($this->server))
				->will($this->returnValue($response));

		$this->server->expects($this->once())
				->method('Respond')
				->with($this->equalTo($response));

		$this->processor->ProcessRequest();
	}
}

?>
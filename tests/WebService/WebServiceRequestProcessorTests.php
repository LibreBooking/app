<?php
/**
Copyright 2011-2012 Nick Korbel

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
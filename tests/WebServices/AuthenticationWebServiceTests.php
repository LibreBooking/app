<?php
/**
Copyright 2011-2016 Nick Korbel

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

require_once(ROOT_DIR . 'WebServices/AuthenticationWebService.php');

class AuthenticationWebServiceTests extends TestBase
{
	/**
	 * @var IWebServiceAuthentication|PHPUnit_Framework_MockObject_MockObject
	 */
	private $authentication;

	/**
	 * @var AuthenticationWebService
	 */
	private $service;

	/**
	 * @var FakeRestServer
	 */
	private $server;

	public function setup()
	{
		parent::setup();

		$this->authentication = $this->getMock('IWebServiceAuthentication');
		$this->server = new FakeRestServer();

		$this->service = new AuthenticationWebService($this->server, $this->authentication);
	}

	public function testLogsUserInIfValidCredentials()
	{
		$username = 'un';
		$password = 'pw';
		$session = new UserSession(1);

		$request = new AuthenticationRequest($username, $password);
		$this->server->SetRequest($request);

		$this->authentication->expects($this->once())
				->method('Validate')
				->with($this->equalTo($username), $this->equalTo($password))
				->will($this->returnValue(true));

		$this->authentication->expects($this->once())
				->method('Login')
				->with($this->equalTo($username))
				->will($this->returnValue($session));

		$this->service->Authenticate($this->server);

		$expectedResponse = AuthenticationResponse::Success($this->server, $session, 0);
		$this->assertEquals($expectedResponse, $this->server->_LastResponse);
	}

	public function testRestrictsUserIfInvalidCredentials()
	{
		$username = 'un';
		$password = 'pw';

		$request = new AuthenticationRequest($username, $password);
		$this->server->SetRequest($request);

		$this->authentication->expects($this->once())
				->method('Validate')
				->with($this->equalTo($username), $this->equalTo($password))
				->will($this->returnValue(false));

		 $this->service->Authenticate($this->server);

		$expectedResponse = AuthenticationResponse::Failed();
		$this->assertEquals($expectedResponse, $this->server->_LastResponse);
	}

	public function testSignsUserOut()
	{
		$userId = 'ddddd';
		$sessionToken = 'sssss';

		$request = new SignOutRequest($userId, $sessionToken);
		$this->server->SetRequest($request);

		$this->authentication->expects($this->once())
				->method('Logout')
				->with($this->equalTo($userId), $this->equalTo($sessionToken));

		$this->service->SignOut($this->server);
	}
}
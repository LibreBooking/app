<?php

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

	public function setUp(): void
	{
		parent::setup();

		$this->authentication = $this->createMock('IWebServiceAuthentication');
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

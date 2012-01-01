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

require_once(ROOT_DIR . 'WebServices/AuthenticationWebService.php');

class AuthenticationWebServiceTests extends TestBase
{
	/**
	 * @var IAuthentication
	 */
	private $authentication;

	/**
	 * @var AuthenticationWebService
	 */
	private $service;

	/**
	 * @var FakeWebServiceServer
	 */
	private $server;

	public function setup()
	{
		parent::setup();

		$this->authentication = $this->getMock('IAuthentication');
		$this->server = new FakeWebServiceServer($this->fakeServer);

		$this->service = new AuthenticationWebService($this->authentication);
	}
	
	public function testLogsUserInIfValidCredentials()
	{
		$username = 'un';
		$password = 'pw';

		$this->server->SetPost(RestParams::UserName, $username);
		$this->server->SetPost(RestParams::Password, $password);

		$this->authentication->expects($this->once())
			->method('Validate')
			->with($this->equalTo($username), $this->equalTo($password))
			->will($this->returnValue(true));

		$this->authentication->expects($this->once())
			->method('Login')
			->with($this->equalTo($username), $this->equalTo(false));

		$response = $this->service->Authenticate($this->server);
				
		$session = $this->server->GetUserSession();

		$expectedResponse = AuthenticationResponse::Success($session);
		$this->assertEquals($expectedResponse, $response);
	}

	public function testRestrictsUserIfInvalidCredentials()
	{
		$username = 'un';
		$password = 'pw';

		$this->server->SetPost(RestParams::UserName, $username);
		$this->server->SetPost(RestParams::Password, $password);

		$this->authentication->expects($this->once())
			->method('Validate')
			->with($this->equalTo($username), $this->equalTo($password))
			->will($this->returnValue(false));

		$response = $this->service->Authenticate($this->server);

		$expectedResponse = AuthenticationResponse::Failed();
		$this->assertEquals($expectedResponse, $response);
	}

	public function testSignsUserOut()
	{
		$this->authentication->expects($this->once())
			->method('LogOut')
			->with($this->equalTo($this->fakeUser));

		$response = $this->service->SignOut($this->server);

		$this->assertEquals(new SignOutResponse(), $response);
	}
}

class FakeWebServiceServer implements IRestServer
{
	/**
	 * @var \FakeServer
	 */
	public $server;
	
	public function __construct(FakeServer $server)
	{
	    $this->server = $server;
	}
	
	public $_IsPost = false;
	public $_IsGet = false;
	public $_LastResponse = null;
	public $_PostValues = array();
	public $_GetValues = array();
	public $_ServiceAction = null;

	/**
	 * @return bool
	 */
	public function IsPost()
	{
		return $this->_IsPost;
	}

	/**
	 * @return bool
	 */
	public function IsGet()
	{
		return $this->_IsGet;
	}

	/**
	 * @param RestResponse $response
	 * @return void
	 */
	public function Respond(RestResponse $response)
	{
		$this->_LastResponse = $response;
	}

	/**
	 * @param string $variableName
	 * @return mixed
	 */
	public function GetPost($variableName)
	{
		return $this->server->GetForm($variableName);
	}

	/**
	 * @param string $variableName
	 * @return mixed
	 */
	public function GetQueryString($variableName)
	{
		return $this->server->GetQuerystring($variableName);
	}

	public function SetPost($variableName, $value)
	{
		$this->server->SetForm($variableName, $value);
	}

	public function SetQueryString($variableName, $value)
	{
		$this->server->SetQuerystring($variableName, $value);
	}

	public function GetUserSession()
	{
		return $this->server->GetUserSession();
	}

	/**
	 * @return string|WebServiceAction
	 */
	public function GetServiceAction()
	{
		return $this->_ServiceAction;
	}

    /**
     * @param IExactRestResponse $response
     * @return void
     */
    public function RespondExact(IExactRestResponse $response)
    {
        // TODO: Implement RespondExact() method.
    }
}
?>
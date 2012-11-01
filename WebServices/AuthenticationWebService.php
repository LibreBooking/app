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

require_once(ROOT_DIR . 'lib/WebService/IRestServer.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');

class AuthenticationWebService
{
	/**
	 * @var IWebServiceAuthentication
	 */
	private $authentication;

	public function __construct(IRestServer $server, IWebServiceAuthentication $authentication)
	{
		$this->server = $server;
		$this->authentication = $authentication;
	}

	/**
	 * @name Authenticate
	 * @request AuthenticationRequest
	 * @response AuthenticationResponse
	 * @return void
	 */
	public function Authenticate()
	{
		/** @var $request AuthenticationRequest */
		$request = $this->server->GetRequest();
		$username = $request->username;
		$password = $request->password;

		Log::Debug('WebService Authenticate for user %s', $username);

		$isValid = $this->authentication->Validate($username, $password);
		if ($isValid)
		{
			Log::Debug('WebService Authenticate, user %s was authenticated', $username);

			$session = $this->authentication->Login($username);
			$this->server->WriteResponse(AuthenticationResponse::Success($this->server, $session));
		}
		else
		{
			Log::Debug('WebService Authenticate, user %s was not authenticated', $username);

			$this->server->WriteResponse(AuthenticationResponse::Failed());
		}
	}


//	public function SignOut()
//	{
//		$this->authentication->Logout($server->GetUserSession());
//
//		return new SignOutResponse();
//	}
}

class AuthenticationRequest
{
	/**
	 * @var string
	 */
	public $username;
	/**
	 * @var string
	 */
	public $password;

	/**
	 * @param string $username
	 * @param string $password
	 */
	public function __construct($username = null, $password = null)
	{
		$this->username = $username;
		$this->password = $password;
	}
}

class AuthenticationResponseBody
{
	public $sessionToken = '';
	public $userId = '';
	public $isAuthenticated = false;

	public function __construct($sessionToken = null, $userId = null)
	{
		$this->sessionToken = $sessionToken;
		$this->userId = $userId;
		$this->isAuthenticated = !empty($sessionToken) && !empty($userId);
	}
}

class SignOutResponse extends RestResponse
{
	public function __construct()
	{
		$this->Message = 'Sign Out successful';
	}
}

class AuthenticationResponse extends RestResponse
{
	public $token;
	public $expires;
	public $userId;

	/**
	 * @static
	 * @param $server IRestServer
	 * @param $userSession UserSession
	 * @return AuthenticationResponse
	 */
	public static function Success(IRestServer $server, $userSession)
	{
		$response = new AuthenticationResponse($server);
		$response->token = new AuthenticationResponseBody($userSession->SessionToken, $userSession->UserId);

		//$response->AddService($server, WebServices::AllBookings);
//		$response->AddAction(RestAction::MyBookings());
//		$response->AddAction(RestAction::CreateBooking());

		return $response;
	}

	/**
	 * @static
	 * @return AuthenticationResponse
	 */
	public static function Failed()
	{
		$response = new AuthenticationResponse();
		$response->message = 'Login failed. Invalid username or password.';
		return $response;
	}
}

//class EchoResponse extends RestResponse
//{
//	public function __construct(IRestServer $server)
//	{
//	    $this->Body = $_POST;
//	}
//}
?>
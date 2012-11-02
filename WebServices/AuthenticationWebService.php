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

require_once(ROOT_DIR . 'lib/WebService/namespace.php');
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
	 * @description Authenticates an existing phpScheduleIt user
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

	/**
	 * @name SignOut
	 * @request SignOutRequest
	 * @return void
	 */
	public function SignOut()
	{
		/** @var $request SignOutRequest */
		$request = $this->server->GetRequest();
		$userId = $request->userId;
		$sessionToken = $request->sessionToken;

		Log::Debug('WebService SignOut for userId %s and sessionToken %s', $userId, $sessionToken);

		$this->authentication->Logout($userId, $sessionToken);
	}
}

class WebServiceExpiration
{
	/**
	 * @param string $loginTime
	 * @return string
	 */
	public static function Parse($loginTime)
	{
		return Date::FromDatabase($loginTime)->ToIso();
	}
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


class AuthenticationResponse extends RestResponse
{
	public $sessionToken;
	public $sessionExpires;
	public $userId;
	public $isAuthenticated = false;

	/**
	 * @static
	 * @param $server IRestServer
	 * @param $userSession UserSession
	 * @return AuthenticationResponse
	 */
	public static function Success(IRestServer $server, $userSession)
	{
		$response = new AuthenticationResponse($server);
		$response->sessionToken = $userSession->SessionToken;
		$response->sessionExpires = WebServiceExpiration::Parse($userSession->LoginTime);
		$response->isAuthenticated = true;
		$response->userId = $userSession->PublicId;

		$response->AddService($server, WebServices::Logout);
		//$response->AddService($server, WebServices::MyBookings, array($userSession->PublicId));
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

class SignOutRequest
{
	/**
	 * @var string
	 */
	public $userId;
	/**
	 * @var string
	 */
	public $sessionToken;

	/**
	 * @param string $userId
	 * @param string $sessionToken
	 */
	public function __construct($userId = null, $sessionToken = null)
	{
		$this->userId = $userId;
		$this->sessionToken = $sessionToken;
	}
}

?>
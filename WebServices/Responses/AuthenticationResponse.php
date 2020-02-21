<?php
/**
Copyright 2012-2020 Nick Korbel

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

require_once(ROOT_DIR . 'lib/WebService/namespace.php');

class AuthenticationResponse extends RestResponse
{
	public $sessionToken;
	public $sessionExpires;
	public $userId;
	public $isAuthenticated = false;
	public $version;
	
	/**
	 * @static
	 * @param $server IRestServer
	 * @param $userSession WebServiceUserSession
	 * @return AuthenticationResponse
	 */
	public static function Success(IRestServer $server, $userSession, $version)
	{
		$response = new AuthenticationResponse($server);
		$response->sessionToken = $userSession->SessionToken;
		$response->sessionExpires = $userSession->SessionExpiration;
		$response->isAuthenticated = true;
		$response->userId = $userSession->UserId;
		$response->version = $version;
		
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

	public static function Example()
	{
		return new ExampleAuthenticationResponse();
	}
}

class ExampleAuthenticationResponse extends AuthenticationResponse
{
	public function __construct()
	{
		$this->sessionToken = 'sessiontoken';
		$this->sessionExpires = Date::Now()->ToIso();
		$this->isAuthenticated = true;
		$this->userId = 123;
		$this->version = '1.0';
	}
}

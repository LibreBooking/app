<?php
/**
Copyright 2011-2019 Nick Korbel

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
require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');
require_once(ROOT_DIR . 'WebServices/Responses/AuthenticationResponse.php');
require_once(ROOT_DIR . 'WebServices/Requests/AuthenticationRequest.php');
require_once(ROOT_DIR . 'WebServices/Requests/SignOutRequest.php');

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
	 * @description Authenticates an existing Booked Scheduler user
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

			$version = 0;
			$reader = ServiceLocator::GetDatabase()->Query(new GetVersionCommand());
			if ($row = $reader->GetRow())
			{
				$version = $row[ColumnNames::VERSION_NUMBER];
			}
			$reader->Free();
			
			$session = $this->authentication->Login($username);
			Log::Debug('SessionToken=%s', $session->SessionToken);
			$this->server->WriteResponse(AuthenticationResponse::Success($this->server, $session, $version));
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
		$r = new RestResponse();
		$r->signedOut = true;
		$this->server->WriteResponse($r);
	}


}


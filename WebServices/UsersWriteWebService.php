<?php
/**
Copyright 2013 Nick Korbel

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

require_once(ROOT_DIR . 'WebServices/Controllers/UserSaveController.php');
require_once(ROOT_DIR . 'WebServices/Requests/CreateUserRequest.php');
require_once(ROOT_DIR . 'WebServices/Responses/UserCreatedResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/FailedResponse.php');

class UsersWriteWebService
{
	/**
	 * @var IRestServer
	 */
	private $server;

	/**
	 * @var IUserSaveController
	 */
	private $controller;

	public function __construct(IRestServer $server, IUserSaveController $controller)
	{
		$this->server = $server;
		$this->controller = $controller;
	}

	public function Create()
	{
		/** @var $request CreateUserRequest */
		$request = $this->server->GetRequest();

		Log::Debug('UsersWriteWebService.Create() User=%s, Request=%s', $this->server->GetSession()->UserId,
				   json_encode($request));

		$result = $this->controller->Create($request, $this->server->GetSession());

		if ($result->WasSuccessful())
		{
			Log::Debug('UsersWriteWebService.Create() - User Created. UserId=%s',
					   $result->UserId());

			$this->server->WriteResponse(new UserCreatedResponse($this->server, $result->UserId()),
										 RestResponse::CREATED_CODE);
		}
		else
		{
			Log::Debug('UsersWriteWebService.Create() - User Create Failed.');

			$this->server->WriteResponse(new FailedResponse($this->server, $result->Errors()),
										 RestResponse::BAD_REQUEST_CODE);
		}
	}
}

?>
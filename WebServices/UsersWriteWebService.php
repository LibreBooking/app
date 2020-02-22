<?php
/**
Copyright 2013-2020 Nick Korbel

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
require_once(ROOT_DIR . 'WebServices/Controllers/UserSaveController.php');
require_once(ROOT_DIR . 'WebServices/Requests/User/CreateUserRequest.php');
require_once(ROOT_DIR . 'WebServices/Requests/User/UpdateUserRequest.php');
require_once(ROOT_DIR . 'WebServices/Requests/User/UpdateUserPasswordRequest.php');
require_once(ROOT_DIR . 'WebServices/Responses/UserCreatedResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/UserUpdatedResponse.php');

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

	/**
	 * @name CreateUser
	 * @description Creates a new user
	 * @request CreateUserRequest
	 * @response UserCreatedResponse
	 * @return void
	 */
	public function Create()
	{
		/** @var $request CreateUserRequest */
		$request = new CreateUserRequest($this->server->GetRequest());

		Log::Debug('UsersWriteWebService.Create() User=%s', $this->server->GetSession()->UserId);

		$result = $this->controller->Create($request, $this->server->GetSession());

		if ($result->WasSuccessful())
		{
			Log::Debug('UsersWriteWebService.Create() - User Created. Created UserId=%s',
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

	/**
	 * @name UpdateUser
	 * @description Updates an existing user
	 * @request UpdateUserRequest
	 * @response UserUpdatedResponse
	 * @param $userId
	 * @return void
	 */
	public function Update($userId)
	{
		/** @var $request UpdateUserRequest */
		$request = new UpdateUserRequest($this->server->GetRequest());

		Log::Debug('UsersWriteWebService.Update() User=%s', $this->server->GetSession()->UserId);

		$result = $this->controller->Update($userId, $request, $this->server->GetSession());

		if ($result->WasSuccessful())
		{
			Log::Debug('UsersWriteWebService.Update() - User Updated. UserId=%s',
					   $result->UserId());

			$this->server->WriteResponse(new UserUpdatedResponse($this->server, $result->UserId()),
										 RestResponse::OK_CODE);
		}
		else
		{
			Log::Debug('UsersWriteWebService.Create() - User Update Failed.');

			$this->server->WriteResponse(new FailedResponse($this->server, $result->Errors()),
										 RestResponse::BAD_REQUEST_CODE);
		}
	}

	/**
	 * @name DeleteUser
	 * @description Deletes an existing user
	 * @response DeletedResponse
	 * @param int $userId
	 * @return void
	 */
	public function Delete($userId)
	{
		Log::Debug('UsersWriteWebService.Delete() User=%s', $this->server->GetSession()->UserId);

		$result = $this->controller->Delete($userId, $this->server->GetSession());

		if ($result->WasSuccessful())
		{
			Log::Debug('UsersWriteWebService.Delete() - User Deleted. UserId=%s',
					   $result->UserId());

			$this->server->WriteResponse(new DeletedResponse(), RestResponse::OK_CODE);
		}
		else
		{
			Log::Debug('UsersWriteWebService.Delete() - User Delete Failed.');

			$this->server->WriteResponse(new FailedResponse($this->server, $result->Errors()),
										 RestResponse::BAD_REQUEST_CODE);
		}
	}

    /**
     * @name UpdatePassword
     * @description Updates the password for an existing user
     * @request UpdateUserPasswordRequest
     * @response UserUpdatedResponse
     * @param int $userId
     * @return void
     */
    public function UpdatePassword($userId)
    {
        Log::Debug('UsersWriteWebService.UpdatePassword() User=%s', $this->server->GetSession()->UserId);

        /** @var $request UpdateUserPasswordRequest */
        $request = new UpdateUserPasswordRequest($this->server->GetRequest());

        $result = $this->controller->UpdatePassword($userId, $request->password, $this->server->GetSession());

        if ($result->WasSuccessful())
        {
            Log::Debug('UsersWriteWebService.UpdatePassword() - User password updated. UserId=%s',
                $result->UserId());

            $this->server->WriteResponse(new UserUpdatedResponse($this->server, $result->UserId()), RestResponse::OK_CODE);
        }
        else
        {
            Log::Debug('UsersWriteWebService.UpdatePassword() - User Password Update Failed.');

            $this->server->WriteResponse(new FailedResponse($this->server, $result->Errors()),
                RestResponse::BAD_REQUEST_CODE);
        }
    }
}


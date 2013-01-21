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

require_once(ROOT_DIR . 'lib/WebService/namespace.php');
require_once(ROOT_DIR . 'WebServices/Controllers/ResourceSaveController.php');
require_once(ROOT_DIR . 'WebServices/Requests/CreateResourceRequest.php');
require_once(ROOT_DIR . 'WebServices/Requests/UpdateResourceRequest.php');
require_once(ROOT_DIR . 'WebServices/Responses/ResourceCreatedResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/ResourceUpdatedResponse.php');

class ResourcesWriteWebService
{
	/**
	 * @var IRestServer
	 */
	private $server;

	/**
	 * @var IResourceSaveController
	 */
	private $controller;

	public function __construct(IRestServer $server, IResourceSaveController $controller)
	{
		$this->server = $server;
		$this->controller = $controller;
	}

	/**
	 * @name CreateResource
	 * @description Creates a new resource
	 * @request CreateResourceRequest
	 * @response ResourceCreatedResponse
	 * @return void
	 */
	public function Create()
	{
		/** @var $request CreateResourceRequest */
		$request = $this->server->GetRequest();

		Log::Debug('ResourcesWriteWebService.Create() User=%s, Request=%s', $this->server->GetSession()->UserId,
						   json_encode($request));
		$result = $this->controller->Create($request, $this->server->GetSession());

		if ($result->WasSuccessful())
		{
			Log::Debug('ResourcesWriteWebService.Create() - Resource created with id %s', $result->ResourceId());

			$this->server->WriteResponse(new ResourceCreatedResponse($this->server, $result->ResourceId()),
										 RestResponse::CREATED_CODE);
		}
		else
		{
			Log::Debug('ResourcesWriteWebService.Create() - Resource create failed');

			$this->server->WriteResponse(new FailedResponse($this->server, $result->Errors()),
										 RestResponse::BAD_REQUEST_CODE);
		}
	}
//
//	/**
//	 * @name UpdateUser
//	 * @description Updates an existing user
//	 * @request UpdateUserRequest
//	 * @response UserUpdatedResponse
//	 * @param $userId
//	 * @return void
//	 */
//	public function Update($userId)
//	{
//		/** @var $request UpdateUserRequest */
//		$request = $this->server->GetRequest();
//
//		Log::Debug('ResourcesWriteWebService.Update() User=%s', $this->server->GetSession()->UserId);
//
//		$result = $this->controller->Update($userId, $request, $this->server->GetSession());
//
//		if ($result->WasSuccessful())
//		{
//			Log::Debug('ResourcesWriteWebService.Update() - User Updated. UserId=%s',
//					   $result->UserId());
//
//			$this->server->WriteResponse(new UserUpdatedResponse($this->server, $result->UserId()),
//										 RestResponse::OK_CODE);
//		}
//		else
//		{
//			Log::Debug('ResourcesWriteWebService.Create() - User Update Failed.');
//
//			$this->server->WriteResponse(new FailedResponse($this->server, $result->Errors()),
//										 RestResponse::BAD_REQUEST_CODE);
//		}
//	}
//
//	/**
//	 * @name DeleteUser
//	 * @description Deletes an existing user
//	 * @response DeletedResponse
//	 * @param int $userId
//	 * @return void
//	 */
//	public function Delete($userId)
//	{
//		Log::Debug('ResourcesWriteWebService.Delete() User=%s', $this->server->GetSession()->UserId);
//
//		$result = $this->controller->Delete($userId, $this->server->GetSession());
//
//		if ($result->WasSuccessful())
//		{
//			Log::Debug('ResourcesWriteWebService.Delete() - User Deleted. UserId=%s',
//					   $result->UserId());
//
//			$this->server->WriteResponse(new DeletedResponse(), RestResponse::OK_CODE);
//		}
//		else
//		{
//			Log::Debug('ResourcesWriteWebService.Delete() - User Delete Failed.');
//
//			$this->server->WriteResponse(new FailedResponse($this->server, $result->Errors()),
//										 RestResponse::BAD_REQUEST_CODE);
//		}
//	}
}

?>
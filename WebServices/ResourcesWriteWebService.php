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
require_once(ROOT_DIR . 'WebServices/Controllers/ResourceSaveController.php');
require_once(ROOT_DIR . 'WebServices/Requests/Resource/ResourceRequest.php');
require_once(ROOT_DIR . 'WebServices/Responses/Resource/ResourceCreatedResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/Resource/ResourceUpdatedResponse.php');

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
	 * @request ResourceRequest
	 * @response ResourceCreatedResponse
	 * @return void
	 */
	public function Create()
	{
		/** @var $request ResourceRequest */
		$request = new ResourceRequest($this->server->GetRequest());

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


	/**
	 * @name UpdateResource
	 * @description Updates an existing resource
	 * @request ResourceRequest
	 * @response ResourceUpdatedResponse
	 * @param $resourceId
	 * @return void
	 */
	public function Update($resourceId)
	{
		/** @var $request ResourceRequest */
		$request = new ResourceRequest($this->server->GetRequest());

		Log::Debug('ResourcesWriteWebService.Create() User=%s, Request=%s', $this->server->GetSession()->UserId,
								   json_encode($request));

		$result = $this->controller->Update($resourceId, $request, $this->server->GetSession());

		if ($result->WasSuccessful())
		{
			Log::Debug('ResourcesWriteWebService.Update() - Resource Updated. ResourceId=%s',
					   $result->ResourceId());

			$this->server->WriteResponse(new ResourceUpdatedResponse($this->server, $result->ResourceId()),
										 RestResponse::OK_CODE);
		}
		else
		{
			Log::Debug('ResourcesWriteWebService.Create() - Resource Update Failed.');

			$this->server->WriteResponse(new FailedResponse($this->server, $result->Errors()),
										 RestResponse::BAD_REQUEST_CODE);
		}
	}

	/**
	 * @name DeleteResource
	 * @description Deletes an existing resource
	 * @response DeletedResponse
	 * @param int $resourceId
	 * @return void
	 */
	public function Delete($resourceId)
	{
		Log::Debug('ResourcesWriteWebService.Delete() Resource=%s', $this->server->GetSession()->UserId);

		$result = $this->controller->Delete($resourceId, $this->server->GetSession());

		if ($result->WasSuccessful())
		{
			Log::Debug('ResourcesWriteWebService.Delete() - Resource Deleted. ResourceId=%s',
					   $result->ResourceId());

			$this->server->WriteResponse(new DeletedResponse(), RestResponse::OK_CODE);
		}
		else
		{
			Log::Debug('ResourcesWriteWebService.Delete() - Resource Delete Failed.');

			$this->server->WriteResponse(new FailedResponse($this->server, $result->Errors()),
										 RestResponse::BAD_REQUEST_CODE);
		}
	}
}


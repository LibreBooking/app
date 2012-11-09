<?php
/**
Copyright 2012 Nick Korbel

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
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Attributes/namespace.php');

class ResourcesWebService
{
	/**
	 * @var IRestServer
	 */
	private $server;

	/**
	 * @var IResourceRepository
	 */
	private $resourceRepository;

	/**
	 * @var IAttributeService
	 */
	private $attributeService;

	public function __construct(IRestServer $server, IResourceRepository $resourceRepository,
								IAttributeService $attributeService)
	{
		$this->server = $server;
		$this->resourceRepository = $resourceRepository;
		$this->attributeService = $attributeService;
	}

	/**
	 * @name GetAllResources
	 * @description Loads all resources
	 * @response ResourcesResponse
	 * @return void
	 */
	public function GetAll()
	{
		$resources = $this->resourceRepository->GetResourceList();
		$resourceIds = array();
		foreach ($resources as $resource)
		{
			$resourceIds[] = $resource->GetId();
		}
		$attributes = $this->attributeService->GetAttributes(CustomAttributeCategory::RESOURCE, $resourceIds);
		$this->server->WriteResponse(ResourcesResponse::Create($this->server, $resources, $attributes));
	}

	/**
	 * @name GetResource
	 * @description Loads a specific resource by id
	 * @param int $resourceId
	 * @response ResourceResponse
	 * @return void
	 */
	public function GetResource($resourceId)
	{
		$resource = $this->resourceRepository->LoadById($resourceId);

		$resourceId = $resource->GetResourceId();
		if (empty($resourceId))
		{
			$this->server->WriteResponse(RestResponse::NotFound(), RestResponse::NOT_FOUND_CODE);
		}
		else
		{
			$attributes = $this->attributeService->GetAttributes(CustomAttributeCategory::RESOURCE, array($resourceId));
			$this->server->WriteResponse(ResourceResponse::Create($this->server, $resource, $attributes));
		}

	}
}

class ResourceResponse extends RestResponse
{
	public $resourceId;
	public $name;
	public $location;
	public $contact;
	public $notes;
	public $minLength;
	public $maxLength;
	public $requiresApproval;
	public $allowMultiday;
	public $maxParticipants;
	public $minNotice;
	public $maxNotice;
	public $description;
	public $scheduleId;
	public $customAttributes = array();

	public function __construct()
	{
	}

	/**
	 * @param IRestServer $server
	 * @param BookableResource $resource
	 * @param IEntityAttributeList $attributes
	 * @return ResourceResponse
	 */
	public static function Create($server = null, $resource = null, $attributes = null)
	{
		$resourceId = $resource->GetId();
		$r = new ResourceResponse();
		$r->resourceId = $resourceId;
		$r->name = $resource->GetName();
		$r->location = $resource->GetLocation();
		$r->contact = $resource->GetContact();
		$r->notes = $resource->GetNotes();
		$r->maxLength = $resource->GetMaxLength();
		$r->minLength = $resource->GetMinLength();
		$r->maxNotice = $resource->GetMaxNotice();
		$r->minNotice = $resource->GetMinNotice();
		$r->requiresApproval = $resource->GetRequiresApproval();
		$r->allowMultiday = $resource->GetAllowMultiday();
		$r->maxParticipants = $resource->GetMaxParticipants();
		$r->description = $resource->GetDescription();
		$r->scheduleId = $resource->GetScheduleId();

		$labels = $attributes->GetLabels();
		$values = $attributes->GetValues($resourceId);

		for ($i = 0; $i < count($labels); $i++)
		{
			$r->customAttributes = array('label' => $labels[$i], 'value' => $values[$i]);
		}

		$r->AddService($server, WebServices::GetResource, array('resourceId' => $resourceId));

		return $r;
	}
}

class ResourcesResponse extends RestResponse
{
	/**
	 * @var array|ResourceResponse[]
	 */
	public $resources;

	public function __construct()
	{
	}

	/**
	 * @param IRestServer $server
	 * @param array|BookableResource[] $resources
	 * @param IEntityAttributeList $attributes
	 * @return ResourcesResponse
	 */
	public static function Create($server = null, $resources = null, $attributes = null)
	{
		$r = new ResourcesResponse();
		foreach ($resources as $resource)
		{
			$r->resources[] = ResourceResponse::Create($server, $resource, $attributes);
		}

		return $r;
	}
}

?>
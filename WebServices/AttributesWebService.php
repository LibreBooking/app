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
require_once(ROOT_DIR . 'lib/Application/Attributes/namespace.php');
require_once(ROOT_DIR . 'WebServices/Responses/CustomAttributes/CustomAttributesResponse.php');

class AttributesWebService
{
	/**
	 * @var IRestServer
	 */
	private $server;

	/**
	 * @var IAttributeService
	 */
	private $attributeService;

	public function __construct(IRestServer $server, IAttributeService $attributeService)
	{
		$this->server = $server;
		$this->attributeService = $attributeService;
	}

	/**
	 * @name GetCategoryAttributes
	 * @description Gets all custom attribute definitions for the requested category
	 * Categories are RESERVATION = 1, USER = 2, RESOURCE = 4
	 * @response CustomAttributesResponse
	 * @return void
	 * @param int $categoryId
	 */
	public function GetAttributes($categoryId)
	{
		$attributes = $this->attributeService->GetByCategory($categoryId);

		$this->server->WriteResponse(new CustomAttributesResponse($this->server, $attributes));
	}

	/**
	 * @name GetAttribute
	 * @description Gets all custom attribute definitions for the requested attribute
	 * @response CustomAttributeDefinitionResponse
	 * @return void
	 * @param int $attributeId
	 */
	public function GetAttribute($attributeId)
	{
		$attribute = $this->attributeService->GetById($attributeId);

		if ($attribute != null)
		{
			$this->server->WriteResponse(new CustomAttributeDefinitionResponse($this->server, $attribute));
		}
		else
		{
			$this->server->WriteResponse(RestResponse::NotFound(), RestResponse::NOT_FOUND_CODE);
		}
	}
}


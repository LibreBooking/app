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

require_once(ROOT_DIR . 'lib/Common/Validators/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Attributes/namespace.php');
require_once(ROOT_DIR . 'WebServices/Validators/RequestRequiredValueValidator.php');
require_once(ROOT_DIR . 'WebServices/Validators/TimeIntervalValidator.php');
require_once(ROOT_DIR . 'WebServices/Requests/Resource/ResourceRequest.php');

interface IResourceRequestValidator
{
	/**
	 * @param ResourceRequest $createRequest
	 * @return array|string[]
	 */
	public function ValidateCreateRequest($createRequest);

	/**
	 * @param int $resourceId
	 * @param ResourceRequest $updateRequest
	 * @return array|string[]
	 */
	public function ValidateUpdateRequest($resourceId, $updateRequest);

	/**
	 * @param int $resourceId
	 * @return array|string[]
	 */
	public function ValidateDeleteRequest($resourceId);
}

class ResourceRequestValidator implements IResourceRequestValidator
{
	/**
	 * @var IAttributeService
	 */
	private $attributeService;

	public function __construct(IAttributeService $attributeService)
	{
		$this->attributeService = $attributeService;
	}

	public function ValidateCreateRequest($createRequest)
	{
		return $this->ValidateCommon($createRequest);
	}

	/**
	 * @param ResourceRequest $request
	 * @return array
	 */
	private function ValidateCommon($request)
	{
		if (empty($request))
		{
			return array('Request was not properly formatted');
		}
		$errors = array();

		$validators[] = new RequestRequiredValueValidator($request->name, 'name');
		$validators[] = new RequestRequiredValueValidator($request->scheduleId, 'scheduleId');
		$validators[] = new TimeIntervalValidator($request->minLength, 'minLength');
		$validators[] = new TimeIntervalValidator($request->maxLength, 'maxLength');
		$validators[] = new TimeIntervalValidator($request->minNotice, 'minNotice');
		$validators[] = new TimeIntervalValidator($request->maxNotice, 'maxNotice');

		$attributes = array();
		foreach ($request->GetCustomAttributes() as $attribute)
		{
			$attributes[] = new AttributeValue($attribute->attributeId, $attribute->attributeValue);
		}
		$validators[] = new AttributeValidator($this->attributeService, CustomAttributeCategory::RESOURCE, $attributes);


		/** @var IValidator $validator */
		foreach ($validators as $validator)
		{
			$validator->Validate();
			if (!$validator->IsValid())
			{
				foreach ($validator->Messages() as $message)
				{
					$errors[] = $message;
				}
			}
		}

		return $errors;
	}

	public function ValidateUpdateRequest($resourceId, $updateRequest)
	{
		if (empty($resourceId))
		{
			return array('resourceId is required');
		}

		return $this->ValidateCommon($updateRequest);
	}

	public function ValidateDeleteRequest($resourceId)
	{
		if (empty($resourceId))
		{
			return array('resourceId is required');
		}

	}
}


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

require_once(ROOT_DIR . 'lib/Common/Validators/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Attributes/namespace.php');
require_once(ROOT_DIR . 'WebServices/Validators/RequestRequiredValueValidator.php');
require_once(ROOT_DIR . 'WebServices/Requests/CreateUserRequest.php');

interface IUserRequestValidator
{
	/**
	 * @param CreateUserRequest $createRequest
	 * @return array|string[]
	 */
	public function ValidateCreateRequest($createRequest);
}

class UserRequestValidator implements IUserRequestValidator
{
	/**
	 * @var IAttributeService
	 */
	private $attributeService;

	/**
	 * @var IUserViewRepository
	 */
	private $userRepository;

	public function __construct(IAttributeService $attributeService, IUserViewRepository $userRepository)
	{
		$this->attributeService = $attributeService;
		$this->userRepository = $userRepository;
	}

	/**
	 * @param CreateUserRequest $createRequest
	 * @return array|string[]
	 */
	public function ValidateCreateRequest($createRequest)
	{
		$errors = array();
		if (empty($createRequest))
		{
			return array('Request was not properly formatted');
		}

		$validators[] = new RequestRequiredValueValidator($createRequest->firstName, 'firstName');
		$validators[] = new RequestRequiredValueValidator($createRequest->lastName, 'lastName');
		$validators[] = new RequestRequiredValueValidator($createRequest->userName, 'userName');
		$validators[] = new RequestRequiredValueValidator($createRequest->password, 'password');
		$validators[] = new RequestRequiredValueValidator($createRequest->timezone, 'timezone');
		$validators[] = new RequestRequiredValueValidator($createRequest->language, 'language');
		$validators[] = new EmailValidator($createRequest->emailAddress);
		$validators[] = new UniqueEmailValidator($this->userRepository, $createRequest->emailAddress);
		$validators[] = new UniqueUserNameValidator($this->userRepository, $createRequest->userName);

		$attributes = array();
		foreach ($createRequest->customAttributes as $attribute)
		{
			$attributes[] = new AttributeValue($attribute->attributeId, $attribute->attributeValue);
		}
		$validators[] = new AttributeValidator($this->attributeService, CustomAttributeCategory::USER, $attributes);


		/** @var $validator IValidator */
		foreach($validators as $validator)
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
}

?>
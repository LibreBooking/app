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
require_once(ROOT_DIR . 'WebServices/Requests/User/CreateUserRequest.php');
require_once(ROOT_DIR . 'WebServices/Requests/User/UpdateUserRequest.php');

interface IUserRequestValidator
{
	/**
	 * @param CreateUserRequest $createRequest
	 * @return array|string[]
	 */
	public function ValidateCreateRequest($createRequest);

	/**
	 * @param int $userId
	 * @param UpdateUserRequest $updateRequest
	 * @return array|string[]
	 */
	public function ValidateUpdateRequest($userId, $updateRequest);

    /**
     * @param int $userId
     * @param string $password
     * @return string[]
     */
    public function ValidateUpdatePasswordRequest($userId, $password);
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

	public function ValidateCreateRequest($createRequest)
	{
		if (empty($createRequest))
		{
			return array('Request was not properly formatted');
		}

		$validators[] = new RequestRequiredValueValidator($createRequest->password, 'password');
		$validators[] = new RequestRequiredValueValidator($createRequest->language, 'language');
		$validators[] = new UniqueEmailValidator($this->userRepository, $createRequest->emailAddress);
		$validators[] = new UniqueUserNameValidator($this->userRepository, $createRequest->userName);

		return $this->Validate($createRequest, $validators);
	}

	public function ValidateUpdateRequest($userId, $updateRequest)
	{
		if (empty($updateRequest))
		{
			return array('Request was not properly formatted');
		}

		$validators[] = new UniqueEmailValidator($this->userRepository, $updateRequest->emailAddress, $userId);
		$validators[] = new UniqueUserNameValidator($this->userRepository, $updateRequest->userName, $userId);

		return $this->Validate($updateRequest, $validators);
	}


    public function ValidateUpdatePasswordRequest($userId, $password)
    {
        $validator = new PasswordComplexityValidator($password);
        $validator->Validate();

        if (!$validator->IsValid())
        {
            return $validator->Messages();
        }

        return array();
    }

	/**
	 * @param CreateUserRequest|UpdateUserRequest $request
	 * @param IValidator[] $additionalValidators
	 * @return array|string[]
	 */
	private function Validate($request, $additionalValidators = array())
	{
		$validators = $additionalValidators;
		$validators[] = new RequestRequiredValueValidator($request->firstName, 'firstName');
		$validators[] = new RequestRequiredValueValidator($request->lastName, 'lastName');
		$validators[] = new RequestRequiredValueValidator($request->userName, 'userName');
		$validators[] = new RequestRequiredValueValidator($request->timezone, 'timezone');
		$validators[] = new EmailValidator($request->emailAddress);

		$attributes = array();
		foreach ($request->GetCustomAttributes() as $attribute)
		{
			$attributes[] = new AttributeValue($attribute->attributeId, $attribute->attributeValue);
		}
		$validators[] = new AttributeValidator($this->attributeService, CustomAttributeCategory::USER, $attributes);

		$errors = array();
		/** @var $validator IValidator */
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
}


<?php
/**
Copyright 2013-2015 Nick Korbel

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

require_once(ROOT_DIR . 'WebServices/Requests/CreateUserRequest.php');
require_once(ROOT_DIR . 'WebServices/Requests/UpdateUserRequest.php');
require_once(ROOT_DIR . 'WebServices/Validators/UserRequestValidator.php');
require_once(ROOT_DIR . 'lib/Application/User/namespace.php');

interface IUserSaveController
{
	/**
	 * @param CreateUserRequest $request
	 * @param WebServiceUserSession $session
	 * @return UserControllerResult
	 */
	public function Create($request, $session);

	/**
	 * @param $userId
	 * @param UpdateUserRequest $request
	 * @param WebServiceUserSession $session
	 * @return UserControllerResult
	 */
	public function Update($userId, $request, $session);

	/**
	 * @param $userId
	 * @param WebServiceUserSession $session
	 * @return UserControllerResult
	 */
	public function Delete($userId, $session);
}

class UserSaveController implements IUserSaveController
{
	/**
	 * @var IManageUsersServiceFactory
	 */
	private $serviceFactory;

	/**
	 * @var IUserRequestValidator
	 */
	private $requestValidator;

	public function __construct(IManageUsersServiceFactory $serviceFactory, IUserRequestValidator $requestValidator)
	{
		$this->serviceFactory = $serviceFactory;
		$this->requestValidator = $requestValidator;
	}

	/**
	 * @param CreateUserRequest $request
	 * @param WebServiceUserSession $session
	 * @return UserControllerResult
	 */
	public function Create($request, $session)
	{
		$errors = $this->requestValidator->ValidateCreateRequest($request);

		if (!empty($errors))
		{
			return new UserControllerResult(null, $errors);
		}

		$userService = $this->serviceFactory->CreateAdmin();

		$extraAttributes = array(UserAttribute::Phone => $request->phone, UserAttribute::Organization => $request->organization, UserAttribute::Position => $request->position);
		$customAttributes = array();
		foreach ($request->GetCustomAttributes() as $attribute)
		{
			$customAttributes[] = new AttributeValue($attribute->attributeId, $attribute->attributeValue);
		}

		$user = $userService->AddUser($request->userName, $request->emailAddress, $request->firstName,
										$request->lastName, $request->password, $request->timezone, $request->language,
										Pages::DEFAULT_HOMEPAGE_ID, $extraAttributes, $customAttributes);

		$userService->ChangeGroups($user, $request->groups);

		return new UserControllerResult($user->Id());
	}

	/**
	 * @param int $userId
	 * @param UpdateUserRequest $request
	 * @param WebServiceUserSession $session
	 * @return UserControllerResult
	 */
	public function Update($userId, $request, $session)
	{
		$errors = $this->requestValidator->ValidateUpdateRequest($userId, $request);

		if (!empty($errors))
		{
			return new UserControllerResult(null, $errors);
		}

		$userService = $this->serviceFactory->CreateAdmin();

		$extraAttributes = array(UserAttribute::Phone => $request->phone, UserAttribute::Organization => $request->organization, UserAttribute::Position => $request->position);
		$customAttributes = array();
		foreach ($request->GetCustomAttributes() as $attribute)
		{
			$customAttributes[] = new AttributeValue($attribute->attributeId, $attribute->attributeValue);
		}

		$user = $userService->UpdateUser($userId, $request->userName, $request->emailAddress, $request->firstName,
								 $request->lastName, $request->timezone, $extraAttributes);

		$userService->ChangeAttributes($userId, $customAttributes);

		$userService->ChangeGroups($user, $request->groups);

		return new UserControllerResult($userId);
	}

	/**
	 * @param $userId
	 * @param WebServiceUserSession $session
	 * @return UserControllerResult
	 */
	public function Delete($userId, $session)
	{
		$userService = $this->serviceFactory->CreateAdmin();
		$userService->DeleteUser($userId);

		return new UserControllerResult($userId);
	}
}

class UserControllerResult
{
	/**
	 * @var int
	 */
	private $userId;

	/**
	 * @var array|string[]
	 */
	private $errors = array();

	/**
	 * @param int $userId
	 * @param array $errors
	 */
	public function __construct($userId, $errors = array())
	{
		$this->userId = $userId;
		$this->errors = $errors;
	}

	/**
	 * @return bool
	 */
	public function WasSuccessful()
	{
		return !empty($this->userId) && empty($this->errors);
	}

	/**
	 * @return int
	 */
	public function UserId()
	{
		return $this->userId;
	}

	/**
	 * @return array|string[]
	 */
	public function Errors()
	{
		return $this->errors;
	}
}


?>
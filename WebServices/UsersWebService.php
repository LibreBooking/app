<?php
/**
Copyright 2012-2014 Nick Korbel

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
require_once(ROOT_DIR . 'lib/Application/User/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Attributes/namespace.php');
require_once(ROOT_DIR . 'WebServices/Responses/UsersResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/UserResponse.php');

class UsersWebService
{
	/**
	 * @var IRestServer
	 */
	private $server;

	/**
	 * @var IUserRepositoryFactory
	 */
	private $repositoryFactory;

	/**
	 * @var IAttributeService
	 */
	private $attributeService;

	public function __construct(IRestServer $server, IUserRepositoryFactory $repositoryFactory,
								IAttributeService $attributeService)
	{
		$this->server = $server;
		$this->repositoryFactory = $repositoryFactory;
		$this->attributeService = $attributeService;
	}

	/**
	 * @name GetAllUsers
	 * @description Loads all users that the current user can see
	 * @response UsersResponse
	 * @return void
	 */
	public function GetUsers()
	{
		$repository = $this->repositoryFactory->Create($this->server->GetSession());
		$data = $repository->GetList(null, null);
		$users = $data->Results();

		$userIds = array();
		/** @var $user UserItemView */
		foreach ($users as $user)
		{
			$userIds[] = $user->Id;
		}

		$attributes = $this->attributeService->GetAttributes(CustomAttributeCategory::USER, $userIds);

		$this->server->WriteResponse(new UsersResponse($this->server, $users, $attributes));
	}

	/**
	 * @name GetUser
	 * @description Loads the requested user by Id
	 * @response UserResponse
	 * @param int $userId
	 * @return void
	 */
	public function GetUser($userId)
	{
		$responseCode = RestResponse::OK_CODE;

		$hideUsers = Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY,
															  ConfigKeys::PRIVACY_HIDE_USER_DETAILS,
															  new BooleanConverter());
		$userSession = $this->server->GetSession();

		$repository = $this->repositoryFactory->Create($userSession);
		$user = $repository->LoadById($userId);

		$loadedUserId = $user->Id();
		if (empty($loadedUserId))
		{
			$this->server->WriteResponse(RestResponse::NotFound(), RestResponse::NOT_FOUND_CODE);
			return;
		}

		$attributes = $this->attributeService->GetAttributes(CustomAttributeCategory::USER, array($userId));

		if ($userId == $userSession->UserId || !$hideUsers || $userSession->IsAdmin)
		{
			$response = new UserResponse($this->server, $user, $attributes);
		}
		else
		{
			$me = $repository->LoadById($userSession->UserId);

			if ($me->IsAdminFor($user))
			{
				$response = new UserResponse($this->server, $user, $attributes);
			}
			else
			{
				$response = RestResponse::Unauthorized();
				$responseCode = RestResponse::UNAUTHORIZED_CODE;
			}
		}

		$this->server->WriteResponse($response, $responseCode);
	}
}

?>
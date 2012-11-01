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

require_once(ROOT_DIR . 'Domain/Access/UserSessionRepository.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');

interface IWebServiceAuthentication
{
	/**
	 * @abstract
	 * @param string $username
	 * @param string $password
	 * @return bool If user is valid
	 */
	public function Validate($username, $password);

	/**
	 * @abstract
	 * @param string $username
	 * @return UserSession
	 */
	public function Login($username);

	/**
	 * @param string $sessionToken
	 * @return void
	 */
	public function Logout($sessionToken);
}

class WebServiceAuthentication implements IWebServiceAuthentication
{
	/**
	 * @param IAuthentication $authentication
	 * @param IUserSessionRepository $userSessionRepository
	 */
	public function __construct(IAuthentication $authentication, IUserSessionRepository $userSessionRepository)
	{
		$this->authentication = $authentication;
		$this->userSessionRepository = $userSessionRepository;
	}

	/**
	 * @param string $username
	 * @param string $password
	 * @return bool If user is valid
	 */
	public function Validate($username, $password)
	{
		return $this->authentication->Validate($username, $password);
	}

	/**
	 * @param string $username
	 * @return UserSession
	 */
	public function Login($username)
	{
		Log::Debug('Web Service Login with username: %s', $username);
		$userSession = $this->authentication->Login($username, new WebServiceLoginContext());
		if ($userSession->IsLoggedIn())
		{
			$existingSession = $this->userSessionRepository->LoadByUserId($userSession->UserId);
			if ($existingSession == null)
			{
				$this->userSessionRepository->Add($userSession);
			}
			else
			{
				$this->userSessionRepository->Update($userSession);
			}
		}

		return $userSession;
	}

	/**
	 * @param string $sessionToken
	 * @return void
	 */
	public function Logout($sessionToken)
	{
		Log::Debug('Logout sessionToken: %s', $sessionToken);

		$userSession = $this->userSessionRepository->LoadBySessionToken($sessionToken);
		if ($userSession != null)
		{
			$this->userSessionRepository->Delete($userSession);
			$this->authentication->Logout($userSession);
		}
	}
}

class WebServiceLoginContext implements ILoginContext
{
	/**
	 * @return LoginData
	 */
	public function GetData()
	{
		return new LoginData(false, null);
	}
}

?>
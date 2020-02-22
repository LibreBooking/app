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

require_once(ROOT_DIR . 'Domain/Access/UserSessionRepository.php');

class WebServiceSecurity
{
	/**
	 * @var IUserSessionRepository
	 */
	private $repository;

	public function __construct(IUserSessionRepository $repository)
	{
		$this->repository = $repository;
	}

	public function HandleSecureRequest(IRestServer $server, $requireAdminRole = false)
	{
		$sessionToken = $server->GetHeader(WebServiceHeaders::SESSION_TOKEN);
		$userId = $server->GetHeader(WebServiceHeaders::USER_ID);

		Log::Debug('Handling secure request. url=%s, userId=%s, sessionToken=%s', $_SERVER['REQUEST_URI'], $userId, $sessionToken);

		if (empty($sessionToken) || empty($userId))
		{
			Log::Debug('Empty token or userId');
			return false;
		}

		$session = $this->repository->LoadBySessionToken($sessionToken);

		if ($session != null && $session->IsExpired())
		{
			Log::Debug('Session is expired');
			$this->repository->Delete($session);
			return false;
		}

		if ($session == null || $session->UserId != $userId)
		{
			Log::Debug('Session token does not match user session token');
			return false;
		}

		if ($requireAdminRole && !$session->IsAdmin)
		{
			Log::Debug('Route is limited to application administrators and this user is not an admin');
			return false;
		}

		$session->ExtendSession();
		$this->repository->Update($session);
		$server->SetSession($session);

		Log::Debug('Secure request was authenticated');

		return true;
	}
}

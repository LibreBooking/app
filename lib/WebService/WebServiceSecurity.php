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

	public function HandleSecureRequest(IRestServer $server)
	{
		$sessionToken = $server->GetHeader(WebServiceHeaders::SESSION_TOKEN);
		$publicUserId = $server->GetHeader(WebServiceHeaders::USER_ID);

		if (empty($sessionToken) || empty($publicUserId))
		{
			return false;
		}

		$session = $this->repository->LoadBySessionToken($sessionToken);

		if ($session != null && $session->IsExpired())
		{
			$this->repository->Delete($session);
			return false;
		}

		if ($session == null || $session->PublicId != $publicUserId)
		{
			return false;
		}

		$session->ExtendSession();
		$this->repository->Update($session);
		$server->SetSession($session);

		return true;
	}
}
?>
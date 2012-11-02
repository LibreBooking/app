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
interface IUserSessionRepository
{
	/**
	 * @param int $userId
	 * @return UserSession|null
	 */
	public function LoadByUserId($userId);

	/**
	 * @param string $sessionToken
	 * @return UserSession
	 */
	public function LoadBySessionToken($sessionToken);

	/**
	 * @param UserSession $session
	 * @return void
	 */
	public function Add(UserSession $session);

	/**
	 * @param UserSession $session
	 * @return void
	 */
	public function Update(UserSession $session);

	/**
	 * @param UserSession $session
	 * @return void
	 */
	public function Delete(UserSession $session);
}

class UserSessionRepository implements IUserSessionRepository
{
	/**
	 * @param int $userId
	 * @return UserSession|null
	 */
	public function LoadByUserId($userId)
	{
		$reader = ServiceLocator::GetDatabase()->Query(new GetUserSessionByUserIdCommand($userId));
		if ($row = $reader->GetRow())
		{
			return unserialize($row[ColumnNames::USER_SESSION]);
		}
		return null;
	}

	/**
	 * @param string $sessionToken
	 * @return UserSession
	 */
	public function LoadBySessionToken($sessionToken)
	{
		$reader = ServiceLocator::GetDatabase()->Query(new GetUserSessionBySessionTokenCommand($sessionToken));
		if ($row = $reader->GetRow())
		{
			return unserialize($row[ColumnNames::USER_SESSION]);
		}
		return null;
	}

	/**
	 * @param UserSession $session
	 * @return void
	 */
	public function Add(UserSession $session)
	{
		$serializedSession = serialize($session);
		ServiceLocator::GetDatabase()->Execute(new AddUserSessionCommand($session->UserId, $session->SessionToken, Date::Now(), $serializedSession));
	}

	/**
	 * @param UserSession $session
	 * @return void
	 */
	public function Update(UserSession $session)
	{
		$serializedSession = serialize($session);
		ServiceLocator::GetDatabase()->Execute(new UpdateUserSessionCommand($session->UserId, $session->SessionToken, Date::Now(), $serializedSession));
	}

	/**
	 * @param UserSession $session
	 * @return void
	 */
	public function Delete(UserSession $session)
	{
		ServiceLocator::GetDatabase()->Execute(new DeleteUserSessionCommand($session->SessionToken));
	}
}

?>
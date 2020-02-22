<?php
/**
Copyright 2012-2020 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Domain/Access/UserRepository.php');
require_once(ROOT_DIR . 'Domain/Access/GroupRepository.php');
require_once(ROOT_DIR . 'lib/Application/Admin/GroupAdminUserRepository.php');

interface IUserRepositoryFactory
{
	/**
	 * @param UserSession $session
	 * @return IUserRepository
	 */
	public function Create(UserSession $session);
}

class UserRepositoryFactory implements IUserRepositoryFactory
{
	public function Create(UserSession $session)
	{
		$hideUsers = Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY, ConfigKeys::PRIVACY_HIDE_USER_DETAILS, new BooleanConverter());

		if ($session->IsAdmin || !$hideUsers)
		{
			return new UserRepository();
		}

		return new GroupAdminUserRepository(new GroupRepository(), $session);
	}
}

<?php
/**
Copyright 2012-2015 Nick Korbel

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

class InstallSecurityGuard
{
	const VALIDATED_INSTALL = 'validated_install';

	/**
	 * true if password exists
	 * false if password is missing
	 * @return bool
	 */
	public function CheckForInstallPasswordInConfig()
	{
		$installPassword = Configuration::Instance()->GetKey(ConfigKeys::INSTALLATION_PASSWORD);

		if (empty($installPassword))
		{
			return false;
		}

		return true;
	}

	/**
	 * true if password is correct
	 * false if password is incorrect
	 * @param string $installPassword
	 * @return bool
	 */
	public function ValidatePassword($installPassword)
	{
		$validated = $installPassword == Configuration::Instance()->GetKey(ConfigKeys::INSTALLATION_PASSWORD);

		if ($validated)
		{
			ServiceLocator::GetServer()->SetSession(SessionKeys::INSTALLATION, self::VALIDATED_INSTALL);
		} else
		{
			ServiceLocator::GetServer()->SetSession(SessionKeys::INSTALLATION, null);
		}

		return $validated;
	}


	public function IsAuthenticated()
	{
		return ServiceLocator::GetServer()->GetSession(SessionKeys::INSTALLATION) == self::VALIDATED_INSTALL;
	}
}

?>
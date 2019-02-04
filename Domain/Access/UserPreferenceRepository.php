<?php
/**
Copyright 2013-2019 Nick Korbel, Paul Menchini

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

require_once(ROOT_DIR . 'Domain/User.php');

interface IUserPreferenceRepository
{
	/**
	 * @abstract
	 * @param $userId int
	 * @return array|string[] values, indexed by name
	 */
	public function GetAllUserPreferences($userId);

	/**
	 * @abstract
	 * @param $userId int
	 * @param $preferenceName string
	 * @return string|null
	 */
	public function GetUserPreference($userId, $preferenceName);

	/**
	 * @abstract
	 * @param $userId int
	 * @param $preferenceName string
	 * @param $preferenceValue string
	 * @return void
	 */
	public function SetUserPreference($userId, $preferenceName, $preferenceValue);
}

class UserPreferenceRepository implements IUserPreferenceRepository
{
	/**
	 * @param $userId int
	 * @return array|string[] values, indexed by name
	 */
	public function GetAllUserPreferences($userId)
	{
		$reader = ServiceLocator::GetDatabase()->Query(new GetUserPreferencesCommand($userId));

		$rv = array();
		while ($row = $reader->GetRow())
		{
			$rv[$row[ColumnNames::PREFERENCE_NAME]] = $row[ColumnNames::PREFERENCE_VALUE];
		}

		$reader->Free();
		return $rv;
	}

	/**
	 * @param $userId int
	 * @param $preferenceName string
	 * @return string|null
	 */
	public function GetUserPreference($userId, $preferenceName)
	{
		$reader = ServiceLocator::GetDatabase()->Query(new GetUserPreferenceCommand($userId, $preferenceName));

		if ($row = $reader->GetRow())
		{
			$reader->Free();
			return $row[ColumnNames::PREFERENCE_VALUE];
		}

		$reader->Free();
		return null;
	}

	/**
	 * @param $userId int
	 * @param $preferenceName string
	 * @param $preferenceValue string
	 * @return void
	 */
	public function SetUserPreference($userId, $preferenceName, $preferenceValue)
	{
		$db = ServiceLocator::GetDatabase();

		$existingValue = self::GetUserPreference($userId, $preferenceName);
		if (is_null($existingValue))
		{
			$db->ExecuteInsert(new AddUserPreferenceCommand($userId, $preferenceName, $preferenceValue));
		}
		else if ($existingValue != $preferenceValue)
		{
			$db->Execute(new UpdateUserPreferenceCommand($userId, $preferenceName, $preferenceValue));
		}
	}
}
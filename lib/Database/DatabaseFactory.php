<?php
/**
Copyright 2011-2015 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Config/namespace.php');

class DatabaseFactory
{
	private static $_instance = null;

	public static function GetDatabase()
	{
		if (is_null(self::$_instance))
		{
			$databaseType = Configuration::Instance()->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_TYPE);
			$dbUser = Configuration::Instance()->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_USER);
			$dbPassword = Configuration::Instance()->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_PASSWORD);
			$hostSpec = Configuration::Instance()->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_HOSTSPEC);
			$dbName = Configuration::Instance()->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_NAME);

			if (strtolower($databaseType) == 'mysql')
			{
				require_once(ROOT_DIR . 'lib/Database/MySQL/namespace.php');
				self::$_instance = new Database(new MySqlConnection($dbUser, $dbPassword, $hostSpec, $dbName));
			}
			else
			{
				require_once(ROOT_DIR . 'lib/Database/MDB2/namespace.php');
				self::$_instance = new Database(new Mdb2Connection($databaseType, $dbUser, $dbPassword, $hostSpec, $dbName));
			}

		}

		return self::$_instance;
	}
}

?>
<?php
require_once(ROOT_DIR . 'lib/Database/MySQL/namespace.php');
require_once(ROOT_DIR . 'lib/Config/namespace.php');

class DatabaseFactory
{
	private static $_instance = null;
	
	public static function GetDatabase()
	{
		if (is_null(self::$_instance))
		{						
			self::$_instance = new Database(new MySqlConnection(
											Configuration::Instance()->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_USER),
											Configuration::Instance()->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_PASSWORD),
											Configuration::Instance()->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_HOSTSPEC),
											Configuration::Instance()->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_NAME)
											)
										);
		}
		
		return self::$_instance;
	}
}

?>
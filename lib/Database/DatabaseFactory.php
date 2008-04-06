<?php
require_once(ROOT_DIR . 'lib/Database/MDB2/namespace.php');
require_once(ROOT_DIR . 'lib/Config/namespace.php');

class DatabaseFactory
{
	private static $_instance = null;
	
	public static function GetDatabase()
	{
		if (is_null(self::$_instance))
		{						
			self::$_instance = new Database(new Mdb2Connection(
											Configuration::Instance()->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_TYPE),
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
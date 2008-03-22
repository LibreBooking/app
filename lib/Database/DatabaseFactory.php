<?php
//$dir = dirname(__FILE__) . '/../';
//require_once('namespace.php');
require_once($root . 'lib/Database/MDB2/namespace.php');
require_once($root . 'lib/Config/namespace.php');

class DatabaseFactory
{
	private static $_instance = null;
	
	public static function GetDatabase()
	{
		if (is_null(self::$_instance))
		{
			self::$_instance = new Database(new Mdb2Connection(
											Configuration::GetKey(ConfigKeys::DATABASE_TYPE),
											Configuration::GetKey(ConfigKeys::DATABASE_USER),
											Configuration::GetKey(ConfigKeys::DATABASE_PASSWORD),
											Configuration::GetKey(ConfigKeys::DATABASE_HOSTSPEC),
											Configuration::GetKey(ConfigKeys::DATABASE_NAME)
											)
										);
		}
		
		return self::$_instance;
	}
}

?>
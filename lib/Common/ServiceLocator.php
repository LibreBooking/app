<?php
require_once(ROOT_DIR . 'lib/Database/namespace.php');
require_once(ROOT_DIR . 'lib/Server/namespace.php');

class ServiceLocator
{
	private static $_database = null;
	private static $_server = null;
	
	public static function GetDatabase()
	{
		if (self::$_database == null)
		{
			self::$_database = DatabaseFactory::GetDatabase();
		}
		return self::$_database;
	}
	
	public static function SetDatabase(Database $database)
	{
		self::$_database = $database;
	}
	
	public static function GetServer()
	{
		if (self::$_server == null)
		{
			self::$_server = new Server();
		}
		return self::$_server;
	}
	
	public static function SetServer(Server $server)
	{
		self::$_server = $server;
	}
}
?>
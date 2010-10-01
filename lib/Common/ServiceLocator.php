<?php
require_once(ROOT_DIR . 'lib/Database/namespace.php');
require_once(ROOT_DIR . 'lib/Server/namespace.php');
require_once(ROOT_DIR . 'lib/Email/namespace.php');

class ServiceLocator
{
	/**
	 * @var Database
	 */
	private static $_database = null;
	
	/**
	 * @var Server
	 */
	private static $_server = null;
	
	/**
	 * @var IEmailService
	 */
	private static $_emailSerivce = null;
	
	/**
	 * @return Database
	 */
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
	
	/**
	 * @return Server
	 */
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
	
	public static function GetEmailService()
	{
		if (self::$_emailSerivce == null)
		{
			self::$_emailSerivce = new EmailService();
		}
		return self::$_emailSerivce;
	}
	
	public static function SetEmailService(IEmailService $emailService)
	{
		self::$_emailSerivce = $emailService;	
	}
}
?>
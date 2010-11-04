<?php
define('LOG4PHP_ROOT', ROOT_DIR . 'lib/external/log4php/Logger.php');
require_once(LOG4PHP_ROOT);

class Log
{
	/**
	 * @var Log
	 */
	private static $_instance;
	
	/**
	 * @var Logger
	 */
	private $logger;
	
	private function __construct()
	{
		Logger::configure(ROOT_DIR . 'config/log4php.config.properties');
		$this->logger = Logger::getRootLogger();
	}
	
	/**
	 * @return Log
	 */
	private static function &GetInstance()
	{			
		if (is_null(self::$_instance))
		{
			self::$_instance = new Log();
		}
		
		return self::$_instance;
	}
	
	/**
	 * @param string $message
	 * @param mixed $args
	 */
	public static function Debug($message, $args = array())
	{
		$args = func_get_args();
		$log = vsprintf(array_shift($args), array_values($args));
		self::GetInstance()->logger->debug($log);
	}
}
?>
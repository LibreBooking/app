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
	
	/**
	 * @var Logger
	 */
	private $sqlLogger;

	private function __construct()
	{
		if (file_exists(ROOT_DIR . 'config/log4php.config.xml')) {
			Logger::configure(ROOT_DIR . 'config/log4php.config.xml');
			$this->logger = Logger::getLogger('default');
			$this->sqlLogger = Logger::getLogger('sql');
		}
	}

	/**
	 * @return Log
	 */
	private static function &GetInstance()
	{
		if (is_null(self::$_instance)) {
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
		try
		{
			$args = func_get_args();
			$log = vsprintf(array_shift($args), array_values($args));
			self::GetInstance()->logger->debug($log);
		}
		catch (Exception $ex)
		{
		}
	}

	/**
	 * @param string $message
	 * @param mixed $args
	 */
	public static function Error($message, $args = array())
	{
		try
		{
			$args = func_get_args();
			$log = vsprintf(array_shift($args), array_values($args));
			self::GetInstance()->logger->error($log);
		}
		catch (Exception $ex)
		{
		}
	}

	/**
	 * @static
	 * @param string $message
	 * @param mixed $args
	 * @return void
	 */
	public static function Sql($message, $args = array())
	{
		try
		{
			$args = func_get_args();
			$log = vsprintf(array_shift($args), array_values($args));
			self::GetInstance()->sqlLogger->debug($log);
		}
		catch (Exception $ex)
		{
		}
	}
}

?>
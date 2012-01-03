<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

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
        $this->logger = new NullLog4php();
        $this->sqlLogger = new NullLog4php();

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

class NullLog4php
{
    public function error($log)
    {

    }
    public function debug($log)
    {

    }
}

?>
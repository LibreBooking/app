<?php
/**
Copyright 2012-2020 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

abstract class ExceptionHandler
{
	/**
	 * @var ExceptionHandler $handler
	 */
	private static $handler;

	public static function SetExceptionHandler(ExceptionHandler $handler)
	{
		self::$handler = $handler;
	}

	public abstract function HandleException($exception);

	public static function Handle($exception)
	{
		Log::Error('Uncaught exception: %s', $exception);

		if (isset(self::$handler))
		{
			self::$handler->HandleException($exception);
		}
	}
}

class WebExceptionHandler extends ExceptionHandler
{
	/**
	 * @var callback
	 */
	private $callback;

	public function __construct($callback)
	{
		$this->callback = $callback;
	}

	public function HandleException($exception)
	{
		call_user_func($this->callback);
	}
}

set_exception_handler(array('ExceptionHandler', 'Handle'));

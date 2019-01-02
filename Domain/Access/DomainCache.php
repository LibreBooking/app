<?php
/**
Copyright 2011-2019 Nick Korbel

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

class DomainCache
{
	private $_cache;

	public function __construct()
	{
		$this->_cache = array();
	}

	/**
	 * @param mixed $key
	 * @return bool
	 */
	public function Exists($key)
	{
		return array_key_exists($key, $this->_cache);
	}

	/**
	 * @param mixed $key
	 * @return mixed
	 */
	public function Get($key)
	{
		return $this->_cache[$key];
	}

	/**
	 * @param mixed $key
	 * @param mixed $object
	 */
	public function Add($key, $object)
	{
		$this->_cache[$key] = $object;
	}

	/**
	 * @param mixed $key
	 */
	public function Remove($key)
	{
		unset($this->_cache[$key]);
	}
}
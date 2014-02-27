<?php
/**
Copyright 2011-2014 Nick Korbel

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
	private static $_cache = array();

	public static function Clear()
	{
		self::$_cache = array();
	}

	/**
	 * @param mixed $key
	 * @param string $prefix
	 * @return bool
	 */
	public static function Exists($key, $prefix)
	{
		return array_key_exists($prefix . '_' . $key, self::$_cache);
	}

	/**
	 * @param mixed $key
	 * @param string $prefix
	 * @return mixed
	 */
	public static function Get($key, $prefix)
	{
		return self::$_cache[$prefix . '_' . $key];
	}

	/**
	 * @param mixed $key
	 * @param mixed $object
	 * @param string $prefix
	 */
	public static function Add($key, $object, $prefix)
	{
		self::$_cache[$prefix . '_' . $key] = $object;
	}

	/**
	 * @param mixed $key
	 * @param $prefix
	 */
	public static function Remove($key, $prefix)
	{
		unset(self::$_cache[$prefix . '_' . $key]);
	}

	/**
	 * @param mixed $key
	 * @return bool
	 */
	public static function UserExists($key)
	{
		return self::Exists($key, 'user');
	}

	/**
	 * @param mixed $key
	 * @return mixed
	 */
	public static function GetUser($key)
	{
		return self::Get($key, 'user');
	}

	/**
	 * @param mixed $key
	 * @param mixed $object
	 */
	public static function AddUser($key, $object)
	{
		self::Add($key, $object, 'user');
	}

	/**
	 * @param mixed $key
	 */
	public static function RemoveUser($key)
	{
		self::Remove($key, 'user');
	}

	/**
	 * @param mixed $key
	 * @return bool
	 */
	public static function GroupExists($key)
	{
		return self::Exists($key, 'group');
	}

	/**
	 * @param mixed $key
	 * @return mixed
	 */
	public static function GetGroup($key)
	{
		return self::Get($key, 'group');
	}

	/**
	 * @param mixed $key
	 * @param mixed $object
	 */
	public static function AddGroup($key, $object)
	{
		self::Add($key, $object, 'group');
	}

	/**
	 * @param mixed $key
	 */
	public static function RemoveGroup($key)
	{
		self::Remove($key, 'group');
	}

	/**
	 * @param mixed $key
	 * @return bool
	 */
	public static function ResourceExists($key)
	{
		return self::Exists($key, 'resource');
	}

	/**
	 * @param mixed $key
	 * @return mixed
	 */
	public static function GetResource($key)
	{
		return self::Get($key, 'resource');
	}

	/**
	 * @param mixed $key
	 * @param mixed $object
	 */
	public static function AddResource($key, $object)
	{
		self::Add($key, $object, 'resource');
	}

	/**
	 * @param mixed $key
	 */
	public static function RemoveResource($key)
	{
		self::Remove($key, 'resource');
	}
}
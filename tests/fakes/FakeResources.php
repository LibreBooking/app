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

class FakeResources extends Resources
{
	private $_dateFormats = array(ResourceKeys::DATE_GENERAL => 'm/d/y', ResourceKeys::DATETIME_GENERAL => 'm/d/y h:i:s', ResourceKeys::DATETIME_SYSTEM => 'Y-m-d H:i:s');

    public $_SetCurrentLanguageResult = true;

	public function __construct()
	{

	}

	public function GetString($key, $args = array())
	{
		if (!is_array($args))
		{
			$args = array($args);
		}

		$argstring = implode(',', $args);

		return $key . $argstring;
	}

	public function GetDateFormat($key)
	{
		if (array_key_exists($key, $this->_dateFormats))
		{
			return $this->_dateFormats[$key];
		}
		return $key;
	}

	public function GetDays($key)
	{
		return $key;
	}

	public function GetMonths($key)
	{
		return $key;
	}

	public function SetDateFormat($key, $value)
	{
		$this->_dateFormats[$key] = $value;
	}

    public function SetLanguage($languageCode)
    {
        return $this->_SetCurrentLanguageResult;
    }
}
?>
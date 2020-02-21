<?php
/**
 * Copyright 2011-2020 Nick Korbel
 *
 * This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/Common/Date.php');
require_once(ROOT_DIR . 'lib/Common/Helpers/String.php');

class Cookie
{
	public $Name;
	public $Value;
	public $Expiration;
	public $Path;

	public function __construct($name, $value, $expiration = null, $path = null)
	{
		if (is_null($expiration))
		{
			$expiration = Date::Now()->AddDays(30)->TimeStamp();
		}

		if (is_null($path))
		{
			$path = Configuration::Instance()->GetScriptUrl();
		}

		if (BookedStringHelper::StartsWith($path,'http'))
		{
			$parts = parse_url($path);
			$path = isset($parts['path']) ? $parts['path'] : '';
		}

		$this->Name = $name;
		$this->Value = $value;
		$this->Expiration = $expiration;    // date(DATE_COOKIE, $expiration);
		$this->Path = $path;
	}

	public function Delete()
	{
		$this->Expiration = date(DATE_COOKIE, Date::Now()->AddDays(-30)->Timestamp());
	}

	public function __toString()
	{
		return sprintf('%s %s %s %s', $this->Name, $this->Value, $this->Expiration, $this->Path);
	}
}
<?php
/**
Copyright 2012-2020 Nick Korbel

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

class WebServiceExpiration
{
	private static $SESSION_LENGTH_IN_MINUTES = 30;

    public function __construct()
    {
        self::$SESSION_LENGTH_IN_MINUTES = Configuration::Instance()->GetKey(ConfigKeys::INACTIVITY_TIMEOUT, new IntConverter());
    }
    
	/**
	 * @param string $expirationTime
	 * @return bool
	 */
	public static function IsExpired($expirationTime)
	{
		return Date::Parse($expirationTime, 'UTC')->LessThan(Date::Now());
	}

	/**
	 * @return string
	 */
	public static function Create()
	{
		return Date::Now()->AddMinutes(self::$SESSION_LENGTH_IN_MINUTES)->ToUtc()->ToIso();
	}
}
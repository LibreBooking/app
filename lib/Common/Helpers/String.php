<?php
/**
Copyright 2011-2020 Nick Korbel

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

require_once(ROOT_DIR . 'lib/external/random/random.php');

class BookedStringHelper
{
	/**
	 * @static
	 * @param $haystack string
	 * @param $needle string
	 * @return bool
	 */
	public static function StartsWith($haystack, $needle)
	{
		$length = strlen($needle);
		return (substr($haystack, 0, $length) === $needle);
	}

	/**
	 * @static
	 * @param $haystack string
	 * @param $needle string
	 * @return bool
	 */
	public static function EndsWith($haystack, $needle)
	{
		$length = strlen($needle);
	    if ($length == 0) {
	        return true;
	    }

	    $start  = $length * -1;
	    return (substr($haystack, $start) === $needle);
	}

	/**
	 * @static
	 * @param $haystack string
	 * @param $needle string
	 * @return bool
	 */
	public static function Contains($haystack, $needle)
	{
		return strpos($haystack, $needle) !== false;
	}

    /**
     * @return string
     */
	public static function Random($length = 50)
    {
        try {
            $string = random_bytes(intval($length/2));
            $string = bin2hex($string);
        } catch (Exception $e) {
            $string = uniqid(rand(), true);
            Log::Error('Could not generate web service session token. %s', $e);
        }
        return $string;
    }
}
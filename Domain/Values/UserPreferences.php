<?php
/**
 Copyright 2013-2020 Nick Korbel

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

class UserPreferences
{
	const RESERVATION_COLOR = 'ReservationColor';
	const REPORT_COLUMNS = 'ReportColumns';
    const CALENDAR_FILTER = 'CalendarFilter';

    private $preferences = array();
	private $changed = array();
	private $added = array();

	/**
	 * @param string $allPreferences
	 * @return UserPreferences
	 */
	public static function Parse($allPreferences)
	{
		$preferences = new UserPreferences();

		if (empty($allPreferences))
		{
			return $preferences;
		}

		$pairs = explode('!sep!', $allPreferences);

		if (empty($pairs))
		{
			return $preferences;
		}

		foreach ($pairs as $pair)
		{
			$nv = explode('=', $pair);
			if (count($nv) != 2)
			{
				continue;
			}
			$preferences->Add($nv[0], $nv[1]);
		}

		return $preferences;
	}

	/**
	 * @param $name string
	 * @param $value string
	 */
	public function Add($name, $value)
	{
		$this->preferences[$name] = $value;
	}

	/**
	 * @param $name string
	 * @return null|string
	 */
	public function Get($name)
	{
	    if ($name == UserPreferences::RESERVATION_COLOR &&
            Configuration::Instance()->GetSectionKey(ConfigSection::SCHEDULE, ConfigKeys::SCHEDULE_PER_USER_COLORS, new BooleanConverter()) == false)
        {
            return null;
        }

		if (array_key_exists($name, $this->preferences))
		{
           return $this->preferences[$name];
		}

		return null;
	}

	/**
	 * @param $name string
	 * @param $value string
	 */
	public function Update($name, $value)
	{
		$currentValue = null;

		if (array_key_exists($name, $this->preferences))
		{
			$currentValue = $this->preferences[$name];
			if ($value != $currentValue)
			{
                Log::Debug('changed ' . $name);

                $this->changed[] = $name;
			}
		}
		else
		{
		    Log::Debug('added ' . $name);
			$this->added[] = $name;
		}

		$this->preferences[$name] = $value;
	}

	/**
	 * @return array|string[]
	 */
	public function All()
	{
		return $this->preferences;
	}

	/**
	 * @return array|string[]
	 */
	public function ChangedPreferences()
	{
		return $this->changed;
	}

	/**
	 * @return array|string[]
	 */
	public function AddedPreferences()
	{
		return $this->added;
	}
}
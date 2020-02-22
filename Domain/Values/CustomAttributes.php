<?php

/**
 * Copyright 2013-2020 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */
class CustomAttributes
{
	private $attributes = array();

	/**
	 * @param string $attributes
	 * @return CustomAttributes
	 */
	public static function Parse($attributes)
	{
		$ca = new CustomAttributes();

		if (empty($attributes))
		{
			return $ca;
		}

		$pairs = explode('!sep!', $attributes);

		foreach ($pairs as $pair)
		{
			$nv = explode('=', $pair);
			$ca->Add($nv[0], $nv[1]);
		}

		return $ca;
	}

	/**
	 * @param $id int
	 * @param $value string
	 */
	public function Add($id, $value)
	{
		$this->attributes[$id] = $value;
	}

	/**
	 * @param $id int
	 * @return null|string
	 */
	public function Get($id)
	{
		if (array_key_exists($id, $this->attributes))
		{
			return $this->attributes[$id];
		}

		return null;
	}

	/**
	 * @return array|string[]
	 */
	public function All()
	{
		return $this->attributes;
	}

	/**
	 * @param int $id
	 * @return bool
	 */
	public function Contains($id)
	{
		return array_key_exists($id, $this->attributes);
	}
}
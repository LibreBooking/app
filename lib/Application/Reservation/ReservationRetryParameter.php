<?php

/**
 * Copyright 2017-2019 Nick Korbel
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

class ReservationRetryParameter
{
	private $name;
	private $value;

	/**
	 * ReservationRetryParameter constructor.
	 * @param string $name
	 * @param string $value
	 */
	public function __construct($name, $value)
	{
		$this->name = $name;
		$this->value = $value;
	}

	/**
	 * @static
	 * @param $params string|string[]|null The result of $this->GetForm(FormKeys::RESERVATION_RETRY_PREFIX)
	 * @return array|AttributeFormElement[]
	 */
	public static function GetParamsFromForm($params)
	{
		if (is_array($params))
		{
			$af = array();

			foreach ($params as $name => $value)
			{
				$af[] = new ReservationRetryParameter($name, $value);
			}

			return $af;
		}

		return array();
	}

	/**
	 * @param string $parameterName
	 * @param ReservationRetryParameter[] $retryParameters
	 * @param null|IConvert $converter
	 * @return null|string
	 */
	public static function GetValue($parameterName, $retryParameters, $converter = null)
	{
		if (!is_array($retryParameters))
		{
			return null;
		}

		if ($converter == null)
		{
			$converter = new LowerCaseConverter();
		}

		/** @var ReservationRetryParameter $retryParameter */
		foreach ($retryParameters as $retryParameter)
		{
			if ($retryParameter->Name() == $parameterName)
			{
				return $converter->Convert($retryParameter->Value());
			}
		}

		return null;
	}

	/**
	 * @return string
	 */
	public function Name()
	{
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function Value()
	{
		return $this->value;
	}
}
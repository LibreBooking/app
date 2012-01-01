<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

class TimeInterval
{
	/**
	 * @var DateDiff
	 */
	private $interval = null;
	
	/**
	 * @param int $seconds
	 */
	public function __construct($seconds)
	{
		$this->interval = null;
		
		if (!empty($seconds))
		{
			$this->interval = new DateDiff($seconds);
		}
	}

	/**
	 * @static
	 * @param string|int $interval string interval in format: #d#h#m ie: 22d4h12m or total seconds
	 * @return DateDiff
	 */
	public static function Parse($interval)
	{
		if (empty($interval))
		{
			return new TimeInterval(0);
		}

		if (!is_numeric($interval))
		{
			$seconds = DateDiff::FromTimeString($interval)->TotalSeconds();
		}
		else
		{
			$seconds = $interval;
		}

		return new TimeInterval($seconds);
	}

	/**
	 * @return int
	 */
	public function Days()
	{
		return $this->Interval()->Days();
	}

	/**
	 * @return int
	 */
	public function Hours()
	{
		return $this->Interval()->Hours();
	}

	/**
	 * @return int
	 */
	public function Minutes()
	{
		return $this->Interval()->Minutes();
	}
	
	/**
	 * @return DateDiff
	 */
	public function Interval()
	{
		if ($this->interval != null)
		{
			return $this->interval;
		}

		return DateDiff::Null();
	}

	/**
	 * @return null|int
	 */
	public function ToDatabase()
	{
		if ($this->interval != null && !$this->interval->IsNull())
		{
			return $this->interval->TotalSeconds();
		}

		return null;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		if ($this->interval != null)
		{
			return $this->interval->__toString();
		}
		
		return '';
	}
}
?>
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

class PeriodTypes
{
	const RESERVABLE = 1;
	const NONRESERVABLE = 2;
}

class SchedulePeriod
{
	/**
	 * @var Date
	 */
	protected $_begin;

	/**
	 * @var Date
	 */
	protected $_end;

	protected $_label;

	protected $_id;

	public function __construct(Date $begin, Date $end, $label = null)
	{
		$this->_begin = $begin;
		$this->_end = $end;
		$this->_label = $label;
	}

	/**
	 * @return Time beginning time for this period
	 */
	public function Begin()
	{
		return $this->_begin->GetTime();
	}

	/**
	 * @return Time ending time for this period
	 */
	public function End()
	{
		return $this->_end->GetTime();
	}

	/**
	 * @return Date
	 */
	public function BeginDate()
	{
		return $this->_begin;
	}

	/**
	 * @return Date
	 */
	public function EndDate()
	{
		return $this->_end;
	}

	/**
	 * @param Date $dateOverride
	 * @return string
	 */
	public function Label($dateOverride = null)
	{
		if (empty($this->_label))
		{
			$format = Resources::GetInstance()->GetDateFormat('period_time');

			if (isset($dateOverride) && !$this->_begin->DateEquals($dateOverride))
			{
				return $dateOverride->Format($format);
			}
			return $this->_begin->Format($format);
		}
		return $this->_label;
	}

	/**
	 * @return string
	 */
	public function LabelEnd()
	{
		if (empty($this->_label))
		{
			$format = Resources::GetInstance()->GetDateFormat('period_time');

			return $this->_end->Format($format);
		}
		return '(' . $this->_label . ')';
	}

	/**
	 * @return bool
	 */
	public function IsReservable()
	{
		return true;
	}

	public function IsLabelled()
	{
		return !empty($this->_label);
	}

	public function ToUtc()
	{
		return new SchedulePeriod($this->_begin->ToUtc(), $this->_end->ToUtc(), $this->_label);
	}

	public function ToTimezone($timezone)
	{
		return new SchedulePeriod($this->_begin->ToTimezone($timezone), $this->_end->ToTimezone($timezone), $this->_label);
	}

	public function __toString()
	{
		return sprintf("Begin: %s End: %s Label: %s", $this->_begin, $this->_end, $this->Label());
	}

	/**
	 * Compares the starting datetimes
	 */
	public function Compare(SchedulePeriod $other)
	{
		return $this->_begin->Compare($other->_begin);
	}

	public function BeginsBefore(Date $date)
	{
		return $this->_begin->DateCompare($date) < 0;
	}

	/**
	 * @return string
	 */
	public function Id()
	{
		if (empty($this->_id))
		{
			$this->_id = uniqid($this->_begin->Timestamp());
		}
		return $this->_id;
	}

	public function Span()
	{
		return 1;
	}
}

class NonSchedulePeriod extends SchedulePeriod
{
	public function IsReservable()
	{
		return false;
	}

	public function ToUtc()
	{
		return new NonSchedulePeriod($this->_begin->ToUtc(), $this->_end->ToUtc(), $this->_label);
	}

	public function ToTimezone($timezone)
	{
		return new NonSchedulePeriod($this->_begin->ToTimezone($timezone), $this->_end->ToTimezone($timezone), $this->_label);
	}
}
<?php
/**
Copyright 2012-2020 Nick Korbel

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

class Report_Range
{
	const DATE_RANGE = 'DATE_RANGE';
	const ALL_TIME = 'ALL_TIME';
	const CURRENT_MONTH = 'CURRENT_MONTH';
	const CURRENT_WEEK = 'CURRENT_WEEK';
	const TODAY = 'TODAY';

	/**
	 * @var Report_Range|string
	 */
	private $range;

	/**
	 * @var Date
	 */
	private $start;

	/**
	 * @var Date
	 */
	private $end;

	/**
	 * @param $range string|Report_Range
	 * @param $startString
	 * @param $endString
	 * @param string $timezone
	 */
	public function __construct($range, $startString, $endString, $timezone = 'UTC')
	{
		$this->range = $range;
		$this->start = empty($startString) ? Date::Min() : Date::Parse($startString, $timezone);
		$this->end = empty($endString) ? Date::Max() : Date::Parse($endString, $timezone);
        $userTimezone = ServiceLocator::GetServer()->GetUserSession()->Timezone;

		$now = Date::Now()->ToTimezone($userTimezone);
		if ($this->range == self::CURRENT_MONTH)
		{
            $this->start = Date::Create($now->Year(), $now->Month(), 1, 0, 0, 0, $userTimezone);
			$this->end = $this->start->AddMonths(1)->AddDays(-1);
		}
		if ($this->range == self::CURRENT_WEEK)
		{
			$this->start = $now->GetDate()->AddDays(-$now->Weekday());
			$this->end = $this->Start()->AddDays(6);
		}
		if ($this->range == self::TODAY)
		{
			$this->start = Date::Create($now->Year(), $now->Month(), $now->Day(), 0, 0, 0, $userTimezone);
			$this->end = $this->start;
		}
	}

	public function Add(ReportCommandBuilder $builder)
	{
		if ($this->range != self::ALL_TIME)
		{
			$builder->Within($this->start, $this->end);
		}
	}

	/**
	 * @return Date
	 */
	public function Start()
	{
		return $this->start;
	}

	/**
	 * @return Date
	 */
	public function End()
	{
		return $this->end;
	}

	public function __toString()
	{
		return $this->range;
	}

	/**
	 * @static
	 * @return Report_Range
	 */
	public static function AllTime()
	{
		return new Report_Range(Report_Range::ALL_TIME, Date::Min(), Date::Max());
	}

    /**
     * @return Date[]
     */
    public function Dates()
    {
        $range = new DateRange($this->Start(), $this->End()->AddDays(1));
        return $range->Dates();
    }

    /**
     * @param string $range
     * @return bool
     */
    public function Equals($range)
    {
        return $range == $this->range;
    }
}

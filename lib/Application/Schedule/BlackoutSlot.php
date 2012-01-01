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


class BlackoutSlot implements IReservationSlot
{
	/**
	 * @var Date
	 */
	protected $begin;

	/**
	 * @var Date
	 */
	protected $end;

	/**
	 * @var Date
	 */
	protected $displayDate;

	/**
	 * @var int
	 */
	protected $periodSpan;

	/**
	 * @var BlackoutItemView
	 */
	private $blackout;

	/**
	 * @param Date $begin
	 * @param Date $end
	 * @param Date $displayDate
	 * @param int $periodSpan
	 * @param BlackoutItemView $blackout
	 */
	public function __construct(Date $begin, Date $end, Date $displayDate, $periodSpan, BlackoutItemView $blackout)
	{
		//echo $blackout->Date->__toString();
		$this->blackout = $blackout;
		$this->begin = $begin;
		$this->displayDate = $displayDate;
		$this->end = $end;
		$this->periodSpan = $periodSpan;
	}
	
	/**
	 * @return Time
	 */
	public function Begin()
	{
		return $this->begin->GetTime();
	}

	/**
	 * @return Date
	 */
	public function BeginDate()
	{
		return $this->begin;
	}

	/**
	 * @return Time
	 */
	public function End()
	{
		return $this->end->GetTime();
	}

	/**
	 * @return Date
	 */
	public function EndDate()
	{
		return $this->end;
	}

	/**
	 * @return Date
	 */
	public function Date()
	{
		return $this->displayDate;
	}

	/**
	 * @return int
	 */
	public function PeriodSpan()
	{
		return $this->periodSpan;
	}

	/**
	 * @return string
	 */
	public function Label()
	{
		return '&nbsp;';
	}
	
	/**
	 * @return bool
	 */
	public function IsReservable()
	{
		return false;
	}

	/**
	 * @return bool
	 */
	public function IsReserved()
	{
		return false;
	}

	/**
	 * @return bool
	 */
	public function IsPending()
	{
		return false;
	}

	public function IsPastDate(Date $date)
	{
		return $this->displayDate->SetTime($this->Begin())->LessThan($date);
	}

	public function ToTimezone($timezone)
	{
		return new BlackoutSlot($this->BeginDate()->ToTimezone($timezone), $this->EndDate()->ToTimezone($timezone), $this->Date(), $this->PeriodSpan(), $this->blackout);
	}

	public function IsOwnedBy(UserSession $session)
	{
		return false;
	}
}
?>
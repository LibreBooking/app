<?php
/**
Copyright 2011-2014 Nick Korbel

This file is part of Booked SchedulerBooked SchedulereIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later versBooked SchedulerduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
alBooked SchedulercheduleIt.  If not, see <http://www.gnu.org/licenses/>.
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
	 * @var string
	 */
	protected $beginSlotId;

	/**
	 * @var string
	 */
	protected $endSlotId;

	/**
	 * @var SchedulePeriod
	 */
	protected $_beginPeriod;

	/**
	 * @var SchedulePeriod
	 */
	protected $_endPeriod;

	/**
	 * @param SchedulePeriod $begin
	 * @param SchedulePeriod $end
	 * @param Date $displayDate
	 * @param int $periodSpan
	 * @param BlackoutItemView $blackout
	 */
	public function __construct(SchedulePeriod $begin, SchedulePeriod $end, Date $displayDate, $periodSpan, BlackoutItemView $blackout)
	{
		$this->blackout = $blackout;
		$this->begin = $begin->BeginDate();
		$this->displayDate = $displayDate;
		$this->end = $end->EndDate();
		$this->periodSpan = $periodSpan;
		$this->beginSlotId = $begin->Id();
		$this->endSlotId = $end->Id();

		$this->_beginPeriod = $begin;
		$this->_endPeriod = $end;
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
		return $this->blackout->Title;
	}

	public function IsReservable()
	{
		return false;
	}

	public function IsReserved()
	{
		return false;
	}

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
		return new BlackoutSlot($this->_beginPeriod->ToTimezone($timezone), $this->_endPeriod->ToTimezone($timezone), $this->Date(), $this->PeriodSpan(), $this->blackout);
	}

	public function IsOwnedBy(UserSession $session)
	{
		return false;
	}

	public function IsParticipating(UserSession $session)
	{
		return false;
	}

	public function BeginSlotId()
	{
		return $this->beginSlotId;
	}

	public function EndSlotId()
	{
		return $this->endSlotId;
	}

	public function Color()
	{
		return null;
	}

	/**
	 * @return bool
	 */
	public function HasCustomColor()
	{
		return false;
	}

	/**
	 * @return string
	 */
	public function TextColor()
	{
		return null;
	}
}
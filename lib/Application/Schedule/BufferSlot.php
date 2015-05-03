<?php
/**
 * Copyright 2013-2015 Nick Korbel
 *
 * This file is part of phpScheduleIt.
 *
 * phpScheduleIt is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * phpScheduleIt is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */
class BufferSlot implements IReservationSlot
{
	/**
	 * @var Date
	 */
	protected $_begin;

	/**
	 * @var Date
	 */
	protected $_end;

	/**
	 * @var Date
	 */
	protected $_displayDate;

	/**
	 * @var int
	 */
	protected $_periodSpan;

	/**
	 * @var ReservationItemView
	 */
	private $_reservation;

	/**
	 * @var string
	 */
	protected $_beginSlotId;

	/**
	 * @var string
	 */
	protected $_endSlotId;

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
	 * @param ReservationItemView $reservation
	 */
	public function __construct(SchedulePeriod $begin, SchedulePeriod $end, Date $displayDate, $periodSpan,
								ReservationItemView $reservation)
	{
		$this->_reservation = $reservation;
		$this->_begin = $begin->BeginDate();
		$this->_displayDate = $displayDate;
		$this->_end = $end->EndDate();
		$this->_periodSpan = $periodSpan;

		$this->_beginSlotId = $begin->Id();
		$this->_endSlotId = $end->Id();

		$this->_beginPeriod = $begin;
		$this->_endPeriod = $end;
	}

	/**
	 * @return Time
	 */
	public function Begin()
	{
		return $this->_begin->GetTime();
	}

	/**
	 * @return Date
	 */
	public function BeginDate()
	{
		return $this->_begin;
	}

	/**
	 * @return Time
	 */
	public function End()
	{
		return $this->_end->GetTime();
	}

	/**
	 * @return Date
	 */
	public function EndDate()
	{
		return $this->_end;
	}

	/**
	 * @return Date
	 */
	public function Date()
	{
		return $this->_displayDate;
	}

	/**
	 * @return int
	 */
	public function PeriodSpan()
	{
		return $this->_periodSpan;
	}

	public function Label($factory = null)
	{
		return null;
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
		return $this->_displayDate->SetTime($this->Begin())
								  ->LessThan($date);
	}

	public function ToTimezone($timezone)
	{
		return new BufferSlot($this->_beginPeriod->ToTimezone($timezone), $this->_endPeriod->ToTimezone($timezone), $this->Date(), $this->PeriodSpan(), $this->_reservation);
	}

	public function Id()
	{
		return $this->_reservation->ReferenceNumber;
	}

	public function IsOwnedBy(UserSession $user)
	{
		return false;
	}

	public function IsParticipating(UserSession $session)
	{
		return false;
	}

	public function __toString()
	{
		return sprintf("Buffer Start: %s, End: %s, Span: %s", $this->Begin(), $this->End(), $this->PeriodSpan());
	}

	public function BeginSlotId()
	{
		return $this->_beginSlotId;
	}

	public function EndSlotId()
	{
		return $this->_beginSlotId;
	}

	public function HasCustomColor()
	{
		return false;
	}

	public function Color()
	{
		return null;
	}

	public function TextColor()
	{
		return null;
	}
}
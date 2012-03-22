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

require_once(ROOT_DIR . 'lib/Application/Schedule/SlotLabelFactory.php');

class ReservationSlot implements IReservationSlot
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
	 * @param Date $begin
	 * @param Date $end
	 * @param Date $displayDate
	 * @param int $periodSpan
	 * @param ReservationItemView $reservation
	 */
	public function __construct(Date $begin, Date $end, Date $displayDate, $periodSpan, ReservationItemView $reservation)
	{
		$this->_reservation = $reservation;
		$this->_begin = $begin;
		$this->_displayDate = $displayDate;
		$this->_end = $end;
		$this->_periodSpan = $periodSpan;
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

	public function Label()
	{
        return SlotLabelFactory::Create($this->_reservation);
	}

	public function IsReservable()
	{
		return false;
	}

	public function IsReserved()
	{
		return true;
	}

	public function IsPending()
	{
		return $this->_reservation->RequiresApproval;
	}

	public function IsPastDate(Date $date)
	{
		return $this->_displayDate->SetTime($this->Begin())->LessThan($date);
	}

	public function ToTimezone($timezone)
	{
		return new ReservationSlot($this->BeginDate()->ToTimezone($timezone), $this->EndDate()->ToTimezone($timezone), $this->Date(),  $this->PeriodSpan(), $this->_reservation);
	}

	public function Id()
	{
		return $this->_reservation->ReferenceNumber;
	}

	public function IsOwnedBy(UserSession $user)
	{
		return $this->_reservation->UserId == $user->UserId;
	}

	public function __toString()
	{
		return sprintf("Start: %s, End: %s, Span: %s", $this->Begin(), $this->End(), $this->PeriodSpan());
  	}
}

?>
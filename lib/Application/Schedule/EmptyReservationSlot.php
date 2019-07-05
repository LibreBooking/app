<?php
/**
Copyright 2011-2019 Nick Korbel

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

require_once(ROOT_DIR . 'Domain/Values/ReservationStartTimeConstraint.php');

class EmptyReservationSlot implements IReservationSlot
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
	protected $_date;

	/**
	 * @var $_isReservable
	 */
	protected $_isReservable;

	/**
	 * @var int
	 */
	protected $_periodSpan;

	protected $_beginDisplayTime;
	protected $_endDisplayTime;

	protected $_beginSlotId;
	protected $_endSlotId;

	protected $_beginPeriod;
	protected $_endPeriod;

	public function __construct(SchedulePeriod $begin, SchedulePeriod $end, Date $displayDate, $isReservable)
	{
		$this->_begin = $begin->BeginDate();
		$this->_end = $end->EndDate();
		$this->_date = $displayDate;
		$this->_isReservable = $isReservable;

		$this->_beginDisplayTime = $this->_begin->GetTime();
		if (!$this->_begin->DateEquals($displayDate))
		{
			$this->_beginDisplayTime = $displayDate->GetDate()->GetTime();
		}

		$this->_endDisplayTime = $this->_end->GetTime();
		if (!$this->_end->DateEquals($displayDate))
		{
			$this->_endDisplayTime = $displayDate->GetDate()->GetTime();
		}

		$this->_beginSlotId = $begin->Id();
		$this->_endSlotId = $end->Id();

		$this->_beginPeriod = $begin;
		$this->_endPeriod = $end;
	}

	public function Begin()
	{
		return $this->_beginDisplayTime;
	}

	public function BeginDate()
	{
		return $this->_begin;
	}


	public function End()
	{
		return $this->_endDisplayTime;
	}

	public function EndDate()
	{
		return $this->_end;
	}

	public function Date()
	{
		return $this->_date;
	}

	public function PeriodSpan()
	{
		return 1;
	}

	public function Label()
	{
		return '';
	}

	public function IsReservable()
	{
		return $this->_isReservable;
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
		$constraint = Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION,
															   ConfigKeys::RESERVATION_START_TIME_CONSTRAINT);

		if (empty($constraint))
		{
			$constraint = ReservationStartTimeConstraint::_DEFAULT;
		}

		if ($constraint == ReservationStartTimeConstraint::NONE)
		{
			return false;
		}

		if ($constraint == ReservationStartTimeConstraint::CURRENT)
		{
			return $this->_date->SetTime($this->End(), true)->LessThan($date);
		}

		return $this->_date->SetTime($this->Begin())->LessThan($date);
	}

	public function ToTimezone($timezone)
	{
		return new EmptyReservationSlot($this->_beginPeriod->ToTimezone($timezone), $this->_endPeriod->ToTimezone($timezone), $this->Date(),
										$this->_isReservable);
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
		return $this->_beginSlotId;
	}

	public function EndSlotId()
	{
		return $this->_endSlotId;
	}

	public function Color()
	{
		return null;
	}

	public function HasCustomColor()
	{
		return false;
	}

	public function TextColor()
	{
		return null;
	}

	public function CollidesWith(Date $date)
	{
		if ($this->IsReservable())
		{
			return false;
		}

		$range = new DateRange($this->_begin, $this->_end);
		return $range->Contains($date, false);
	}

	public function RequiresCheckin()
	{
		return false;
	}

	public function AutoReleaseMinutes()
	{
		return null;
	}

	public function AutoReleaseMinutesRemaining()
	{
		return null;
	}

	public function Id()
	{
		return '';
	}

    public function OwnerId()
    {
        return null;
    }

    public function OwnerGroupIds()
    {
        return array();
    }

    public function IsNew()
    {
        return false;
    }

    public function IsUpdated()
    {
        return false;
    }
}
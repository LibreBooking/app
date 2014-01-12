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

class ReservationListItem
{
	/**
	 * @var IReservedItemView
	 */
	protected $item;

	public function __construct(IReservedItemView $reservedItem)
	{
		$this->item = $reservedItem;
	}

	/**
	 * @return Date
	 */
	public function StartDate()
	{
		return $this->item->GetStartDate();
	}

	/**
	 * @return Date
	 */
	public function EndDate()
	{
		return $this->item->GetEndDate();
	}

	public function OccursOn(Date $date)
	{
		return $this->item->OccursOn($date);
	}

	/**
	 * @param SchedulePeriod $start
	 * @param SchedulePeriod $end
	 * @param Date $displayDate
	 * @param int $span
	 * @return IReservationSlot
	 */
	public function BuildSlot(SchedulePeriod $start, SchedulePeriod $end, Date $displayDate, $span)
	{
		return new ReservationSlot($start, $end, $displayDate, $span, $this->item);
	}

	/**
	 * @return int
	 */
	public function ResourceId()
	{
		return $this->item->GetResourceId();
	}

	/**
	 * @return int
	 */
	public function Id()
	{
		return $this->item->GetId();
	}

	public function IsReservation()
	{
		return true;
	}

	public function ReferenceNumber()
	{
		return $this->item->GetReferenceNumber();
	}

	/**
	 * @return null|TimeInterval
	 */
	public function BufferTime()
	{
		return $this->item->GetBufferTime();
	}

	/**
	 * @return bool
	 */
	public function HasBufferTime()
	{
		$bufferTime = $this->BufferTime();
		return !empty($bufferTime) && $bufferTime->TotalSeconds() > 0;
	}
}

class BufferItem extends ReservationListItem
{
	const LOCATION_BEFORE = 'begin';
	const LOCATION_AFTER = 'end';

	/**
	 * @var string
	 */
	private $location;

	/**
	 * @var Date
	 */
	private $startDate;

	/**
	 * @var Date
	 */
	private $endDate;

	public function __construct(ReservationListItem $item, $location)
	{
		parent::__construct($item->item);
		$this->item = $item;
		$this->location = $location;

		if ($this->IsBefore())
		{
			$this->startDate = $this->item->StartDate()->SubtractInterval($this->item->BufferTime());
			$this->endDate = $this->item->StartDate();
		}
		else
		{
			$this->startDate = $this->item->EndDate();
			$this->endDate = $this->item->EndDate()->AddInterval($this->item->BufferTime());
		}
	}

	public function BuildSlot(SchedulePeriod $start, SchedulePeriod $end, Date $displayDate, $span)
	{
		return new BufferSlot($start, $end, $displayDate, $span, $this->item->item);
	}

	/**
	 * @return Date
	 */
	public function StartDate()
	{
		return $this->startDate;
	}

	/**
	 * @return Date
	 */
	public function EndDate()
	{
		return $this->endDate;
	}

	private function IsBefore()
	{
		return $this->location == self::LOCATION_BEFORE;
	}

	public function OccursOn(Date $date)
	{
		return $this->item->OccursOn($date);
	}

	public function Id()
	{
		return $this->Id() . 'buffer_' . $this->location;
	}
	public function IsReservation()
	{
		return false;
	}

	public function HasBufferTime()
	{
		return false;
	}

	public function BufferTime()
	{
		return 0;
	}
}

class BlackoutListItem extends ReservationListItem
{
	/**
	 * @param SchedulePeriod $start
	 * @param SchedulePeriod $end
	 * @param Date $displayDate
	 * @param int $span
	 * @return IReservationSlot
	 */
	public function BuildSlot(SchedulePeriod $start, SchedulePeriod $end, Date $displayDate, $span)
	{
		return new BlackoutSlot($start, $end, $displayDate, $span, $this->item);
	}

	public function IsReservation()
	{
		return false;
	}
}
?>
<?php
/**
Copyright 2011-2013 Nick Korbel

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

	public function StartDate()
	{
		if ($this->SetupTime() > 0)
		{
			return $this->item->GetStartDate()->AddMinutes($this->SetupTime());
		}
		return $this->item->GetStartDate();
	}

	public function EndDate()
	{
		if ($this->TeardownTime() > 0)
		{
			return $this->item->GetEndDate()->AddMinutes(-$this->TeardownTime());
		}
		return $this->item->GetEndDate();
	}

	public function OccursOn(Date $date)
	{
		return $this->item->OccursOn($date);
	}

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

	/**
	 * @return int
	 */
	public function SetupTime()
	{
		return $this->item->GetSetupTime();
	}

	/**
	 * @return int
	 */
	public function TeardownTime()
	{
		return $this->item->GetTeardownTime();
	}
}

class SetUpItem extends ReservationListItem
{
	public function __construct(ReservationListItem $item)
	{
		$this->listItem = $item;
	}

	public function StartDate()
	{
		return $this->listItem->StartDate()->AddMinutes(-$this->listItem->SetupTime());
	}

	public function EndDate()
	{
		return $this->listItem->StartDate()->AddMinutes($this->listItem->SetupTime());
	}

	public function OccursOn(Date $date)
	{
		$dr = new DateRange($this->StartDate(), $this->EndDate());
		return $dr->OccursOn($date);
	}

	public function BuildSlot(SchedulePeriod $start, SchedulePeriod $end, Date $displayDate, $span)
	{
		return new SetUpSlot($start, $end, $displayDate, $span, $this->listItem->item);
	}

	/**
	 * @return int
	 */
	public function ResourceId()
	{
		return $this->listItem->ResourceId();
	}

	/**
	 * @return int
	 */
	public function Id()
	{
		return $this->listItem->Id();
	}

	public function SetupTime() { return 0; }

	public function TeardownTime() { return 0; }
}

class TearDownItem extends ReservationListItem
{
	public function __construct(ReservationListItem $item)
	{
		$this->listItem = $item;
	}

	public function StartDate()
	{
		return $this->listItem->EndDate()->AddMinutes(-$this->listItem->TeardownTime());
	}

	public function EndDate()
	{
		return $this->listItem->EndDate()->AddMinutes($this->listItem->TeardownTime());
	}

	public function OccursOn(Date $date)
	{
		$dr = new DateRange($this->StartDate(), $this->EndDate());
		return $dr->OccursOn($date);
	}

	public function BuildSlot(SchedulePeriod $start, SchedulePeriod $end, Date $displayDate, $span)
	{
		return new TearDownSlot($start, $end, $displayDate, $span, $this->listItem->item);
	}

	/**
	 * @return int
	 */
	public function ResourceId()
	{
		return $this->listItem->ResourceId();
	}

	/**
	 * @return int
	 */
	public function Id()
	{
		return $this->listItem->Id();
	}

	public function SetupTime() { return 0; }

	public function TeardownTime() { return 0; }
}

class SetUpSlot extends ReservationSlot
{
}

class TearDownSlot extends ReservationSlot
{

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

	public function SetupTime() { return 0; }

	public function TeardownTime() { return 0; }
}

?>
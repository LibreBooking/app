<?php
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
	 * @param Date $start
	 * @param Date $end
	 * @param Date $displayDate
	 * @param int $span
	 * @return IReservationSlot
	 */
	public function BuildSlot(Date $start, Date $end, Date $displayDate, $span)
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
}

class BlackoutListItem extends ReservationListItem
{
	/**
	 * @param Date $start
	 * @param Date $end
	 * @param Date $displayDate
	 * @param int $span
	 * @return IReservationSlot
	 */
	public function BuildSlot(Date $start, Date $end, Date $displayDate, $span)
	{
		throw new Exception('todo');
	}
}
?>
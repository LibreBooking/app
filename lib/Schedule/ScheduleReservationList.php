<?php

class ScheduleReservationList
{
	private $_reservations;
	private $_layout;
	private $_layoutItems;
	
	private $_reservationsByStartTime = array();
	private $_layoutByEndTime = array();
		
	
	public function __construct($reservations, IScheduleLayout $layout)
	{
		$this->_reservations = $reservations;
		$this->_layout = $layout;
		
		$this->_layoutItems = $this->_layout->GetLayout();
		
		$this->IndexReservations();
		$this->IndexLayout();
	}
	
	/**
	 * @param IScheduleLayout $layout
	 * @param Date $layoutDate
	 * @return array of IReservationSlot
	 */
	public function BuildSlots(Date $layoutDate)
	{
		$slots = array();
		$layoutTz = $this->_layout->Timezone();
		
		for ($currentIndex = 0; $currentIndex < count($this->_layoutItems); $currentIndex++)
		{
			$layoutItem = $this->_layoutItems[$currentIndex];
			
			$reservation = $this->GetReservationStartingAt($layoutItem->Begin());
			
			if ($reservation != null)
			{
				$endTime = $reservation->GetEndTime()->ToTimezone($layoutTz);
				$endingPeriodIndex = max($this->GetLayoutIndexEndingAt($endTime), $currentIndex);
				
				$slots[] = new ReservationSlot($layoutItem->Begin(), $this->_layoutItems[$endingPeriodIndex]->End(), ($endingPeriodIndex - $currentIndex) + 1);
				
				$currentIndex = $endingPeriodIndex;
			}
			else
			{
				$slots[] = new EmptyReservationSlot($layoutItem->Begin(), $layoutItem->End());
			}
		}
		
		$this->SplitCrossDaySlot($slots);
	
		return $slots;
	}
	
	private function IndexReservations()
	{
		foreach ($this->_reservations as $reservation)
		{
			$startTime = $reservation->GetStartTime()->ToTimezone($this->_layout->Timezone());
		
			$this->_reservationsByStartTime[$startTime->ToString()] = $reservation;
		}
	}
	
	private function IndexLayout()
	{
		for ($i = 0; $i < count($this->_layoutItems); $i++)		
		{
			$this->_layoutByEndTime[$this->_layoutItems[$i]->End()->ToString()] = $i;
		}
	}
	
	private function SplitCrossDaySlot(&$slots)
	{
		$firstSlot = $slots[0];
		$lastSlot = $slots[count($slots)-1];
		$midnight = new Time(0,0,0, $this->_layout->Timezone());
		
		if ($lastSlot->End()->Hour() != 0)
		{
			$slots[count($slots)-1] = new EmptyReservationSlot($lastSlot->Begin(), $midnight);
		}
		
		if ($firstSlot->Begin()->Hour() != 0)
		{
			$newFirstSlot = new EmptyReservationSlot($midnight, $slots[0]->Begin());
			array_unshift($slots, $newFirstSlot);
		}
	}
	
	/**
	 * @param Time $endingTime
	 * @return int index of $_layoutItems which has the corresponding $endingTime
	 */
	private function GetLayoutIndexEndingAt(Time $endingTime)
	{
		$timeKey = $endingTime->ToString();
		
		if (array_key_exists($timeKey, $this->_layoutByEndTime))
		{
			return $this->_layoutByEndTime[$timeKey];
		}
		
		return $this->FindClosestLayoutIndexBeforeEndingTime($endingTime);
	}
	
	/**
	 * @param Time $beginTime
	 * @return ScheduleReservation
	 */
	private function GetReservationStartingAt(Time $beginTime)
	{
		$timeKey = $beginTime->ToString();
		if (array_key_exists($timeKey, $this->_reservationsByStartTime))
		{
			return $this->_reservationsByStartTime[$timeKey];
		}
		return null;
	}
	
	
	/**
	 * @param Time $endingTime
	 * @return int index of $_layoutItems which has the closest ending time to $endingTime without going past it
	 */
	private function FindClosestLayoutIndexBeforeEndingTime(Time $endingTime)
	{	
		for ($i = 0; $i < count($this->_layoutItems); $i++)		
		{
			$currentItem = $this->_layoutItems[$i];
		
			if ($currentItem->End()->Compare($endingTime) > 0 )
			{
				return $i-1;
			}
		}
		
		return 0;
	}
}
?>
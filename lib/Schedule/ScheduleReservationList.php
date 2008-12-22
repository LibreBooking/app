<?php

class ScheduleReservationList
{
	private $_reservations;
	private $_layout;
	private $_layoutDate;
	
	private $_layoutItems;
	
	private $_reservationsByStartTime = array();
	private $_layoutByEndTime = array();	
	
	private $_midnight;
	
	/**
	 * Enter description here...
	 *
	 * @param array $reservations array of ScheduleReservation objects
	 * @param IScheduleLayout $layout
	 * @param Date $layoutDate
	 */
	public function __construct($reservations, IScheduleLayout $layout, Date $layoutDate)
	{
		$this->_reservations = $reservations;
		$this->_layout = $layout;
		$this->_layoutDate = $layoutDate;
		
		$this->_layoutItems = $this->_layout->GetLayout();
		$this->_midnight = new Time(0,0,0, $this->_layout->Timezone());
		
		$this->IndexReservations();
		$this->IndexLayout();
	}
	
	/**
	 * @return array of IReservationSlot
	 */
	public function BuildSlots()
	{
		$slots = array();
		
		for ($currentIndex = 0; $currentIndex < count($this->_layoutItems); $currentIndex++)
		{
			$layoutItem = $this->_layoutItems[$currentIndex];
			
			$reservation = $this->GetReservationStartingAt($layoutItem->Begin());
			
			if ($reservation != null)
			{
				if ($this->ReservationEndsOnFutureDate($reservation))
				{
					$endTime = $this->_midnight;
				}
				else
				{
					$endTime = $reservation->GetEndTime();
				}
				
				$endingPeriodIndex = max($this->GetLayoutIndexEndingAt($endTime), $currentIndex);
				
				$slots[] = new ReservationSlot($layoutItem->Begin(), $this->_layoutItems[$endingPeriodIndex]->End(), ($endingPeriodIndex - $currentIndex) + 1);
				
				$currentIndex = $endingPeriodIndex;
			}
			else
			{
				$slots[] = new EmptyReservationSlot($layoutItem->Begin(), $layoutItem->End());
			}
		}
		
		//$this->SplitCrossDaySlot($slots);
	
		return $slots;
	}
	
	private function IndexReservations()
	{
		foreach ($this->_reservations as $reservation)
		{
			if ($this->ReservationStartsOnPastDate($reservation))
			{
				$startTime = $this->_midnight;
			}
			else 
			{
				$startTime = $reservation->GetStartTime();
			}
			
			$this->_reservationsByStartTime[$startTime->ToString()] = $reservation;
		}
	}
	
	private function ReservationStartsOnPastDate(ScheduleReservation $reservation)
	{
		return $reservation->GetStartDate()->Compare($this->_layoutDate) < 0;
	}
	
	private function ReservationEndsOnFutureDate(ScheduleReservation $reservation)
	{
		return $reservation->GetEndDate()->Compare($this->_layoutDate) > 0;
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
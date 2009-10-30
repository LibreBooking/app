<?php

interface IScheduleReservationList
{
	/**
	 * @return array[int]IReservationSlot
	 */
	function BuildSlots();
}

class ScheduleReservationList implements IScheduleReservationList
{
	private $_reservations;
	/**
	 * @var IScheduleLayout
	 */
	private $_layout;
	private $_layoutDateUtc;
	
	private $_layoutItems;
	
	private $_reservationsByStartTime = array();
	private $_layoutByEndTime = array();	
	
	private $_midnight;
	private $_destinationTimezone;
	
	/**
	 * @param array[int]ScheduleReservation $reservations array of ScheduleReservation objects
	 * @param IScheduleLayout $layout
	 * @param Date $layoutDate
	 */
	public function __construct($reservations, IScheduleLayout $layout, Date $layoutDate)
	{
		$this->_reservations = $reservations;
		$this->_layout = $layout;
		$this->_destinationTimezone = $this->_layout->Timezone();
		$this->_layoutDateUtc = $layoutDate->ToUtc()->GetDate();
		$this->_layoutItems = $this->_layout->GetLayout();
		$this->_midnight = new Time(0,0,0, $this->_destinationTimezone);
			
		$this->IndexReservations();
		$this->IndexLayout();
	}
	
	public function BuildSlots()
	{
		$slots = array();
		
		for ($currentIndex = 0; $currentIndex < count($this->_layoutItems); $currentIndex++)
		{
			$layoutItem = $this->_layoutItems[$currentIndex];
			$reservation = $this->GetReservationStartingAt($layoutItem->Begin());
			
			if ($currentIndex == 0 && $reservation == null)
			{
				$reservation = $this->GetFirstReservation($layoutItem->Begin());
			}
			
			if ($reservation != null)
			{
				if ($this->ReservationEndsOnFutureDate($reservation))
				{
					$endTime = $this->_midnight;
				}
				else
				{
					$endTime = $reservation->GetEndTime()->ToTimezone($this->_destinationTimezone);
				}
				
				$endingPeriodIndex = max($this->GetLayoutIndexEndingAt($endTime), $currentIndex);
				
				$slots[] = new ReservationSlot($layoutItem->Begin(), $this->_layoutItems[$endingPeriodIndex]->End(), ($endingPeriodIndex - $currentIndex) + 1, $reservation);
				
				$currentIndex = $endingPeriodIndex;
			}
			else
			{
				$slots[] = new EmptyReservationSlot($layoutItem->Begin(), $layoutItem->End(), $layoutItem->IsReservable());
			}
		}
	
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
				$startTime = $reservation->GetStartTime()->ToTimezone($this->_destinationTimezone);
			}
			
			$this->_reservationsByStartTime[$startTime->ToString()] = $reservation;
		}
	}
	
	private function ReservationStartsOnPastDate(ScheduleReservation $reservation)
	{
		return $reservation->GetStartDate()->GetDate()->LessThan($this->_layoutDateUtc);
	}
	
	private function ReservationEndsOnFutureDate(ScheduleReservation $reservation)
	{
		return $reservation->GetEndDate()->GetDate()->GreaterThan($this->_layoutDateUtc);
	}
	
	private function IndexLayout()
	{
		for ($i = 0; $i < count($this->_layoutItems); $i++)		
		{
			$this->_layoutByEndTime[$this->_layoutItems[$i]->End()->ToString()] = $i;
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
	
	private function GetFirstReservation(Time $firstSlotBegin)
	{
		$possibleFirstReservation = $this->GetReservationStartingAt($firstSlotBegin);
		
		if ($possibleFirstReservation != null)
		{
			return $possibleFirstReservation;
		}
		
		/*
		$timeKeys = array_keys($this->_reservationsByStartTime);
		if (Time::Parse($timeKeys[1])->LessThan($firstSlotBegin))
		{
			return $this->_reservationsByStartTime[$timeKeys[0]];
		}
		*/
		
		foreach ($this->_reservationsByStartTime as $timeKey => $reservation)
		{
			if ($reservation->GetStartTime()->ToTimezone($this->_destinationTimezone)->LessThan($firstSlotBegin) && $reservation->GetEndTime()->ToTimezone($this->_destinationTimezone)->GreaterThan($firstSlotBegin))
			{
				return $reservation;
			}
		}
		
		return null;

	}
}
?>
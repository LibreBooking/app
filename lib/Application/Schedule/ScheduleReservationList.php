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
	
	/**
	 * @var Date
	 */
	private $_layoutDateStart;
	
	/**
	 * @var Date
	 */
	private $_layoutDateEnd;
	
	private $_layoutItems;
	
	private $_reservationsByStartTime = array();
	private $_layoutByEndTime = array();	
	
	/**
	 * @var Time
	 */
	private $_midnight;
	private $_destinationTimezone;
	
	/**
	 * @var Date
	 */
	private $_firstLayoutTime; 
	
	/**
	 * @param array|ScheduleReservation[] $reservations array of ScheduleReservation objects
	 * @param IScheduleLayout $layout
	 * @param Date $layoutDate
	 */
	public function __construct($reservations, IScheduleLayout $layout, Date $layoutDate)
	{
		$this->_reservations = $reservations;
		$this->_layout = $layout;
		$this->_destinationTimezone = $this->_layout->Timezone();
		$this->_layoutDateStart = $layoutDate->ToTimezone($this->_destinationTimezone)->GetDate();
		$this->_layoutDateEnd = $this->_layoutDateStart->AddDays(1);
		$this->_layoutItems = $this->_layout->GetLayout($layoutDate);
		$this->_midnight = new Time(0,0,0, $this->_destinationTimezone);
		
		$this->IndexLayout();
		$this->IndexReservations();
	}
	
	public function BuildSlots()
	{
		$slots = array();
		
		for ($currentIndex = 0; $currentIndex < count($this->_layoutItems); $currentIndex++)
		{
			$layoutItem = $this->_layoutItems[$currentIndex];
			$reservation = $this->GetReservationStartingAt($layoutItem->BeginDate());
			
			if ($reservation != null)
			{			
				if ($this->ReservationEndsOnFutureDate($reservation))
				{
					$endTime = $this->_layoutDateEnd;
				}
				else
				{
					$endTime = $reservation->GetEndDate()->ToTimezone($this->_destinationTimezone);
				}
				
				$endingPeriodIndex = max($this->GetLayoutIndexEndingAt($endTime), $currentIndex);
				$span = ($endingPeriodIndex - $currentIndex) + 1;
				$slots[] = new ReservationSlot($layoutItem->BeginDate(), $this->_layoutItems[$endingPeriodIndex]->EndDate(), $this->_layoutDateStart, $span, $reservation);
				
				$currentIndex = $endingPeriodIndex;
			}
			else
			{
				$slots[] = new EmptyReservationSlot($layoutItem->BeginDate(), $layoutItem->EndDate(), $this->_layoutDateStart, $layoutItem->IsReservable());
			}
		}
	
		return $slots;
	}
	
	private function IndexReservations()
	{
		foreach ($this->_reservations as $reservation)
		{		
			$start = $reservation->GetStartDate()->ToTimezone($this->_destinationTimezone);
			
			$startsInPast = $this->ReservationStartsOnPastDate($reservation);
			if ($startsInPast)
			{
				$start = $this->_firstLayoutTime;
			}
			
			$this->_reservationsByStartTime[$start->Timestamp()] = $reservation;
		}
	}
	
	private function ReservationStartsOnPastDate(ScheduleReservation $reservation)
	{
		//Log::Debug("PAST");
		return $reservation->GetStartDate()->LessThan($this->_layoutDateStart);
	}
	
	private function ReservationEndsOnFutureDate(ScheduleReservation $reservation)
	{
		//Log::Debug("%s %s %s", $reservation->GetReferenceNumber(), $reservation->GetEndDate()->GetDate(), $this->_layoutDateEnd->GetDate());
		return $reservation->GetEndDate()->Compare($this->_layoutDateEnd) >= 0;
	}
	
	private function IndexLayout()
	{
		$this->_firstLayoutTime =  $this->_layoutDateEnd;
		
		for ($i = 0; $i < count($this->_layoutItems); $i++)		
		{
			$itemBegin = $this->_layoutItems[$i]->BeginDate();
			if ($itemBegin->LessThan($this->_firstLayoutTime))
			{
				$this->_firstLayoutTime =  $this->_layoutItems[$i]->BeginDate();
			}
			
			$endTime = $this->_layoutItems[$i]->EndDate();
			if (!$this->_layoutItems[$i]->EndDate()->DateEquals($this->_layoutDateStart))
			{
				$endTime = $this->_layoutDateEnd;
			}
			$this->_layoutByEndTime[$endTime->Timestamp()] = $i;
		}
	}
	
	/**
	 * @param Date $endingTime
	 * @return int index of $_layoutItems which has the corresponding $endingTime
	 */
	private function GetLayoutIndexEndingAt(Date $endingTime)
	{
		$timeKey = $endingTime->Timestamp();
		
		if (array_key_exists($timeKey, $this->_layoutByEndTime))
		{
			return $this->_layoutByEndTime[$timeKey];
		}
		
		return $this->FindClosestLayoutIndexBeforeEndingTime($endingTime);
	}
	
	/**
	 * @param Date $beginTime
	 * @return ScheduleReservation
	 */
	private function GetReservationStartingAt(Date $beginTime)
	{
		$timeKey = $beginTime->Timestamp();
		if (array_key_exists($timeKey, $this->_reservationsByStartTime))
		{
			return $this->_reservationsByStartTime[$timeKey];
		}
		return null;
	}
	
	/**
	 * @param Date $endingTime
	 * @return int index of $_layoutItems which has the closest ending time to $endingTime without going past it
	 */
	private function FindClosestLayoutIndexBeforeEndingTime(Date $endingTime)
	{	
		for ($i = 0; $i < count($this->_layoutItems); $i++)		
		{
			$currentItem = $this->_layoutItems[$i];
		
			if ($currentItem->EndDate()->GreaterThan($endingTime) )
			{
				return $i;
			}
		}
		
		return 0;
	}
}
?>
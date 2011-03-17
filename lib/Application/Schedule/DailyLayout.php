<?php
interface IDailyLayout
{
	/**
	 * @return array[int]IReservationSlot
	 */
	function GetLayout(Date $date, $resourceId);
	
	/**
	 * @param Date $date
	 * @return bool
	 */
	function IsDateReservable(Date $date);
	
	/**
	 * @param Date $displayDate
	 * @return string[]
	 */
	function GetLabels(Date $displayDate);
}

class DailyLayout implements IDailyLayout
{
	/**
	 * @var IReservationListing
	 */
	private $_reservationListing;
	/**
	 * @var IScheduleLayout
	 */
	private $_scheduleLayout;
	
	/**
	 * @param IReservationListing $listing
	 * @param IScheduleLayout $layout
	 */
	public function __construct(IReservationListing $listing, IScheduleLayout $layout)
	{
		$this->_reservationListing = $listing;
		$this->_scheduleLayout = $layout;
	}
	
	public function GetLayout(Date $date, $resourceId)
	{
		$onDate = $this->_reservationListing->OnDate($date);
		$forResource = $onDate->ForResource($resourceId);
		
		$list = new ScheduleReservationList($forResource->Reservations(), $this->_scheduleLayout, $date);
		return $list->BuildSlots();
	}
	
	public function IsDateReservable(Date $date)
	{
		return !$date->GetDate()->LessThan(Date::Now()->GetDate());
	}
	
	public function GetLabels(Date $displayDate)
	{
		$labels = array();
		
		$periods = $this->_scheduleLayout->GetLayout($displayDate);
		
		if ($periods[0]->BeginsBefore($displayDate))
		{
			$labels[] = $periods[0]->Label($displayDate->GetDate());
		}
		else
		{
			$labels[] = $periods[0]->Label();
		}
		
		for ($i = 1; $i < count($periods); $i++)
		{
			$labels[] = $periods[$i]->Label();
		}
		
		return $labels;
	}
}

interface IDailyLayoutFactory
{
	/**
	 * @param IReservationListing $listing
	 * @param IScheduleLayout $layout
	 * @return IDailyLayout
	 */
	function Create(IReservationListing $listing, IScheduleLayout $layout);	
}

class DailyLayoutFactory implements IDailyLayoutFactory
{
	public function Create(IReservationListing $listing, IScheduleLayout $layout)
	{
		return new DailyLayout($listing, $layout);
	}
}
?>
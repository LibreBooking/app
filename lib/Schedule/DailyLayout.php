<?php
interface IDailyLayout
{
	/**
	 * @return array[int]IReservationSlot
	 */
	function GetLayout($date, $resourceId);
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
	
	public function GetLayout($date, $resourceId)
	{
		$onDate = $this->_reservationListing->OnDate($date);
		$forResource = $onDate->ForResource($resourceId);
		
		$list = new ScheduleReservationList($forResource->Reservations(), $this->_scheduleLayout, $date);
		return $list->BuildSlots();
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
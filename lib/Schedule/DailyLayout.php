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
	 * @var string
	 */
	private $_targetTimezone;
	
	/**
	 * @param IReservationListing $listing
	 * @param IScheduleLayout $layout
	 * @param string $targetTimezone
	 */
	public function __construct(IReservationListing $listing, IScheduleLayout $layout, $targetTimezone)
	{
		$this->_reservationListing = $listing;
		$this->_scheduleLayout = $layout;
		$this->_targetTimezone = $targetTimezone;
	}
	
	public function GetLayout($date, $resourceId)
	{
		$onDate = $this->_reservationListing->OnDate($date);
		$forResource = $onDate->ForResource($resourceId);
		
		$list = new ScheduleReservationList($forResource->Reservations(), $this->_scheduleLayout, $date, $this->_targetTimezone);
		return $list->BuildSlots();
	}
}

interface IDailyLayoutFactory
{
	/**
	 * @param IReservationListing $listing
	 * @param IScheduleLayout $layout
	 * @param string $targetTimezone
	 * @return IDailyLayout
	 */
	function Create(IReservationListing $listing, IScheduleLayout $layout, $targetTimezone);	
}

class DailyLayoutFactory implements IDailyLayoutFactory
{
	public function Create(IReservationListing $listing, IScheduleLayout $layout, $targetTimezone)
	{
		return new DailyLayout($listing, $layout, $targetTimezone);
	}
}
?>
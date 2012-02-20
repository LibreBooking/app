<?php
/**
Copyright 2011-2012 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Common/Helpers/StopWatch.php');

interface IDailyLayout
{
	/**
	 * @param Date $date
	 * @param int $resourceId
	 * @return array|IReservationSlot[]
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
		$sw = new StopWatch();
		$sw->Start();

		$items = $this->_reservationListing->OnDateForResource($date, $resourceId);
		$sw->Record('listing');

		$list = new ScheduleReservationList($items, $this->_scheduleLayout, $date);
		$slots = $list->BuildSlots();
		$sw->Record('slots');
		$sw->Stop();

//		Log::Debug("DailyLayout::GetLayout - For resourceId %s on date %s, took %s seconds to get reservation listing, %s to build the slots, %s total seconds for %s reservations",
//			$resourceId,
//			$date->ToString(),
//			$sw->GetRecordSeconds('listing'),
//			$sw->TimeBetween('slots', 'listing'),
//			$sw->GetTotalSeconds(),
//			count($items));

		return $slots;
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
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

interface IScheduleReservationList
{
	/**
	 * @return array[int]IReservationSlot
	 */
	function BuildSlots();
}

class ScheduleReservationList implements IScheduleReservationList
{
	/**
	 * @var array|ReservationListItem[]
	 */
	private $_items;

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

	/**
	 * @var array|SchedulePeriod[]
	 */
	private $_layoutItems;

	private $_itemsByStartTime = array();

	/**
	 * @var array|SchedulePeriod[]
	 */
	private $_layoutByStartTime = array();

	/**
	 * @var array|int[]
	 */
	private $_layoutIndexByEndTime = array();

	/**
	 * @var Time
	 */
	private $_midnight;

	/**
	 * @var string
	 */
	private $_destinationTimezone;

	/**
	 * @var Date
	 */
	private $_firstLayoutTime;

	/**
	 * @param array|ReservationListItem[] $items
	 * @param IScheduleLayout $layout
	 * @param Date $layoutDate
	 * @param bool $hideBlockedPeriods
	 */
	public function __construct($items, IScheduleLayout $layout, Date $layoutDate, $hideBlockedPeriods = false)
	{
		$this->_items = $items;
		$this->_layout = $layout;
		$this->_destinationTimezone = $this->_layout->Timezone();
		$this->_layoutDateStart = $layoutDate->ToTimezone($this->_destinationTimezone)->GetDate();
		$this->_layoutDateEnd = $this->_layoutDateStart->AddDays(1);
		$this->_layoutItems = $this->_layout->GetLayout($layoutDate, $hideBlockedPeriods);
		$this->_midnight = new Time(0, 0, 0, $this->_destinationTimezone);

		$this->IndexLayout();
		$this->IndexItems();
	}

	public function BuildSlots()
	{
		$slots = array();

		for ($currentIndex = 0; $currentIndex < count($this->_layoutItems); $currentIndex++)
		{
			$layoutItem = $this->_layoutItems[$currentIndex];
			$item = $this->GetItemStartingAt($layoutItem->BeginDate());

			if ($item != null)
			{
				if ($this->ItemEndsOnFutureDate($item))
				{
					$endTime = $this->_layoutDateEnd;
				}
				else
				{
					$endTime = $item->EndDate()->ToTimezone($this->_destinationTimezone);
				}

				$endingPeriodIndex = max($this->GetLayoutIndexEndingAt($endTime), $currentIndex);

				$span = ($endingPeriodIndex - $currentIndex) + 1;

				$slots[] = $item->BuildSlot($layoutItem, $this->_layoutItems[$endingPeriodIndex],
											$this->_layoutDateStart, $span);

				$currentIndex = $endingPeriodIndex;
			}
			else
			{
				$slots[] = new EmptyReservationSlot($layoutItem, $layoutItem, $this->_layoutDateStart, $layoutItem->IsReservable());
			}
		}

		return $slots;
	}

	private function IndexItems()
	{
		foreach ($this->_items as $item)
		{
			if ($item->EndDate()->ToTimezone($this->_destinationTimezone)->Equals($this->_firstLayoutTime))
			{
				continue;
			}

			$start = $item->StartDate()->ToTimezone($this->_destinationTimezone);

			$startsInPast = $this->ItemStartsOnPastDate($item);
			if ($startsInPast)
			{
				$start = $this->_firstLayoutTime;
			}
			elseif ($this->ItemIsNotOnLayoutBoundary($item))
			{
				$layoutItem = $this->FindClosestLayoutIndexBeforeStartingTime($item);
				if (!empty($layoutItem))
				{
					$start = $layoutItem->BeginDate()->ToTimezone($this->_destinationTimezone);
				}
			}

			$this->_itemsByStartTime[$start->Timestamp()] = $item;
		}
	}

	private function ItemStartsOnPastDate(ReservationListItem $item)
	{
		//Log::Debug("PAST");
		return $item->StartDate()->LessThan($this->_layoutDateStart);
	}

	private function ItemEndsOnFutureDate(ReservationListItem $item)
	{
		//Log::Debug("%s %s %s", $reservation->GetReferenceNumber(), $reservation->GetEndDate()->GetDate(), $this->_layoutDateEnd->GetDate());
		return $item->EndDate()->Compare($this->_layoutDateEnd) >= 0;
	}

	private function IndexLayout()
	{
		if (!LayoutIndexCache::Contains($this->_layoutDateStart))
		{
			LayoutIndexCache::Add($this->_layoutDateStart, $this->_layoutItems, $this->_layoutDateStart,
								  $this->_layoutDateEnd);
		}
		$cachedIndex = LayoutIndexCache::Get($this->_layoutDateStart);
		$this->_firstLayoutTime = $cachedIndex->GetFirstLayoutTime();
		$this->_layoutByStartTime = $cachedIndex->LayoutByStartTime();
		$this->_layoutIndexByEndTime = $cachedIndex->LayoutIndexByEndTime();
	}

	/**
	 * @param Date $endingTime
	 * @return int index of $_layoutItems which has the corresponding $endingTime
	 */
	private function GetLayoutIndexEndingAt(Date $endingTime)
	{
		$timeKey = $endingTime->Timestamp();

		if (array_key_exists($timeKey, $this->_layoutIndexByEndTime))
		{
			return $this->_layoutIndexByEndTime[$timeKey];
		}

		return $this->FindClosestLayoutIndexBeforeEndingTime($endingTime);
	}

	/**
	 * @param Date $beginTime
	 * @return ReservationListItem
	 */
	private function GetItemStartingAt(Date $beginTime)
	{
		$timeKey = $beginTime->Timestamp();
		if (array_key_exists($timeKey, $this->_itemsByStartTime))
		{
			return $this->_itemsByStartTime[$timeKey];
		}
		return null;
	}

	/**
	 * @param Date $endingTime
	 * @return int index of $_layoutItems which has the closest ending time to $endingTime without going past it
	 */
	private function FindClosestLayoutIndexBeforeEndingTime(Date $endingTime)
	{
		for ($i = count($this->_layoutItems) - 1; $i >= 0; $i--)
		{
			$currentItem = $this->_layoutItems[$i];

			if ($currentItem->BeginDate()->LessThan($endingTime))
			{
				return $i;
			}
		}

		return 0;
	}

	/**
	 * @param ReservationListItem $item
	 * @return SchedulePeriod which has the closest starting time to $endingTime without going prior to it
	 */
	private function FindClosestLayoutIndexBeforeStartingTime(ReservationListItem $item)
	{
		for ($i = count($this->_layoutItems) - 1; $i >= 0; $i--)
		{
			$currentItem = $this->_layoutItems[$i];

			if ($currentItem->BeginDate()->LessThan($item->StartDate()))
			{
				return $currentItem;
			}
		}

		Log::Error('Could not find a fitting starting slot for reservation. Id %s, ResourceId: %s, Start: %s, End: %s',
				   $item->Id(), $item->ResourceId(), $item->StartDate()->ToString(), $item->EndDate()->ToString());
		return null;
	}

	/**
	 * @param ReservationListItem $item
	 * @return bool
	 */
	private function ItemIsNotOnLayoutBoundary(ReservationListItem $item)
	{
		$timeKey = $item->StartDate()->Timestamp();
		return !(array_key_exists($timeKey, $this->_layoutByStartTime));
	}
}

class LayoutIndexCache
{
	/**
	 * @var CachedLayoutIndex[]
	 */
	private static $_cache = array();

	/**
	 * @param Date $date
	 * @return bool
	 */
	public static function Contains(Date $date)
	{
		return array_key_exists($date->Timestamp(), self::$_cache);
	}

	/**
	 * @param Date $date
	 * @param SchedulePeriod[] $schedulePeriods
	 * @param Date $startDate
	 * @param Date $endDate
	 */
	public static function Add(Date $date, $schedulePeriods, Date $startDate, Date $endDate)
	{
		self::$_cache[$date->Timestamp()] = new CachedLayoutIndex($schedulePeriods, $startDate, $endDate);
	}

	public static function Get(Date $date)
	{
		return self::$_cache[$date->Timestamp()];
	}

	public static function Clear() { self::$_cache = array(); }
}

class CachedLayoutIndex
{
	private $_firstLayoutTime;
	private $_layoutByStartTime = array();
	private $_layoutIndexByEndTime = array();

	/**
	 * @param SchedulePeriod[] $schedulePeriods
	 * @param Date $startDate
	 * @param Date $endDate
	 */
	public function __construct($schedulePeriods, Date $startDate, Date $endDate)
	{
		$this->_firstLayoutTime = $endDate;

		for ($i = 0; $i < count($schedulePeriods); $i++)
		{
			/** @var Date $itemBegin */
			$itemBegin = $schedulePeriods[$i]->BeginDate();
			if ($itemBegin->LessThan($this->_firstLayoutTime))
			{
				$this->_firstLayoutTime = $schedulePeriods[$i]->BeginDate();
			}

			/** @var Date $endTime */
			$endTime = $schedulePeriods[$i]->EndDate();
			if (!$schedulePeriods[$i]->EndDate()->DateEquals($startDate))
			{
				$endTime = $endDate;
			}

			$this->_layoutByStartTime[$itemBegin->Timestamp()] = $schedulePeriods[$i];
			$this->_layoutIndexByEndTime[$endTime->Timestamp()] = $i;
		}
	}

	public function GetFirstLayoutTime() { return $this->_firstLayoutTime; }

	public function LayoutByStartTime() { return $this->_layoutByStartTime; }

	public function LayoutIndexByEndTime() { return $this->_layoutIndexByEndTime; }
}

?>
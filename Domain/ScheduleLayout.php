<?php
/**
Copyright 2011-2014 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Domain/Values/DayOfWeek.php');

interface ILayoutTimezone
{
	public function Timezone();
}

interface IDailyScheduleLayout
{
	/**
	 * @return bool
	 */
	public function UsesDailyLayouts();
}

interface IScheduleLayout extends ILayoutTimezone, IDailyScheduleLayout
{
	/**
	 * @param Date $layoutDate
	 * @param bool $hideBlockedPeriods
	 * @return SchedulePeriod[]|array of SchedulePeriod objects
	 */
	public function GetLayout(Date $layoutDate, $hideBlockedPeriods = false);

	/**
	 * @abstract
	 * @param Date $date
	 * @return SchedulePeriod|null period which occurs at this datetime. Includes start time, excludes end time. null if no match is found
	 */
	public function GetPeriod(Date $date);
}

interface ILayoutCreation extends ILayoutTimezone, IDailyScheduleLayout
{
	/**
	 * Appends a period to the schedule layout
	 *
	 * @param Time $startTime starting time of the schedule in specified timezone
	 * @param Time $endTime ending time of the schedule in specified timezone
	 * @param string $label optional label for the period
	 * @param DayOfWeek|int|null $dayOfWeek
	 */
	function AppendPeriod(Time $startTime, Time $endTime, $label = null, $dayOfWeek = null);

	/**
	 * Appends a period that is not reservable to the schedule layout
	 *
	 * @param Time $startTime starting time of the schedule in specified timezone
	 * @param Time $endTime ending time of the schedule in specified timezone
	 * @param string $label optional label for the period
	 * @param DayOfWeek|int|null $dayOfWeek
	 * @return void
	 */
	function AppendBlockedPeriod(Time $startTime, Time $endTime, $label = null, $dayOfWeek = null);

	/**
	 *
	 * @param DayOfWeek|int|null $dayOfWeek
	 * @return LayoutPeriod[] array of LayoutPeriod
	 */
	function GetSlots($dayOfWeek = null);
}

class ScheduleLayout implements IScheduleLayout, ILayoutCreation
{
	/**
	 * @var array|LayoutPeriod[]
	 */
	private $_periods = array();

	/**
	 * @var string
	 */
	private $targetTimezone;

	/**
	 * @var bool
	 */
	private $cached = false;

	private $cachedPeriods = array();

	/**
	 * @var bool
	 */
	private $usingDailyLayouts = false;

	/**
	 * @var string
	 */
	private $layoutTimezone;

	/**
	 * @param string $targetTimezone target timezone of layout
	 */
	public function __construct($targetTimezone = null)
	{
		$this->targetTimezone = $targetTimezone;
		if ($targetTimezone == null)
		{
			$this->targetTimezone = Configuration::Instance()->GetDefaultTimezone();
		}
	}

	/**
	 * @param DayOfWeek|int|null $dayOfWeek
	 * @throws Exception
	 * @return LayoutPeriod[]|array
	 */
	public function GetSlots($dayOfWeek = null)
	{
		if (is_null($dayOfWeek))
		{
			if ($this->usingDailyLayouts)
			{
				throw new Exception('ScheduleLayout->GetSlots() $dayOfWeek required when using daily layouts');
			}
			$periods = $this->_periods;
		}
		else
		{
			if (!$this->usingDailyLayouts)
			{
				throw new Exception('ScheduleLayout->GetSlots() $dayOfWeek cannot be provided when using single layout');
			}
			$periods = $this->_periods[$dayOfWeek];
		}
		$this->SortItems($periods);
		return $periods;
	}

	/**
	 * Appends a period to the schedule layout
	 *
	 * @param Time $startTime starting time of the schedule in specified timezone
	 * @param Time $endTime ending time of the schedule in specified timezone
	 * @param string $label optional label for the period
	 * @param DayOfWeek|int|null $dayOfWeek
	 */
	public function AppendPeriod(Time $startTime, Time $endTime, $label = null, $dayOfWeek = null)
	{
		$this->AppendGenericPeriod($startTime, $endTime, PeriodTypes::RESERVABLE, $label, $dayOfWeek);
	}

	/**
	 * Appends a period that is not reservable to the schedule layout
	 *
	 * @param Time $startTime starting time of the schedule in specified timezone
	 * @param Time $endTime ending time of the schedule in specified timezone
	 * @param string $label optional label for the period
	 * @param DayOfWeek|int|null $dayOfWeek
	 * @return void
	 */
	public function AppendBlockedPeriod(Time $startTime, Time $endTime, $label = null, $dayOfWeek = null)
	{
		$this->AppendGenericPeriod($startTime, $endTime, PeriodTypes::NONRESERVABLE, $label, $dayOfWeek);
	}

	protected function AppendGenericPeriod(Time $startTime, Time $endTime, $periodType, $label = null,
										   $dayOfWeek = null)
	{
		$this->layoutTimezone = $startTime->Timezone();
		$layoutPeriod = new LayoutPeriod($startTime, $endTime, $periodType, $label);
		if (!is_null($dayOfWeek))
		{
			$this->usingDailyLayouts = true;
			$this->_periods[$dayOfWeek][] = $layoutPeriod;
		}
		else
		{
			$this->_periods[] = $layoutPeriod;
		}
	}

	/**
	 * @param Date $start
	 * @param Date $end
	 * @return bool
	 */
	protected function SpansMidnight(Date $start, Date $end)
	{
		return !$start->DateEquals($end) && !$end->IsMidnight();
	}

	/**
	 * @param Date $layoutDate
	 * @param bool $hideBlockedPeriods
	 * @return array|SchedulePeriod[]
	 */
	public function GetLayout(Date $layoutDate, $hideBlockedPeriods = false)
	{
		if ($this->usingDailyLayouts)
		{
			return $this->GetLayoutDaily($layoutDate, $hideBlockedPeriods);
		}
		$targetTimezone = $this->targetTimezone;
		$layoutDate = $layoutDate->ToTimezone($targetTimezone);

		$cachedValues = $this->GetCachedValuesForDate($layoutDate);
		if (!empty($cachedValues))
		{
			return $cachedValues;
		}

		$list = new PeriodList();

		$periods = $this->getPeriods($layoutDate);

		if (count($periods) <= 0)
		{
			throw new Exception(sprintf('No periods defined for date %s', $layoutDate));
		}

		$layoutTimezone = $periods[0]->Timezone();
		$workingDate = Date::Create($layoutDate->Year(), $layoutDate->Month(), $layoutDate->Day(), 0, 0, 0,
									$layoutTimezone);
		$midnight = $layoutDate->GetDate();

		/* @var $period LayoutPeriod */
		foreach ($periods as $period)
		{
			if ($hideBlockedPeriods && !$period->IsReservable())
			{
				continue;
			}
			$start = $period->Start;
			$end = $period->End;
			$periodType = $period->PeriodTypeClass();
			$label = $period->Label;
			$labelEnd = null;

			// convert to target timezone
			$periodStart = $workingDate->SetTime($start)->ToTimezone($targetTimezone);
			$periodEnd = $workingDate->SetTime($end, true)->ToTimezone($targetTimezone);

			if ($periodEnd->LessThan($periodStart))
			{
				$periodEnd = $periodEnd->AddDays(1);
			}

			$startTime = $periodStart->GetTime();
			$endTime = $periodEnd->GetTime();

			if ($this->BothDatesAreOff($periodStart, $periodEnd, $layoutDate))
			{
				$periodStart = $layoutDate->SetTime($startTime);
				$periodEnd = $layoutDate->SetTime($endTime, true);
			}

			if ($this->SpansMidnight($periodStart, $periodEnd, $layoutDate))
			{
				if ($periodStart->LessThan($midnight))
				{
					// add compensating period at end
					$start = $layoutDate->SetTime($startTime);
					$end = $periodEnd->AddDays(1);
					$list->Add($this->BuildPeriod($periodType, $start, $end, $label, $labelEnd));
				}
				else
				{
					// add compensating period at start
					$start = $periodStart->AddDays(-1);
					$end = $layoutDate->SetTime($endTime, true);
					$list->Add($this->BuildPeriod($periodType, $start, $end, $label, $labelEnd));
				}
			}

			if (!$periodStart->IsMidnight() && $periodStart->LessThan($layoutDate) && $periodEnd->DateEquals($layoutDate) && $periodEnd->IsMidnight())
			{
				$periodStart = $periodStart->AddDays(1);
				$periodEnd = $periodEnd->AddDays(1);
			}

			$list->Add($this->BuildPeriod($periodType, $periodStart, $periodEnd, $label, $labelEnd));
		}

		$layout = $list->GetItems();
		$this->SortItems($layout);
		$this->AddCached($layout, $workingDate);

		return $layout;
	}

	private function GetLayoutDaily(Date $requestedDate, $hideBlockedPeriods = false)
	{
		if ($requestedDate->Timezone() != $this->targetTimezone)
		{
			throw new Exception('Target timezone and requested timezone do not match');
		}

		$cachedValues = $this->GetCachedValuesForDate($requestedDate);
		if (!empty($cachedValues))
		{
			return $cachedValues;
		}

		// check cache
		$baseDateInLayoutTz = Date::Create($requestedDate->Year(), $requestedDate->Month(), $requestedDate->Day(),
										   0, 0, 0, $this->layoutTimezone);


		$list = new PeriodList();
		$this->AddDailyPeriods($requestedDate->Weekday(), $baseDateInLayoutTz, $requestedDate, $list, $hideBlockedPeriods);

		if ($this->layoutTimezone != $this->targetTimezone)
		{
			$requestedDateInTargetTz = $requestedDate->ToTimezone($this->layoutTimezone);

			$adjustment = 0;
			if ($requestedDateInTargetTz->Format('YmdH') < $requestedDate->Format('YmdH'))
			{
				$adjustment = -1;
			}
			else
			{
				if ($requestedDateInTargetTz->Format('YmdH') > $requestedDate->Format('YmdH'))
				{
					$adjustment = 1;
				}
			}

			if ($adjustment != 0)
			{
				$adjustedDate = $requestedDate->AddDays($adjustment);
				$baseDateInLayoutTz = $baseDateInLayoutTz->AddDays($adjustment);
				$this->AddDailyPeriods($adjustedDate->Weekday(), $baseDateInLayoutTz, $requestedDate, $list);
			}
		}
		$layout = $list->GetItems();
		$this->SortItems($layout);
		$this->AddCached($layout, $requestedDate);
		return $layout;
	}

	/**
	 * @param int $day
	 * @param Date $baseDateInLayoutTz
	 * @param Date $requestedDate
	 * @param PeriodList $list
	 * @param bool $hideBlockedPeriods
	 */
	private function AddDailyPeriods($day, $baseDateInLayoutTz, $requestedDate, $list, $hideBlockedPeriods = false)
	{
		$periods = $this->_periods[$day];
		/** @var $period LayoutPeriod */
		foreach ($periods as $period)
		{
			if ($hideBlockedPeriods && !$period->IsReservable())
			{
				continue;
			}
			$begin = $baseDateInLayoutTz->SetTime($period->Start)->ToTimezone($this->targetTimezone);
			$end = $baseDateInLayoutTz->SetTime($period->End, true)->ToTimezone($this->targetTimezone);
			// only add this period if it occurs on the requested date
			if ($begin->DateEquals($requestedDate) || ($end->DateEquals($requestedDate) && !$end->IsMidnight()))
			{
				$built = $this->BuildPeriod($period->PeriodTypeClass(), $begin, $end, $period->Label);
				$list->Add($built);
			}
		}
	}

	/**
	 * @param array|SchedulePeriod[] $layout
	 * @param Date $date
	 */
	private function AddCached($layout, $date)
	{
		$this->cached = true;
		$this->cachedPeriods[$date->Format('Ymd')] = $layout;
	}

	/**
	 * @param Date $date
	 * @return array|SchedulePeriod[]
	 */
	private function GetCachedValuesForDate($date)
	{
		$key = $date->Format('Ymd');
		if (array_key_exists($date->Format('Ymd'), $this->cachedPeriods))
		{
			return $this->cachedPeriods[$key];
		}
		return null;
	}

	private function BothDatesAreOff(Date $start, Date $end, Date $layoutDate)
	{
		return !$start->DateEquals($layoutDate) && !$end->DateEquals($layoutDate);
	}

	private function BuildPeriod($periodType, Date $start, Date $end, $label, $labelEnd = null)
	{
		return new $periodType($start, $end, $label, $labelEnd);
	}

	protected function SortItems(&$items)
	{
		usort($items, array("ScheduleLayout", "SortBeginTimes"));
	}

	public function Timezone()
	{
		return $this->targetTimezone;
	}

	protected function AddPeriod(SchedulePeriod $period)
	{
		$this->_periods[] = $period;
	}

	/**
	 * @static
	 * @param SchedulePeriod|LayoutPeriod $period1
	 * @param SchedulePeriod|LayoutPeriod $period2
	 * @return int
	 */
	static function SortBeginTimes($period1, $period2)
	{
		return $period1->Compare($period2);
	}

	/**
	 * @param string $timezone
	 * @param string $reservableSlots
	 * @param string $blockedSlots
	 * @return ScheduleLayout
	 */
	public static function Parse($timezone, $reservableSlots, $blockedSlots)
	{
		$parser = new LayoutParser($timezone);
		$parser->AddReservable($reservableSlots);
		$parser->AddBlocked($blockedSlots);
		return $parser->GetLayout();
	}

	/**
	 * @param string $timezone
	 * @param string[]|array $reservableSlots
	 * @param string[]|array $blockedSlots
	 * @throws Exception
	 * @return ScheduleLayout
	 */
	public static function ParseDaily($timezone, $reservableSlots, $blockedSlots)
	{
		if (count($reservableSlots) != DayOfWeek::NumberOfDays || count($blockedSlots) != DayOfWeek::NumberOfDays)
		{
			throw new Exception(sprintf('LayoutParser ParseDaily missing slots. $reservableSlots=%s, $blockedSlots=%s',
										count($reservableSlots), count($blockedSlots)));
		}
		$parser = new LayoutParser($timezone);

		foreach (DayOfWeek::Days() as $day)
		{
			$parser->AddReservable($reservableSlots[$day], $day);
			$parser->AddBlocked($blockedSlots[$day], $day);
		}

		return $parser->GetLayout();
	}

	/**
	 * @param Date $date
	 * @return SchedulePeriod period which occurs at this datetime. Includes start time, excludes end time
	 */
	public function GetPeriod(Date $date)
	{
		$timezone = $this->layoutTimezone;
		$tempDate = $date->ToTimezone($timezone);
		$periods = $this->getPeriods($tempDate);

		/** @var $period LayoutPeriod */
		foreach ($periods as $period)
		{
			$start = Date::Create($tempDate->Year(), $tempDate->Month(), $tempDate->Day(), $period->Start->Hour(),
								  $period->Start->Minute(), 0, $timezone);
			$end = Date::Create($tempDate->Year(), $tempDate->Month(), $tempDate->Day(), $period->End->Hour(),
								$period->End->Minute(), 0, $timezone);

			if ($end->LessThan($start) || $end->IsMidnight())
			{
				$end = $end->AddDays(1);
			}

			if ($start->Compare($date) <= 0 && $end->Compare($date) > 0)
			{
				return $this->BuildPeriod($period->PeriodTypeClass(), $start, $end, $period->Label);
			}
		}

		return null;
	}

	/**
	 * @return bool
	 */
	public function UsesDailyLayouts()
	{
		return $this->usingDailyLayouts;
	}

	private function getPeriods(Date $layoutDate)
	{
		if ($this->usingDailyLayouts)
		{
			$dayOfWeek = $layoutDate->Weekday();
			return $this->_periods[$dayOfWeek];
		}
		else
		{
			return $this->_periods;
		}
	}
}

class LayoutParser
{
	private $layout;
	private $timezone;

	public function __construct($timezone)
	{
		$this->layout = new ScheduleLayout($timezone);
		$this->timezone = $timezone;
	}

	public function AddReservable($reservableSlots, $dayOfWeek = null)
	{
		$cb = array($this, 'appendPeriod');
		$this->ParseSlots($reservableSlots, $dayOfWeek, $cb);
	}

	public function AddBlocked($blockedSlots, $dayOfWeek = null)
	{
		$cb = array($this, 'appendBlocked');

		$this->ParseSlots($blockedSlots, $dayOfWeek, $cb);
	}

	public function GetLayout()
	{
		return $this->layout;
	}

	private function appendPeriod($start, $end, $label, $dayOfWeek = null)
	{
		$this->layout->AppendPeriod(Time::Parse($start, $this->timezone),
									Time::Parse($end, $this->timezone),
									$label,
									$dayOfWeek);
	}

	private function appendBlocked($start, $end, $label, $dayOfWeek = null)
	{
		$this->layout->AppendBlockedPeriod(Time::Parse($start, $this->timezone),
										   Time::Parse($end, $this->timezone),
										   $label,
										   $dayOfWeek);
	}

	private function ParseSlots($allSlots, $dayOfWeek, $callback)
	{
		$lines = preg_split("/[\n]/", $allSlots, -1, PREG_SPLIT_NO_EMPTY);

		foreach ($lines as $slotLine)
		{
			$label = null;
			$parts = preg_split('/(\d?\d:\d\d\s*\-\s*\d?\d:\d\d)(.*)/', trim($slotLine), -1,
								PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
			$times = explode('-', $parts[0]);
			$start = trim($times[0]);
			$end = trim($times[1]);

			if (count($parts) > 1)
			{
				$label = trim($parts[1]);
			}

			call_user_func($callback, $start, $end, $label, $dayOfWeek);
		}
	}
}

class LayoutPeriod
{
	/**
	 * @var Time
	 */
	public $Start;

	/**
	 * @var Time
	 */
	public $End;

	/**
	 * @var PeriodTypes
	 */
	public $PeriodType;

	/**
	 * @var string
	 */
	public $Label;

	/**
	 * @return string
	 */
	public function PeriodTypeClass()
	{
		if ($this->PeriodType == PeriodTypes::RESERVABLE)
		{
			return 'SchedulePeriod';
		}

		return 'NonSchedulePeriod';
	}

	/**
	 * @return bool
	 */
	public function IsReservable()
	{
		return $this->PeriodType == PeriodTypes::RESERVABLE;
	}

	/**
	 * @return bool
	 */
	public function IsLabelled()
	{
		return !empty($this->Label);
	}

	/**
	 * @return string
	 */
	public function Timezone()
	{
		return $this->Start->Timezone();
	}

	public function __construct(Time $start, Time $end, $periodType = PeriodTypes::RESERVABLE, $label = null)
	{
		$this->Start = $start;
		$this->End = $end;
		$this->PeriodType = $periodType;
		$this->Label = $label;
	}

	/**
	 * Compares the starting times
	 */
	public function Compare(LayoutPeriod $other)
	{
		return $this->Start->Compare($other->Start);
	}
}

class PeriodList
{
	private $items = array();
	private $_addedStarts = array();
	private $_addedTimes = array();
	private $_addedEnds = array();

	public function Add(SchedulePeriod $period)
	{
		if ($this->AlreadyAdded($period->BeginDate(), $period->EndDate()))
		{
			return;
		}

		$this->items[] = $period;
	}

	public function GetItems()
	{
		return $this->items;
	}

	private function AlreadyAdded(Date $start, Date $end)
	{
		$startExists = false;
		$endExists = false;

		if (array_key_exists($start->Timestamp(), $this->_addedStarts))
		{
			$startExists = true;
		}

		if (array_key_exists($end->Timestamp(), $this->_addedEnds))
		{
			$endExists = true;
		}

		$this->_addedTimes[$start->Timestamp()] = true;
		$this->_addedEnds[$end->Timestamp()] = true;

		return $startExists || $endExists;
	}
}

class ReservationLayout extends ScheduleLayout implements IScheduleLayout
{
	protected function SpansMidnight(Date $start, Date $end)
	{
		return false;
	}
}

?>
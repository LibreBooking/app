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

interface ILayoutTimezone
{
    public function Timezone();
}

interface IScheduleLayout extends ILayoutTimezone
{
    /**
     * @param Date $layoutDate
     * @return SchedulePeriod[]|array of SchedulePeriod objects
     */
    public function GetLayout(Date $layoutDate);

    /**
     * @abstract
     * @param Date $date
     * @return SchedulePeriod period which occurs at this datetime. Includes start time, excludes end time
     */
    public function GetPeriod(Date $date);
}

interface ILayoutCreation extends ILayoutTimezone
{
    function AppendPeriod(Time $startTime, Time $endTime, $label = null, $labelEnd = null);

    function AppendBlockedPeriod(Time $startTime, Time $endTime, $label = null, $labelEnd = null);

    /**
     * @return LayoutPeriod[] array of LayoutPeriod
     */
    function GetSlots();
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
    private $_timezone;

    /**
     * @var bool
     */
    private $cached = false;

    private $cachedPeriods = array();

    /**
     * @param string $timezone target timezone of layout
     */
    public function __construct($timezone = null)
    {
        $this->_timezone = $timezone;
        if ($timezone == null)
        {
            $this->_timezone = Configuration::Instance()->GetKey(ConfigKeys::SERVER_TIMEZONE);
        }
    }

    /**
     * @return array|LayoutPeriod[]
     */
    public function GetSlots()
    {
        return $this->_periods;
    }

    /**
     * Appends a period to the schedule layout
     *
     * @param Time $startTime starting time of the schedule in specified timezone
     * @param Time $endTime ending time of the schedule in specified timezone
     * @param string $label optional label for the period
     * @param string $labelEnd optional end label for the period
     */
    public function AppendPeriod(Time $startTime, Time $endTime, $label = null, $labelEnd = null)
    {
        $this->AppendGenericPeriod($startTime, $endTime, PeriodTypes::RESERVABLE, $label, $labelEnd);
    }

    /**
     * Appends a period that is not reservable to the schedule layout
     *
     * @param Time $startTime starting time of the schedule in specified timezone
     * @param Time $endTime ending time of the schedule in specified timezone
     * @param string $label optional label for the period
     * @param string $labelEnd optional end label for the period
     */
    public function AppendBlockedPeriod(Time $startTime, Time $endTime, $label = null, $labelEnd = null)
    {
        $this->AppendGenericPeriod($startTime, $endTime, PeriodTypes::NONRESERVABLE, $label, $labelEnd);
    }

    protected function AppendGenericPeriod(Time $startTime, Time $endTime, $periodType, $label = null, $labelEnd = null)
    {
        $this->_periods[] = new LayoutPeriod($startTime, $endTime, $periodType, $label);
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
     * @return array|SchedulePeriod[]
     */
    public function GetLayout(Date $layoutDate)
    {
        $targetTimezone = $this->_timezone;
        $layoutDate = $layoutDate->ToTimezone($targetTimezone);

        $cachedValues = $this->GetCachedValuesForDate($layoutDate);
        if (!empty($cachedValues))
        {
            return $cachedValues;
        }

        $layoutTimezone = $this->_periods[0]->Start->Timezone();

        $workingDate = Date::Create($layoutDate->Year(), $layoutDate->Month(), $layoutDate->Day(), 0, 0, 0, $layoutTimezone);
        $midnight = $layoutDate->GetDate();

        $list = new PeriodList();

        /* @var $period LayoutPeriod */
        foreach ($this->_periods as $period)
        {
            $start = $period->Start;
            $end = $period->End;
            $periodType = $period->PeriodTypeClass();
            $label = $period->Label;
            $labelEnd = null;

            // convert to target timezone
            $periodStart = $workingDate->SetTime($start)->ToTimezone($targetTimezone);
            $periodEnd = $workingDate->SetTime($end)->ToTimezone($targetTimezone);

            if ($periodEnd->LessThan($periodStart))
            {
                $periodEnd = $periodEnd->AddDays(1);
            }

            $startTime = $periodStart->GetTime();
            $endTime = $periodEnd->GetTime();

            if ($this->BothDatesAreOff($periodStart, $periodEnd, $layoutDate))
            {
                $periodStart = $layoutDate->SetTime($startTime);
                $periodEnd = $layoutDate->SetTime($endTime);
            }

            if ($this->SpansMidnight($periodStart, $periodEnd))
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
                    $end = $layoutDate->SetTime($endTime);
                    $list->Add($this->BuildPeriod($periodType, $start, $end, $label, $labelEnd));
                }
            }

            $list->Add($this->BuildPeriod($periodType, $periodStart, $periodEnd, $label, $labelEnd));
        }

        $layout = $list->GetItems();
        $this->SortItems($layout);
        $this->AddCached($layout, $workingDate);

        return $layout;
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
        return $this->_timezone;
    }

    protected function AddPeriod(SchedulePeriod $period)
    {
        $this->_periods[] = $period;
    }

    /**
     * @static
     * @param SchedulePeriod $period1
     * @param SchedulePeriod $period2
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
     * @param Date $date
     * @return SchedulePeriod period which occurs at this datetime. Includes start time, excludes end time
     */
    public function GetPeriod(Date $date)
    {
        $tempDate = $date->ToTimezone($this->_timezone);

        /** @var $period LayoutPeriod */
        foreach ($this->_periods as $period)
        {
            $start = Date::Create($tempDate->Year(), $tempDate->Month(), $tempDate->Day(), $period->Start->Hour(), $period->Start->Minute(), 0, $this->_timezone);
            $end = Date::Create($tempDate->Year(), $tempDate->Month(), $tempDate->Day(), $period->End->Hour(), $period->End->Minute(), 0, $this->_timezone);

            if ($end->LessThan($start))
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

    public function AddReservable($reservableSlots)
    {
        $cb = array($this, 'appendPeriod');
        $this->ParseSlots($reservableSlots, $cb);
    }

    public function AddBlocked($blockedSlots)
    {
        $cb = array($this, 'appendBlocked');

        $this->ParseSlots($blockedSlots, $cb);
    }

    public function GetLayout()
    {
        return $this->layout;
    }

    private function appendPeriod(Time $start, Time $end, $label)
    {
        $this->layout->AppendPeriod(Time::Parse($start, $this->timezone), Time::Parse($end, $this->timezone), $label);
    }

    private function appendBlocked(Time $start, Time $end, $label)
    {
        $this->layout->AppendBlockedPeriod(Time::Parse($start, $this->timezone), Time::Parse($end, $this->timezone), $label);
    }

    private function ParseSlots($allSlots, $callback)
    {
        $lines = preg_split("/[\r\n]/", $allSlots, -1, PREG_SPLIT_NO_EMPTY);

        foreach ($lines as $slotLine)
        {
            $label = null;
            $parts = preg_split('/(\d?\d:\d\d\s*\-\s*\d?\d:\d\d)(.*)/', $slotLine, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
            $times = explode('-', $parts[0]);
            $start = trim($times[0]);
            $end = trim($times[1]);

            if (count($parts) > 1)
            {
                $label = trim($parts[1]);
            }

            call_user_func($callback, Time::Parse($start, $this->timezone), Time::Parse($end, $this->timezone), $label);
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

    public function __construct(Time $start, Time $end, $periodType = PeriodTypes::RESERVABLE, $label = null)
    {
        $this->Start = $start;
        $this->End = $end;
        $this->PeriodType = $periodType;
        $this->Label = $label;
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
            //echo "already added $period\n";
            return;
        }

        //echo "\nadding {$period->BeginDate()} - {$period->EndDate()}";
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
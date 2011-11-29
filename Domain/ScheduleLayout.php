<?php
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
	private $_periods = array();
	private $_timezone;
	
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
	 * @return array[]SchedulePeriod
	 */
	public function GetLayout(Date $layoutDate)
	{		
		$targetTimezone = $this->_timezone;
		$layoutTimezone = $this->_periods[0]->Start->Timezone();
		
		$layoutDate = $layoutDate->ToTimezone($targetTimezone);
		
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
			$labelEnd = null;//$period['labelEnd'];
			
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
					//echo "\ncompensating end";
					$start = $layoutDate->SetTime($startTime);
					$end = $periodEnd->AddDays(1);
					$list->Add($this->Add($periodType, $start, $end, $label, $labelEnd));
				}
				else 
				{
					// add compensating period at start	
					//echo "\ncompensating start";
					$start = $periodStart->AddDays(-1);
					$end = $layoutDate->SetTime($endTime);
					$list->Add($this->Add($periodType, $start, $end, $label, $labelEnd));
				}
			}
			
			$list->Add($this->Add($periodType, $periodStart, $periodEnd, $label, $labelEnd));
		}
			
//		echo "printing";
//		print_r($layout);
//		die('printed');
		
		$layout = $list->GetItems();
		//echo "number " . count($layout) . " \n";
		$this->SortItems($layout);
		
//		foreach ($layout as $item)
//		{
//			echo "$item<br/>";
//		}
		return $layout;	
	}
	
	private function BothDatesAreOff(Date $start, Date $end, Date $layoutDate)
	{
		return !$start->DateEquals($layoutDate) && !$end->DateEquals($layoutDate);
	}
	
	private function Add($periodType, Date $start, Date $end, $label, $labelEnd)
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

	private function appendBlocked (Time $start, Time $end, $label)
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

/**
 * This class may not be needed
 *
 */
class DatabaseScheduleLayout implements IScheduleLayout
{
	private $_baseLayout;
	
	public function __construct(IScheduleLayout $layout)
	{
		$this->_baseLayout = $layout;
	}
	
	public function GetLayout(Date $layoutDate)
	{
		$layout = $this->_baseLayout->GetLayout($layoutDate);
		
		$this->AddBeginningPeriod($layout);
		$this->AddEndingPeriod($layout);
		
		for ($i = 0; $i < count($layout); $i++)
		{
			$layout[$i] = $layout[$i]->ToUtc();
		}
		
		return $layout;
	}
	
	private function AddBeginningPeriod(&$layout)
	{
		$midnight = new Time(0, 0);
		if ($layout[0]->Begin()->Compare($midnight) != 0)
		{
			array_unshift($layout, new NonSchedulePeriod($midnight, $layout[0]->Begin()));
		}
	}
	
	private function AddEndingPeriod(&$layout)
	{
		$midnight = new Time(0, 0);
		if ($layout[count($layout)-1]->End()->Compare($midnight) != 0)
		{
			$layout[] = new NonSchedulePeriod($layout[count($layout)-1]->End(), $midnight);
		}
	}
	
	public function Timezone()
	{
		return "UTC";
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
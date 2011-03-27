<?php
interface IScheduleLayout
{
	/**
	 * @return SchedulePeriod[] array of SchedulePeriod objects
	 */
	public function GetLayout(Date $layoutDate);
	
	public function Timezone();
}

class ScheduleLayout implements IScheduleLayout
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
		$this->AppendGenericPeriod($startTime, $endTime, $label, $labelEnd, 'SchedulePeriod');		
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
		$this->AppendGenericPeriod($startTime, $endTime, $label, $labelEnd, 'NonSchedulePeriod');
	}
	
	protected function AppendGenericPeriod(Time $startTime, Time $endTime, $label = null, $labelEnd = null, $periodType)
	{
		$this->_periods[] = array('start' => $startTime, 'end' => $endTime, 'label' => $label, 'labelEnd' => $labelEnd, 'periodType' => $periodType);		
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
		if ($layoutDate->Timezone() != $this->_timezone)
		{
			//throw new Exception("Cannot get layout. Date timezone {$layoutDate->Timezone()} does not equal target timezone {$this->_timezone}");
		}
		
		$targetTimezone = $this->_timezone;
		$layoutTimezone = $this->_periods[0]['start']->Timezone();
		
		$layoutDate = $layoutDate->ToTimezone($targetTimezone);
		
		$workingDate = Date::Create($layoutDate->Year(), $layoutDate->Month(), $layoutDate->Day(), 0, 0, 0, $layoutTimezone);
		$midnight = $layoutDate->GetDate();
		$midnightTomorrow = $midnight->AddDays(1);
		
		$list = new PeriodList();
		$layout = array();
		$adjusted = false;	
		foreach ($this->_periods as $period)
		{
			$start = $period['start'];
			$end = $period['end'];
			$periodType = $period['periodType'];
			$label = $period['label'];
			$labelEnd = $period['labelEnd'];
			
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
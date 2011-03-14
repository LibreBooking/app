<?php
interface IScheduleLayout
{
	/**
	 * @return array of SchedulePeriod objects
	 */
	public function GetLayout(Date $layoutDate);
}

class ScheduleLayout implements IScheduleLayout
{
	private $_periods = array();
	private $_timezone;
	private $_addedTimes = array();
	
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
	 * @param Date $midnight
	 * @return bool
	 */
	protected function SpansMidnight(Date $start, Date $end, Date $midnight)
	{
		return !$end->Equals($midnight) && ($start->GreaterThan($end) || !$start->DateEquals($end));
	}

	/**
	 * @return array[]SchedulePeriod
	 */
	public function GetLayout(Date $layoutDate)
	{
		$targetTimezone = $this->_timezone;
		$layoutTimezone = $this->_periods[0]['start']->Timezone();
		
		$workingDate = $layoutDate->ToTimezone($layoutTimezone);
		$midnight = $workingDate->ToTimezone($targetTimezone)->GetDate();
		
		$layout = array();
		foreach ($this->_periods as $period)
		{
			$startTime = $period['start'];
			$endTime = $period['end'];
			$periodType = $period['periodType'];
			$label = $period['label'];
			$labelEnd = $period['labelEnd'];
			
			$periodStart = $workingDate->SetTime($startTime)->ToTimezone($targetTimezone);
			$periodEnd = $workingDate->SetTime($endTime)->ToTimezone($targetTimezone);
			
//			if ($this->AlreadyAdded($startTime))
//			{
//				return;
//			}
			if ($this->SpansMidnight($periodStart, $periodEnd, $midnight))
			{
				$layout[] = new $periodType($periodStart->GetDate(), $periodEnd, $label, $labelEnd);
				$layout[] = new $periodType($periodStart, $periodEnd->AddDays(1)->GetDate(), $label, $labelEnd);
			}
			else
			{
				$layout[] = new $periodType($periodStart, $periodEnd, $label, $labelEnd);
			}
		}
		
		$this->SortItems($layout);
		
		return $layout;	
	}
	
	public function Sort()
	{
		$this->SortItems($this->_periods);
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
	
	private function AlreadyAdded(Time $startTime)
	{
		if (array_key_exists($startTime->ToString(), $this->_addedTimes))
		{
			return true;
		}
		
		$this->_addedTimes[$startTime->ToString()] = true;
		
		return false;
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
}

class ReservationLayout extends ScheduleLayout implements IScheduleLayout
{
	protected function SpansMidnight(Time $start, Time $end, Time $midnight)
	{
		return false;
	}
}
?>
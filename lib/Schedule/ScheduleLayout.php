<?php
interface IScheduleLayout
{
	/**
	 * @return array of SchedulePeriod objects
	 */
	public function GetLayout();
}

class ScheduleLayout implements IScheduleLayout
{
	private $_periods = array();
	private $_timezone;
	
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
	 */
	public function AppendPeriod(Time $startTime, Time $endTime, $label = null)
	{
		$this->_periods[] = new SchedulePeriod($startTime, $endTime, $label);
	}
	
	/**
	 * Appends a period that is not reservable to the schedule layout
	 *
	 * @param Time $startTime starting time of the schedule in specified timezone
	 * @param Time $endTime ending time of the schedule in specified timezone
	 * @param string $label optional label for the period
	 */
	public function AppendBlockedPeriod(Time $startTime, Time $endTime, $label = null)
	{
		$this->_periods[] = new NonSchedulePeriod($startTime, $endTime, $label);
	}

	public function GetLayout()
	{
		$layout = $this->_periods;
		
		usort($layout, array("ScheduleLayout", "SortBeginTimes"));
		
		return $layout;	
	}
	
	public function Sort()
	{
		usort($this->_periods, array("ScheduleLayout", "SortBeginTimes"));
	}
	
	/**
	 * @param string $timezone
	 * @return ScheduleLayout
	 */
	public function ToTimezone($timezone)
	{
		$converted = new ScheduleLayout($timezone);
		foreach($this->_periods as $period)
		{
			$converted->AddPeriod($period->ToTimezone($timezone));
		}
		
		$converted->Sort();
		return $converted;
	}
	
	public function Timezone()
	{
		return $this->_timezone;
	}
	
	private function AddPeriod(SchedulePeriod $period)
	{
		$this->_periods[] = $period;
	}

	static function SortBeginTimes($period1, $period2)
	{
		return $period1->Begin()->Compare($period2->Begin());
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
	
	public function GetLayout()
	{
		$layout = $this->_baseLayout->GetLayout();
		
		$this->AddBeginningPeriod($layout);
		$this->AddEndingPeriod($layout);
		
		for ($i = 0; $i < count($layout); $i++)
		{
			$layout[$i] = $layout[$i]->ToGmt();
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
?>
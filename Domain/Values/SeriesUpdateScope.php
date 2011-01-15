<?php
class SeriesUpdateScope
{
	private function __construct()
	{}
	
	const ThisInstance = 'this';
	const FullSeries = 'full';
	const FutureInstances = 'future';
	
	public static function CreateStrategy($seriesUpdateScope)
	{
		switch ($seriesUpdateScope)
		{
			case SeriesUpdateScope::ThisInstance :
				return new SeriesUpdateScope_Instance();
				break;
			case SeriesUpdateScope::FullSeries :
				return new SeriesUpdateScope_Full();
				break;
			case SeriesUpdateScope::FutureInstances :
				return new SeriesUpdateScope_Future();
				break;
			default :
				throw new Exception('Unknown seriesUpdateScope requested');
		}
	}
}

interface ISeriesUpdateScope
{
	/**
	 * @param ExistingReservationSeries $series
	 * @return Reservation[]
	 */
	function Instances($series);
	
	/**
	 * @return bool
	 */
	function RequiresNewSeries();
	
	function GetScope();
	
	/**
	 * @param ExistingReservationSeries $series
	 */
	function EarliestDateToKeep($series);
}

abstract class SeriesUpdateScopeBase implements ISeriesUpdateScope
{
	/**
	 * @var ISeriesDistinction
	 */
	protected $series;
	
	/**
	 * @param ISeriesDistinction $reservationSeries
	 */
	protected function __construct()
	{
	}
	
	protected function AllInstancesGreaterThan($series, $compareDate)
	{
		$instances = array();
		
		foreach ($series->_Instances() as $instance)
		{
			if ($instance->StartDate()->Compare($compareDate) >= 0)
			{
				$instances[] = $instance;
			}
		}
		
		return $instances;
	}
}

class SeriesUpdateScope_Instance extends SeriesUpdateScopeBase
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function GetScope()
	{
		return SeriesUpdateScope::ThisInstance;
	}
	
	public function Instances($series)
	{
		return array($series->CurrentInstance());
	}
	
	public function RequiresNewSeries()
	{
		return true;
	}
	
	public function EarliestDateToKeep($series)
	{
		return $series->CurrentInstance()->StartDate();
	}
}

class SeriesUpdateScope_Full extends SeriesUpdateScopeBase
{
	public function __construct()
	{
		parent::__construct();
	} 
	
	public function GetScope()
	{
		return SeriesUpdateScope::FullSeries;
	}

	public function Instances($series)
	{
		return $this->AllInstancesGreaterThan($series, $this->EarliestDateToKeep($series));
	}
	
	public function EarliestDateToKeep($series)
	{
		return Date::Now();
	}
	
	public function RequiresNewSeries()
	{
		return false;
	}
}

class SeriesUpdateScope_Future extends SeriesUpdateScopeBase
{
	public function __construct()
	{
		parent::__construct();
	} 
	
	public function GetScope()
	{
		return SeriesUpdateScope::FutureInstances;
	}

	public function Instances($series)
	{
		return $this->AllInstancesGreaterThan($series, $this->EarliestDateToKeep($series));
	}
	
	public function EarliestDateToKeep($series)
	{
		return $series->CurrentInstance()->StartDate();
	}
	
	public function RequiresNewSeries()
	{
		return true;
	}
}
?>
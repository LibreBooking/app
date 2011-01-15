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
				return new NullSeriesUpdateScope();
		}
	}
}

interface ISeriesUpdateScope
{
	/**
	 * @return IRepeatOptions
	 */
	function RepeatOptions();
	
	/**
	 * @param ExistingReservationSeries $series
	 * @return Reservation[]
	 */
	function Instances($series);
	
	/**
	 * @return bool
	 */
	function RequiresNewSeries();
	
	/**
	 * @param ExistingReservationSeries $series
	 */
	function ApplyChanges($series);
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
}

class SeriesUpdateScope_Instance extends SeriesUpdateScopeBase
{
	public function __construct()
	{
		parent::__construct();
	} 
	
	public function RepeatOptions()
	{
		return new RepeatNone();
	}
	
	public function Instances($series)
	{
		
		return array($series->CurrentInstance());
	}
	
	public function RequiresNewSeries()
	{
		return true;
	}
	
	public function ApplyChanges($series)
	{
		return array();
	}
}

class SeriesUpdateScope_Full extends SeriesUpdateScopeBase
{
	public function __construct()
	{
		parent::__construct();
	} 
	
	public function RepeatOptions()
	{
		return $this->series->SeriesRepeatOptions();
	}
	
	public function Instances($series)
	{
		return $series->_Instances();
	}
	
	public function RequiresNewSeries()
	{
		return false;
	}
	
	public function ApplyChanges($series)
	{
		return array();
	}
}

class SeriesUpdateScope_Future extends SeriesUpdateScopeBase
{
	public function __construct()
	{
		parent::__construct();
	} 
	
	public function RepeatOptions()
	{
		return $this->series->SeriesRepeatOptions();
	}
	
	public function Instances($series)
	{
		$currentInstance = $series->CurrentInstance();
		$instances = array($currentInstance);
		
		foreach ($series->_Instances() as $instance)
		{
			if ($instance->StartDate()->GreaterThan($currentInstance->StartDate()))
			{
				$instances[] = $instance;
			}
		}
		
		return $instances;
	}
	
	/**
	 * @param ExistingReservationSeries $series
	 */
	public function ApplyChanges($series)
	{
		$currentInstance = $series->CurrentInstance();
		
		// old instances will not transfer
		foreach ($series->Instances() as $instance)
		{
			if ($instance->StartDate()->LessThan($currentInstance->StartDate()))
			{
				$series->RemoveInstance($instance);
			}
		}
	}
	
	public function RequiresNewSeries()
	{
		return true;
	}
}

class NullSeriesUpdateScope implements ISeriesUpdateScope
{
	public function RepeatOptions()
	{
		return new RepeatNone();
	}
	
	public function Instances($series)
	{
		return array();
	}
	
	public function RequiresNewSeries()
	{
		return false;
	}
	
	public function ApplyChanges($series)
	{
		return array();
	}
}
?>
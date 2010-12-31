<?php
class SeriesUpdateScope
{
	private function __construct()
	{}
	
	const ThisInstance = 'this';
	const FullSeries = 'full';
	const FutureInstances = 'future';
	
	public static function CreateStrategy($seriesUpdateScope, $reservationSeries)
	{
		switch ($seriesUpdateScope)
		{
			case SeriesUpdateScope::ThisInstance :
				return new SeriesUpdateScope_Instance($reservationSeries);
				break;
			case SeriesUpdateScope::FullSeries :
				return new SeriesUpdateScope_Full($reservationSeries);
				break;
			case SeriesUpdateScope::FutureInstances :
				return new SeriesUpdateScope_Future($reservationSeries);
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
	 * @return Reservation[]
	 */
	function Instances();
	
	/**
	 * @return bool
	 */
	function RequiresNewSeries();
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
	protected function __construct($reservationSeries)
	{
		$this->series = $reservationSeries;
	}
}

class SeriesUpdateScope_Instance extends SeriesUpdateScopeBase
{
	public function __construct($reservationSeries)
	{
		parent::__construct($reservationSeries);
	} 
	
	public function RepeatOptions()
	{
		return new RepeatNone();
	}
	
	public function Instances()
	{
		return array($this->series->CurrentInstance());
	}
	
	public function RequiresNewSeries()
	{
		return true;
	}
}

class SeriesUpdateScope_Full extends SeriesUpdateScopeBase
{
	public function __construct($reservationSeries)
	{
		parent::__construct($reservationSeries);
	} 
	
	public function RepeatOptions()
	{
		return $this->series->SeriesRepeatOptions();
	}
	
	public function Instances()
	{
		return $this->series->SeriesInstances();
	}
	
	public function RequiresNewSeries()
	{
		return false;
	}
}

class SeriesUpdateScope_Future extends SeriesUpdateScopeBase
{
	public function __construct($reservationSeries)
	{
		parent::__construct($reservationSeries);
	} 
	
	public function RepeatOptions()
	{
		return $this->series->SeriesRepeatOptions();
	}
	
	public function Instances()
	{
		return $this->series->SeriesInstances();
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
	
	public function Instances()
	{
		return array();
	}
	
	public function RequiresNewSeries()
	{
		return false;
	}
}
?>
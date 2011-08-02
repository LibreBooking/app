<?php
class ExistingReservationSeriesBuilder
{
	/**
	 * @var TestHelperExistingReservationSeries
	 */
	public $series;
	
	/**
	 * @var Reservation
	 */
	public $currentInstance;
	
	/**
	 * @var IRepeatOptions
	 */
	private $repeatOptions;
	
	private $instances;
	private $events;
	
	private $requiresNewSeries = false;
	
	public function __construct()
	{
		$series = new ExistingReservationSeries();
		
		$this->currentInstance = new Reservation($series, new DateRange(Date::Now(), Date::Now()));
		$this->repeatOptions = new RepeatNone();
		$this->instances = array();
		$this->events = array();
		
		$series->WithDescription('description');
		$series->WithOwner(1);
		$series->WithPrimaryResource(2);	
		$series->WithResource(3);
		$series->WithSchedule(4);
		$series->WithTitle('title');
		
		$this->series = $series;
	}
	
	/**
	 * @param Reservation $reservation
	 * @return ExistingReservationSeriesBuilder
	 */
	public function WithCurrentInstance($reservation)
	{
		$this->currentInstance = $reservation;
		
		return $this;
	}

	/**
	 * @return ExistingReservationSeriesBuilder
	 */
	public function WithRepeatOptions(IRepeatOptions $repeatOptions)
	{
		$this->repeatOptions = $repeatOptions;
		
		return $this;
	}

	/**
	 * @param Reservation $reservation
	 * @return ExistingReservationSeriesBuilder
	 */
	public function WithInstance($reservation)
	{
		$this->instances[] = $reservation;

		return $this;
	}

	/**
	 * @return ExistingReservationSeriesBuilder
	 */
	public function WithEvent($event)
	{
		$this->events[] = $event;

		return $this;
	}

	/**
	 * @return ExistingReservationSeriesBuilder
	 */
	public function WithRequiresNewSeries($requiresNewSeries)
	{
		$this->requiresNewSeries = $requiresNewSeries;

		return $this;
	}
	
	/**
	 * @return ExistingReservationSeries
	 */
	public function Build()
	{
		$this->series->WithCurrentInstance($this->currentInstance);
		$this->series->WithRepeatOptions($this->repeatOptions);
		
		foreach ($this->instances as $reservation)
		{
			$this->series->WithInstance($reservation);
		}
		
		foreach ($this->events as $event)
		{
			$this->series->AddEvent($event);
		}

		return $this->series;
	}
	
	/**
	 * @return TestHelperExistingReservationSeries
	 */
	public function BuildTestVersion()
	{
		$this->series = new TestHelperExistingReservationSeries();
		$this->Build();		
		$this->series->SetRequiresNewSeries($this->requiresNewSeries);
		
		return $this->series;
	}
}

class TestHelperExistingReservationSeries extends ExistingReservationSeries
{
	public $requiresNewSeries = false;
	
	public function AddEvent($event)
	{
		parent::AddEvent($event);
	}
	
	public function SetRequiresNewSeries($requiresNewSeries)
	{
		$this->requiresNewSeries = $requiresNewSeries;
	}
	
	public function RequiresNewSeries()
	{
		return $this->requiresNewSeries;
	}
	
	public function Instances()
	{
		return $this->instances;
	}
}
?>
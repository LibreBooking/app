<?php
class ExistingReservationSeriesBuilder
{
	/**
	 * @var ExistingReservationSeries
	 */
	private $series;
	
	/**
	 * @var Reservation
	 */
	private $currentInstance;
	
	/**
	 * @var IRepeatOptions
	 */
	private $repeatOptions;
	
	private $instances;
	
	public function __construct()
	{
		$series = new ExistingReservationSeries();
		
		$this->currentInstance = new Reservation($series, new DateRange(Date::Now(), Date::Now()));
		$this->repeatOptions = new RepeatNone();
		$this->instances = array();
		
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
	 * @return ExisitingReservationSeriesBuilder
	 */
	public function WithCurrentInstance($reservation)
	{
		$this->currentInstance = $reservation;
		
		return $this;
	}
	
	public function WithSeriesInstances($reservations)
	{
		foreach ($reservations as $reservation)
		{
			$this->series->AddInstance($reservation);
		}
	}
	
	public function WithRepeatOptions(IRepeatOptions $repeatOptions)
	{
		$this->repeatOptions = $repeatOptions;
		
		return $this;
	}
	
	public function WithInstance($reservation)
	{
		$this->instances[] = $reservation;
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
		
		return $this->series;
	}
}

class TestReservation extends Reservation
{
	public function __construct($referenceNumber, $reservationDate)
	{
		$this->SetReferenceNumber($referenceNumber);
		$this->SetReservationDate($reservationDate);
	}
}
?>
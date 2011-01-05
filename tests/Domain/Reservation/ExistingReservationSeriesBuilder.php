<?php
class ExistingReservationSeriesBuilder
{
	/**
	 * @var ExistingReservationSeries
	 */
	private $series;
	
	public function __construct()
	{
		$series = new ExistingReservationSeries();
		$series->WithCurrentInstance(new Reservation($series, new DateRange(Date::Now(), Date::Now())));
		$series->WithDescription('description');
		$series->WithOwner(1);
		$series->WithPrimaryResource(2);
		$series->WithRepeatOptions(new RepeatNone());
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
		$this->series->WithCurrentInstance($reservation);
		return $this;
	}
	
	/**
	 * @return ExistingReservationSeries
	 */
	public function Build()
	{
		return $this->series;
	}
}
?>
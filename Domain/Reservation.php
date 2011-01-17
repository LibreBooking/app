<?php
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class Reservation
{
	/**
	 * @var string
	 */
	protected $referenceNumber;
	
	/**
	 * @return string
	 */
	public function ReferenceNumber()
	{
		return $this->referenceNumber;
	}
	
	/**
	 * @var Date
	 */
	protected $startDate;
	
	/**
	 * @return Date
	 */
	public function StartDate()
	{
		return $this->startDate;
	}
	
	/**
	 * @var Date
	 */
	protected $endDate;
	
	/**
	 * @return Date
	 */
	public function EndDate()
	{
		return $this->endDate;
	}
	
	public function Duration()
	{
		return new DateRange($this->StartDate(), $this->EndDate());
	}
	
	protected $reservationId;
	
	public function ReservationId()
	{
		return $this->reservationId;
	}
	
	/**
	 * @var ReservationSeries
	 */
	public $series;
	
	public function __construct(ReservationSeries $reservationSeries, DateRange $reservationDate)
	{
		$this->series = $reservationSeries;
		
		$this->SetReferenceNumber(uniqid());
		$this->SetReservationDate($reservationDate);
	}
	
	public function SetReservationId($reservationId)
	{
		$this->reservationId = $reservationId;
	}
	
	public function SetReferenceNumber($referenceNumber)
	{
		$this->referenceNumber = $referenceNumber;
	}
	
	public function SetReservationDate(DateRange $reservationDate)
	{
		$this->startDate = $reservationDate->GetBegin();
		$this->endDate = $reservationDate->GetEnd();
	}
}

?>
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
	
	/**
	 * @return DateRange
	 */
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
	
	public function __construct(ReservationSeries $reservationSeries, DateRange $reservationDate, $reservationId = null, $referenceNumber = null)
	{
		$this->series = $reservationSeries;
		
		$this->SetReservationDate($reservationDate);
		$this->SetReferenceNumber($referenceNumber);
		
		if (!empty($reservationId))
		{
			$this->SetReservationId($reservationId);
		}
		
		if (empty($referenceNumber))
		{
			$this->SetReferenceNumber(uniqid());
		}
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
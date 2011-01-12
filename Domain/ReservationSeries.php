<?php
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class ReservationSeries
{
	/**
	 * @var int
	 */
	protected $_userId;

	/**
	 * @return int
	 */
	public function UserId()
	{
		return $this->_userId;
	}

	/**
	 * @var int
	 */
	protected $_resourceId;

	/**
	 * @return int
	 */
	public function ResourceId()
	{
		return $this->_resourceId;
	}
	
	/**
	 * @var int
	 */
	protected $_scheduleId;
	
	/**
	 * @return int
	 */
	public function ScheduleId()
	{
		return $this->_scheduleId;
	}

	/**
	 * @var string
	 */
	protected $_title;

	/**
	 * @return string
	 */
	public function Title()
	{
		return $this->_title;
	}

	/**
	 * @var string
	 */
	protected $_description;

	/**
	 * @return string
	 */
	public function Description()
	{
		return $this->_description;
	}
	
	protected $_repeatOptions;
	
	/**
	 * @return IRepeatOptions
	 */
	public function RepeatOptions()
	{
		return $this->_repeatOptions;
	}
	
	protected $_resources = array();
	
	/**
	 * @return int[]
	 */
	public function Resources()
	{
		return $this->_resources;
	}
	
	protected $instances = array();
	
	/**
	 * @return Reservation[]
	 */
	public function Instances()
	{
		return $this->instances;
	}
	
	/**
	 * @var Date
	 */
	protected $currentInstanceDate;
	
	protected function __construct()
	{
		$this->_repeatOptions = new RepeatNone();
	}
	
	/**
	 * @param int $userId
	 * @param int $resourceId
	 * @param int $scheduleId
	 * @param string $title
	 * @param string $description
	 * @param DateRange $reservationDate
	 * @param IRepeatOptions $repeatOptions
	 * @return ReservationSeries
	 */
	public static function Create(
								$userId, 
								$resourceId, 
								$scheduleId, 
								$title, 
								$description, 
								$reservationDate, 
								$repeatOptions)
	{
		
		$series = new ReservationSeries();
		$series->_userId = $userId;
		$series->_resourceId = $resourceId;
		$series->_scheduleId = $scheduleId;
		$series->_title = $title;
		$series->_description = $description;
		$series->UpdateDuration($reservationDate);
		$series->Repeats($repeatOptions);
		
		return $series;
	}

	/**
	 * @param DateRange $reservationDate
	 */
	protected function UpdateDuration(DateRange $reservationDate)
	{
		$this->currentInstanceDate = $reservationDate->GetBegin();
		$this->AddNewInstance($reservationDate);
	}
	
	/**
	 * @param IRepeatOptions $repeatOptions
	 */
	protected function Repeats(IRepeatOptions $repeatOptions)
	{
		$this->_repeatOptions = $repeatOptions;
		
		$dates = $repeatOptions->GetDates($this->CurrentInstance()->Duration());
		
		if (empty($dates))
		{
			return;
		}
		
		foreach ($dates as $date)
		{
			$this->AddNewInstance($date);
		}
	}
	
	protected function AddNewInstance(DateRange $reservationDate)
	{
		$this->AddInstance(new Reservation($this, $reservationDate));
	}
	
	protected function AddInstance(Reservation $reservation)
	{
		$this->instances[$reservation->StartDate()->Timestamp()] = $reservation;
	}
	
	/**
	 * @param int $resourceId
	 */
	public function AddResource($resourceId)
	{
		$this->_resources[] = $resourceId;
	}
	
	/**
	 * @return bool
	 */
	public function IsRecurring()
	{
		return $this->RepeatOptions()->RepeatType() != RepeatType::None;
	}
	
	/**
	 * @param Date $startDate
	 * @return Reservation
	 */
	public function GetInstance(Date $startDate)
	{
		return $this->instances[$startDate->Timestamp()];
	}
	
	/**
	 * @return Reservation
	 */
	public function CurrentInstance()
	{
		return $this->GetInstance($this->currentInstanceDate);
	}
}
?>
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
	
	public function __construct(ReservationSeries $reservationSeries, DateRange $reservationDate)
	{
		$this->referenceNumber = uniqid();
		$this->series = $reservationSeries;
		$this->startDate = $reservationDate->GetBegin();
		$this->endDate = $reservationDate->GetEnd();
	}
}

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
	
	protected $_repeatedDates = array();
	
	/**
	 * @return DateRange[]
	 */
	public function RepeatedDates()
	{
		return $this->_repeatedDates;
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
	private $currentInstanceDate;
	
	public function __construct()
	{
		$this->_repeatOptions = new NoRepetion();		
	}
	
	/**
	 * @param int $userId
	 * @param int $resourceId
	 * @param int $scheduleId
	 * @param string $title
	 * @param string $description
	 */
	public function Update($userId, $resourceId, $scheduleId, $title, $description)
	{
		$this->_userId = $userId;
		$this->_resourceId = $resourceId;
		$this->_scheduleId = $scheduleId;
		$this->_title = $title;
		$this->_description = $description;
	}

	/**
	 * @param DateRange $reservationDate
	 */
	public function UpdateDuration(DateRange $reservationDate)
	{
		$this->currentInstanceDate = $reservationDate->GetBegin();
		$this->AddInstance($reservationDate);
	}
	
	/**
	 * @param IRepeatOptions $repeatOptions
	 */
	public function Repeats(IRepeatOptions $repeatOptions)
	{
		$this->_repeatOptions = $repeatOptions;
		
		$dates = $repeatOptions->GetDates();
		foreach ($dates as $date)
		{
			$this->AddInstance($date);
		}
	}
	
	private function AddInstance(DateRange $reservationDate)
	{
		$this->instances[$reservationDate->GetBegin()->Timestamp()] = new Reservation($this, $reservationDate);
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
		return count($this->instances) > 1;
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

class ExistingReservation extends ReservationSeries
{
	private $_reservationId;
	private $_seriesId;
	
	/**
	 * @param string $referenceNumber
	 */
	public function SetReferenceNumber($referenceNumber)
	{
		$this->_referenceNumber = $referenceNumber;
	}
	
	public function SetReservationId($reservationId)
	{
		$this->_reservationId = $reservationId;
	}
	
	public function IsPartOfSeries($seriesId)
	{
		$this->_seriesId = $seriesId;
	}
}
?>
<?php
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class ReservationSeries
{
	/**
	 * @var int
	 */
	protected $seriesId;
	
	/**
	 * @return int
	 */
	public function SeriesId()
	{
		return $this->seriesId;
	}

	/**
	 * @param int $seriesId
	 */
	public function SetSeriesId($seriesId)
	{
		$this->seriesId = $seriesId;
	}
	
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
	private $currentInstanceKey;
	
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
		$this->AddNewCurrentInstance($reservationDate);
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
	
	protected function InstanceExistsOnDate(DateRange $reservationDate)
	{
		foreach ($this->instances as $instance)
		{
			if ($instance->StartDate()->DateEquals($reservationDate->GetBegin()))
			{
				return true;
			}
		}
		return false;
	}
	
	/**
	 * @return Reservation newly created instance
	 */
	protected function AddNewInstance(DateRange $reservationDate)
	{
		$newInstance = new Reservation($this, $reservationDate);
		$this->AddInstance($newInstance);
		
		return $newInstance;
	}
	
	protected function AddNewCurrentInstance(DateRange $reservationDate)
	{
		$currentInstance = new Reservation($this, $reservationDate);
		$this->AddInstance($currentInstance);
		$this->SetCurrentInstance($currentInstance);
	}
	
	protected function AddInstance(Reservation $reservation)
	{
		$key = $this->CreateInstanceKey($reservation);
		$this->instances[$key] = $reservation;
	}
	
	protected function CreateInstanceKey(Reservation $reservation)
	{
		return $this->GetNewKey($reservation);
	}
	
	protected function GetNewKey(Reservation $reservation)
	{
		return $reservation->ReferenceNumber();
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
	 * @param string $referenceNumber
	 * @return Reservation
	 */
	public function GetInstance($referenceNumber)
	{
		return $this->instances[$referenceNumber];
	}
	
	/**
	 * @return Reservation
	 */
	public function CurrentInstance()
	{ 
		$instance = $this->GetInstance($this->GetCurrentKey());
		if (!isset($instance))
		{
			throw new Exception("Current instance not found. Missing Reservation key {$this->GetCurrentKey()}");
		}
		return $instance;
	}
	
	protected function SetCurrentInstance(Reservation $current)
	{
		$this->currentInstanceKey = $this->GetNewKey($current);
	}
	
	/**
	 * @return Date
	 */
	protected function GetCurrentKey()
	{
		return $this->currentInstanceKey;
	}
	
	protected function IsCurrent(Reservation $instance)
	{
		return $instance->ReferenceNumber() == $this->CurrentInstance()->ReferenceNumber();
	}
}
?>
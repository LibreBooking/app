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
	 * @var ReservationSeries
	 */
	public $series;
	
	public function __construct(ReservationSeries $reservationSeries, DateRange $reservationDate)
	{
		$this->referenceNumber = uniqid();
		$this->series = $reservationSeries;
		$this->startDate = $reservationDate->GetBegin();
		$this->endDate = $reservationDate->GetEnd();
	}
	
	public function SetReservationId($reservationId)
	{
		$this->reservationId = $reservationId;
	}
	
	public function SetReferenceNumber($referenceNumber)
	{
		$this->referenceNumber = $referenceNumber;
	}
}

interface ISeriesDistinction
{
	/**
	 * @return Reservation[]
	 */
	function SeriesInstances();
	
	/**
	 * @return IRepeatOptions
	 */
	function SeriesRepeatOptions();
	
	/**
	 * @return Reservation
	 */
	function CurrentInstance();
}

class ReservationSeries implements ISeriesDistinction
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
		return $this->seriesUpdateStrategy->RepeatOptions();
	}
	
	public function SeriesRepeatOptions()
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
		return $this->seriesUpdateStrategy->Instances();	
	}
	
	public function SeriesInstances()
	{
		return $this->instances;
	}
	
	/**
	 * @var Date
	 */
	protected $currentInstanceDate;
	
	/**
	 * @var ISeriesUpdateScope
	 */
	protected $seriesUpdateStrategy;
	
	public function __construct()
	{
		$this->_repeatOptions = new RepeatNone();
		$this->ApplyChangesTo(SeriesUpdateScope::FullSeries);	
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
		$this->AddNewInstance($reservationDate);
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
	 * @param SeriesUpdateScope $seriesUpdateScope
	 */
	public function ApplyChangesTo($seriesUpdateScope)
	{
		$this->seriesUpdateStrategy = SeriesUpdateScope::CreateStrategy($seriesUpdateScope, $this);
		//$this->seriesUpdateScope = $seriesUpdateScope;
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

class ExistingReservationSeries extends ReservationSeries
{
	/**
	 * @var int
	 */
	private $_seriesId;
	
	public function SeriesId()
	{
		return $this->_seriesId;
	}
	
	public function WithId($seriesId)
	{
		$this->_seriesId = $seriesId;
	}
	
	public function WithOwner($userId)
	{
		$this->_userId = $userId;
	}
	
	public function WithPrimaryResource($resourceId)
	{
		$this->_resourceId = $resourceId;
	}
	
	public function WithSchedule($scheduleId)
	{
		$this->_scheduleId = $scheduleId;
	}
	
	public function WithTitle($title)
	{
		$this->_title = $title;
	}
	
	public function WithDescription($description)
	{
		$this->_description = $description;
	}
	
	public function WithResource($resourceId)
	{
		$this->AddResource($resourceId);
	}
	
	public function WithRepeatOptions(IRepeatOptions $repeatOptions)
	{
		$this->_repeatOptions = $repeatOptions;
	}
	
	public function WithCurrentInstance(Reservation $reservation)
	{
		$this->AddInstance($reservation);
		$this->currentInstanceDate = $reservation->StartDate();
	}
	
	public function RequiresNewSeries()
	{
		return $this->seriesUpdateStrategy->RequiresNewSeries();
	}
}
?>
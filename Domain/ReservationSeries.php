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
	 * @var UserSession
	 */
	protected $_bookedBy;

	/**
	 * @return UserSession
	 */
	public function BookedBy()
	{
		return $this->_bookedBy;
	}

	/**
	 * @var BookableResource
	 */
	 protected $_resource;

	/**
	 * @return int
	 */
	public function ResourceId()
	{
		return $this->_resource->GetResourceId();
	}

	/**
	 * @return BookableResourceIRepeatOptions
	 */
	public function Resource()
	{
		return $this->_resource;
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

	/**
	 * @var IRepeatOptions
	 */
	protected $_repeatOptions;
	
	/**
	 * @return IRepeatOptions
	 */
	public function RepeatOptions()
	{
		return $this->_repeatOptions;
	}

	/**
	 * @var array|BookableResource[]
	 */
	protected $_additionalResources = array();
	
	/**
	 * @return array|BookableResource[]
	 */
	public function AdditionalResources()
	{
		return $this->_additionalResources;
	}
	
	/**
	 * @return int[]
	 */
	public function AllResourceIds()
	{
		$ids = array($this->ResourceId());
		foreach ($this->_additionalResources as $resource)
		{
			$ids[] = $resource->GetResourceId();
		}
		return $ids;
	}

	/**
	 * @return array|BookableResource[]
	 */
	public function AllResources()
	{
		return array_merge(array($this->Resource()), $this->AdditionalResources());
	}

	/**
	 * @var array|Reservation[]
	 */
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
	 * @param BookableResource $resource
	 * @param int $scheduleId
	 * @param string $title
	 * @param string $description
	 * @param DateRange $reservationDate
	 * @param IRepeatOptions $repeatOptions
	 * @param UserSession $bookedBy
	 * @return ReservationSeries
	 */
	public static function Create(
								$userId, 
								BookableResource $resource,
								$scheduleId, 
								$title, 
								$description, 
								$reservationDate, 
								$repeatOptions,
								UserSession $bookedBy)
	{
		
		$series = new ReservationSeries();
		$series->_userId = $userId;
		$series->_resource = $resource;
		$series->_scheduleId = $scheduleId;
		$series->_title = $title;
		$series->_description = $description;
		$series->_bookedBy = $bookedBy;
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

	/**
	 * @param DateRange $reservationDate
	 * @return bool
	 */
	protected function InstanceStartsOnDate(DateRange $reservationDate)
	{
		/** @var $instance Reservation */
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
	 * @param DateRange $reservationDate
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
	 * @param BookableResource $resource
	 */
	public function AddResource(BookableResource $resource)
	{
		$this->_additionalResources[] = $resource;
	}
	
	/**
	 * @return bool
	 */
	public function IsRecurring()
	{
		return $this->RepeatOptions()->RepeatType() != RepeatType::None;
	}

	/**
	 * @return int|ReservationStatus
	 */
	public function StatusId()
	{
		if ($this->_bookedBy->IsAdmin)
		{
			return ReservationStatus::Created;
		}

		foreach ($this->AllResources() as $resource)
		{
			if ($resource->GetRequiresApproval())
			{
				return ReservationStatus::Pending;
			}
		}

		return ReservationStatus::Created;
	}

	public function RequiresApproval()
	{
		return $this->StatusId() == ReservationStatus::Pending;
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

	/**
	 * @param int[] $participantIds
	 * @return void
	 */
	public function ChangeParticipants($participantIds)
	{
		/** @var Reservation $instance */
		foreach ($this->Instances() as $instance)
		{
			$instance->ChangeParticipants($participantIds);
		}
	}

	/**
	 * @param int[] $inviteeIds
	 * @return void
	 */
	public function ChangeInvitees($inviteeIds)
	{
		/** @var Reservation $instance */
		foreach ($this->Instances() as $instance)
		{
			$instance->ChangeInvitees($inviteeIds);
		}
	}

	/**
	 * @param Reservation $current
	 * @return void
	 */
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

	/**
	 * @param Reservation $instance
	 * @return bool
	 */
	protected function IsCurrent(Reservation $instance)
	{
		return $instance->ReferenceNumber() == $this->CurrentInstance()->ReferenceNumber();
	}

	/**
	 * @param int $resourceId
	 * @return bool
	 */
	public function ContainsResource($resourceId)
	{
		return in_array($resourceId, $this->AllResourceIds());
	}
}
?>
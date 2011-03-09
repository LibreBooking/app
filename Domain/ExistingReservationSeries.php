<?php
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class ExistingReservationSeries extends ReservationSeries
{
	/**
	 * @var int
	 */
	private $seriesId;
	
	/**
	 * @var ISeriesUpdateScope
	 */
	protected $seriesUpdateStrategy;
	
	protected $events = array();
	
	private $_deleteRequestIds = array();
	private $_updateRequestIds = array();
	
	public function __construct()
	{
		parent::__construct();
		$this->ApplyChangesTo(SeriesUpdateScope::FullSeries);
	}

	public function SeriesId()
	{
		return $this->seriesId;
	}
	
	public function SetSeriesId($seriesId)
	{
		$this->seriesId = $seriesId;
	}
	
	public function SeriesUpdateScope()
	{
		return $this->seriesUpdateStrategy->GetScope();
	}
	
	/**
	 * @internal
	 */
	public function WithId($seriesId)
	{
		$this->SetSeriesId($seriesId);
	}
	
	/**
	 * @internal
	 */
	public function WithOwner($userId)
	{
		$this->_userId = $userId;
	}
	
	/**
	 * @internal
	 */
	public function WithPrimaryResource($resourceId)
	{
		$this->_resourceId = $resourceId;
	}
	
	/**
	 * @internal
	 */
	public function WithSchedule($scheduleId)
	{
		$this->_scheduleId = $scheduleId;
	}
	
	/**
	 * @internal
	 */
	public function WithTitle($title)
	{
		$this->_title = $title;
	}
	
	/**
	 * @internal
	 */
	public function WithDescription($description)
	{
		$this->_description = $description;
	}
	
	/**
	 * @internal
	 */
	public function WithResource($resourceId)
	{
		$this->AddResource($resourceId);
	}
	
	/**
	 * @var IRepeatOptions
	 * @internal
	 */
	private $_originalRepeatOptions;
	
	/**
	 * @internal
	 */
	public function WithRepeatOptions(IRepeatOptions $repeatOptions)
	{
		$this->_originalRepeatOptions = $repeatOptions;
		$this->_repeatOptions = $repeatOptions;
	}

	/**
	 * @internal
	 */
	public function WithCurrentInstance(Reservation $reservation)
	{
		$this->AddInstance($reservation);
		$this->currentInstanceDate = $reservation->StartDate();
	}
	
	/**
	 * @internal
	 */
	public function WithInstance(Reservation $reservation)
	{
		$this->AddInstance($reservation);
	}
	
	/**
	 * @internal
	 */
	public function RemoveInstance(Reservation $reservation)
	{
		if ($reservation == $this->CurrentInstance())
		{
			return; // never remove the current instance
		}
		
		unset($this->instances[$reservation->StartDate()->Timestamp()]);
		
		$this->AddEvent(new InstanceRemovedEvent($reservation));
		$this->_deleteRequestIds[] = $reservation->ReservationId();
	}
	
	public function RequiresNewSeries()
	{
		return $this->seriesUpdateStrategy->RequiresNewSeries();
	}
	
	/**
	 * @param int $userId
	 * @param int $resourceId
	 * @param string $title
	 * @param string $description
	 */
	public function Update($userId, $resourceId, $title, $description)
	{
		$this->_userId = $userId;
		$this->_resourceId = $resourceId;
		$this->_title = $title;
		$this->_description = $description;
	}
	
	/**
	 * @param DateRange $reservationDate
	 */
	public function UpdateDuration(DateRange $reservationDate)
	{
		$currentDuration = $this->CurrentInstance()->Duration();
		
		if ($currentDuration->Equals($reservationDate))
		{
			return;
		}
		
		$currentBegin = $currentDuration->GetBegin();
		$currentEnd = $currentDuration->GetEnd();
		
		$startTimeAdjustment = $reservationDate->GetBegin()->GetDifference($currentBegin);
		$endTimeAdjustment = $reservationDate->GetEnd()->GetDifference($currentEnd);				
		
//		echo "start {$startTimeAdjustment->format('%R%H:%I')} \n";
//		echo "end {$endTimeAdjustment->format('%R%H:%I')} \n";
		
		foreach ($this->Instances() as $instance)
		{
			$newStart = $instance->StartDate()->ApplyDifference($startTimeAdjustment);
			$newEnd = $instance->EndDate()->ApplyDifference($endTimeAdjustment);
			
			$this->UpdateInstance($instance, new DateRange($newStart, $newEnd));
		}
	}
	
	/**
	 * @param SeriesUpdateScope $seriesUpdateScope
	 */
	public function ApplyChangesTo($seriesUpdateScope)
	{
		//if ($this->WasOrignallyNotRecurring())
		{
			$this->seriesUpdateStrategy = SeriesUpdateScope::CreateStrategy($seriesUpdateScope);
		}
		
		if ($this->seriesUpdateStrategy->RequiresNewSeries())
		{
			$this->AddEvent(new SeriesBranchedEvent($this));
			$this->Repeats($this->seriesUpdateStrategy->GetRepeatOptions($this));
		}
	}
	
	private function WasOrignallyNotRecurring()
	{
		// no idea if this is needed
		return $this->_originalRepeatOptions == null || !$this->_originalRepeatOptions->Equals(new RepeatNone());
	}
	
	/**
	 * @param IRepeatOptions $repeatOptions
	 */
	public function Repeats(IRepeatOptions $repeatOptions)
	{
		if ($this->seriesUpdateStrategy->CanChangeRepeatTo($this, $repeatOptions))
		{
			$this->_repeatOptions = $repeatOptions;
			
			foreach ($this->instances as $instance)
			{
				// delete all reservation instances which will be replaced
				if ($this->seriesUpdateStrategy->ShouldInstanceBeRemoved($this, $instance))
				{
					$this->RemoveInstance($instance);
				}
			}
			
			// create all future instances
			parent::Repeats($repeatOptions);
		}
	}
	
	public function Delete()
	{
		if (count($this->instances) > 1)
		{
			foreach ($this->Instances() as $instance)
			{
				$this->AddEvent(new InstanceRemovedEvent($instance));
			}
		}
		else
		{
			$this->AddEvent(new SeriesDeletedEvent($this));
		}
	}
	
	protected function AddNewInstance(DateRange $reservationDate)
	{
		if (!$this->InstanceExists($reservationDate))
		{
			parent::AddNewInstance($reservationDate);
			$this->AddEvent(new InstanceAddedEvent($this->GetInstance($reservationDate->GetBegin())));
		}
	}
	
	/**
	 * @internal
	 */
	public function UpdateInstance(Reservation $instance, DateRange $newDate)
	{
		//echo "Start: {$newDate->GetBegin()} End: {$newDate->GetEnd()} ts: {$newDate->GetBegin()->Timestamp()}\n";
		if ($instance == $this->CurrentInstance())
		{
			$this->currentInstanceDate = $newDate->GetBegin();
		}
		
		unset($this->instances[$this->CreateInstanceKey($instance)]);
		$instance->SetReservationDate($newDate);
		$this->AddInstance($instance);
		
		$this->AddEvent(new InstanceUpdatedEvent($instance));
		$this->_updateRequestIds[] = $instance->ReservationId();
	}
	
	public function GetEvents()
	{		
		return $this->events;
	}
	
	public function Instances()
	{
		return $this->seriesUpdateStrategy->Instances($this);
	}
	
	/**
	 * @internal
	 */
	public function _Instances()
	{
		return $this->instances;
	}
	
	protected function AddEvent($event)
	{
		$this->events[] = $event;
	}
	
	public function IsMarkedForDelete($reservationId)
	{
		return in_array($reservationId, $this->_deleteRequestIds);
	}
	
	public function IsMarkedForUpdate($reservationId)
	{
		return in_array($reservationId, $this->_updateRequestIds);
	}
}

class InstanceAddedEvent
{
	/**
     * @var Reservation
	 */
	private $instance;
	
	/**
	 * @return Reservation
	 */
	public function Instance()
	{
		return $this->instance;
	}
	
	public function __construct(Reservation $reservationInstance)
	{
		$this->instance = $reservationInstance;
	}
}

class InstanceRemovedEvent
{
	/**
     * @var Reservation
	 */
	private $instance;
	
	/**
	 * @return Reservation
	 */
	public function Instance()
	{
		return $this->instance;
	}
	
	public function __construct(Reservation $reservationInstance)
	{
		$this->instance = $reservationInstance;
	}
}

class InstanceUpdatedEvent
{
	/**
     * @var Reservation
	 */
	private $instance;
	
	/**
	 * @return Reservation
	 */
	public function Instance()
	{
		return $this->instance;
	}
	
	public function __construct(Reservation $reservationInstance)
	{
		$this->instance = $reservationInstance;
	}
}

class SeriesBranchedEvent
{
	private $series;
	
	public function __construct(ReservationSeries $series)
	{
		$this->series = $series;
	}
}

class SeriesDeletedEvent
{
	private $series;
	
	public function __construct(ReservationSeries $series)
	{
		$this->series = $series;
	}
}
?>
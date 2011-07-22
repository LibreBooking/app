<?php
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class ExistingReservationSeries extends ReservationSeries
{
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
		$this->SetCurrentInstance($reservation);
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
	public function WithParticipantId($participantId)
	{
		$this->_participantIds[] = $participantId;
	}

	public function WithInviteeId($inviteeId)
	{
		$this->_inviteeIds[] = $inviteeId;
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

		$instanceKey = $this->GetNewKey($reservation);
		unset($this->instances[$instanceKey]);

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

		Log::Debug('Updating duration for series %s', $this->SeriesId());

		$currentBegin = $currentDuration->GetBegin();
		$currentEnd = $currentDuration->GetEnd();

//		$startTimeAdjustment = $reservationDate->GetBegin()->GetDifference($currentBegin);
//		$endTimeAdjustment = $reservationDate->GetEnd()->GetDifference($currentEnd);

		$startTimeAdjustment = $currentBegin->GetDifference($reservationDate->GetBegin());
		$endTimeAdjustment = $currentEnd->GetDifference($reservationDate->GetEnd());

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
		$this->seriesUpdateStrategy = SeriesUpdateScope::CreateStrategy($seriesUpdateScope);
		
		if ($this->seriesUpdateStrategy->RequiresNewSeries())
		{
			$this->AddEvent(new SeriesBranchedEvent($this));
			$this->Repeats($this->seriesUpdateStrategy->GetRepeatOptions($this));
		}
	}

	/**
	 * @param IRepeatOptions $repeatOptions
	 */
	public function Repeats(IRepeatOptions $repeatOptions)
	{
		if ($this->seriesUpdateStrategy->CanChangeRepeatTo($this, $repeatOptions))
		{
			Log::Debug('Updating recurrence for series %s', $this->SeriesId());
			
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
		if (!$this->AppliesToAllInstances())
		{
			foreach ($this->Instances() as $instance)
			{
				Log::Debug("Removing instance %s from series %s", $instance->ReferenceNumber(), $this->SeriesId());
				
				$this->AddEvent(new InstanceRemovedEvent($instance));
			}
		}
		else
		{
			Log::Debug("Removing series %s", $this->SeriesId());
			
			$this->AddEvent(new SeriesDeletedEvent($this));
		}
	}

	private function AppliesToAllInstances()
	{
		return count($this->instances) == count($this->Instances());
	}

	protected function AddNewInstance(DateRange $reservationDate)
	{
		if (!$this->InstanceExistsOnDate($reservationDate))
		{
			Log::Debug('Adding instance for series %s on %s', $this->SeriesId(), $reservationDate);

			$newInstance = parent::AddNewInstance($reservationDate);
			$this->AddEvent(new InstanceAddedEvent($newInstance));
		}
	}

	/**
	 * @internal
	 */
	public function UpdateInstance(Reservation $instance, DateRange $newDate)
	{
		unset($this->instances[$this->CreateInstanceKey($instance)]);
		
		$instance->SetReservationDate($newDate);
		$this->AddInstance($instance);

		$this->RaiseInstanceUpdatedEvent($instance);

	}

	private function RaiseInstanceUpdatedEvent(Reservation $instance)
	{
		if (!$instance->IsNew())
		{
			$this->AddEvent(new InstanceUpdatedEvent($instance));
			$this->_updateRequestIds[] = $instance->ReservationId();
		}
	}

	public function GetEvents()
	{
		return array_unique($this->events);
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
			$this->RaiseInstanceUpdatedEvent($instance);
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
			$this->RaiseInstanceUpdatedEvent($instance);
		}
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
	
	public function __toString()
	{
        return sprintf("%s%s", get_class($this), $this->instance->ReferenceNumber());
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

	public function __toString()
	{
        return sprintf("%s%s", get_class($this), $this->instance->ReferenceNumber());
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

	public function __toString()
	{
        return sprintf("%s%s", get_class($this), $this->instance->ReferenceNumber());
    }
}

class SeriesBranchedEvent
{
	private $series;

	public function __construct(ReservationSeries $series)
	{
		$this->series = $series;
	}

	/**
	 * @return ExistingReservationSeries
	 */
	public function Series()
	{
		return $this->series;
	}

	public function __toString()
	{
        return sprintf("%s%s", get_class($this), $this->series->SeriesId());
    }
}

class SeriesDeletedEvent
{
	private $series;

	public function __construct(ExistingReservationSeries $series)
	{
		$this->series = $series;
	}

	/**
	 * @return ExistingReservationSeries
	 */
	public function Series()
	{
		return $this->series;
	}

	public function __toString()
	{
        return sprintf("%s%s", get_class($this), $this->series->SeriesId());
    }
}

?>
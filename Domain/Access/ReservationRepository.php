<?php
require_once(ROOT_DIR . 'Domain/ReservationFactory.php');

class ReservationRepository implements IReservationRepository
{
	const ALL_SCHEDULES = -1;

	public function GetWithin(Date $startDate, Date $endDate, $scheduleId = ReservationRepository::ALL_SCHEDULES)
	{
		$command = new GetReservationsCommand($startDate, $endDate, $scheduleId);

		$reservations = array();

		$reader = ServiceLocator::GetDatabase()->Query($command);

		while ($row = $reader->GetRow())
		{
			$reservations[] = ReservationFactory::CreateForSchedule($row);
		}

		$reader->Free();

		return $reservations;
	}
	
	public function LoadById($reservationId)
	{
		$database = ServiceLocator::GetDatabase();
		$getReservationCommand = new GetReservationByIdCommand($reservationId);

		$reader = ServiceLocator::GetDatabase()->Query($getReservationCommand);

		if ($reader->NumRows() != 1)
		{
			Log::Debug("ReservationRepository::LoadById() - Reservation not found. ID: $reservationId");
			return null;
		}
		
		$series = $this->BuildSeries($reader);	
		$this->AddInstances($series);
		$this->AddResources($series);
		$this->AddParticipants($series);

		return $series;
	}

	public function Add(ReservationSeries $reservationSeries)
	{
		$database = ServiceLocator::GetDatabase();

		$seriesId = $this->InsertSeries($reservationSeries);
		
		$reservationSeries->SetSeriesId($seriesId);
		
		$instances = $reservationSeries->Instances();
			
		foreach ($instances as $reservation)
		{
			$command = new InstanceAddedEventCommand($reservation, $reservationSeries);
			$command->Execute($database);
		}
	}

	public function Update(ExistingReservationSeries $reservationSeries)
	{
		$database = ServiceLocator::GetDatabase();
		
		if ($reservationSeries->RequiresNewSeries())
		{
			$currentId = $reservationSeries->SeriesId();
			$newSeriesId = $this->InsertSeries($reservationSeries);
			Log::Debug('Series branched from seriesId: %s to seriesId: %s',$currentId, $newSeriesId);
				
			$reservationSeries->SetSeriesId($newSeriesId);
				
			foreach ($reservationSeries->Instances() as $instance)
			{
				$updateReservationCommand = new UpdateReservationCommand(
					$instance->ReferenceNumber(),
					$newSeriesId,
					$instance->StartDate(),
					$instance->EndDate());

				$database->Execute($updateReservationCommand);
			}
		}
		else
		{
			Log::Debug('Updating existing series (seriesId: %s)', $reservationSeries->SeriesId());
				
			$updateSeries = new UpdateReservationSeriesCommand(
				$reservationSeries->SeriesId(),
				$reservationSeries->Title(),
				$reservationSeries->Description(),
				$reservationSeries->RepeatOptions()->RepeatType(),
				$reservationSeries->RepeatOptions()->ConfigurationString(),
				Date::Now()
				);

			$database->Execute($updateSeries);
		}

		$this->ExecuteEvents($reservationSeries);
	}


	/**
	 * @param ReservationSeries $reservationSeries
	 * @return int newly created series_id
	 */
	private function InsertSeries(ReservationSeries $reservationSeries)
	{
		$database = ServiceLocator::GetDatabase();

		$insertReservationSeries = new AddReservationSeriesCommand(
			Date::Now(),
			$reservationSeries->Title(),
			$reservationSeries->Description(),
			$reservationSeries->RepeatOptions()->RepeatType(),
			$reservationSeries->RepeatOptions()->ConfigurationString(),
			$reservationSeries->ScheduleId(),
			ReservationTypes::Reservation,
			ReservationStatus::Created,
			$reservationSeries->UserId()
		);
			
		$reservationSeriesId = $database->ExecuteInsert($insertReservationSeries);

		$insertReservationResource = new AddReservationResourceCommand(
			$reservationSeriesId,
			$reservationSeries->ResourceId(),
			ResourceLevel::Primary);
			
		$database->Execute($insertReservationResource);

		foreach($reservationSeries->Resources() as $resourceId)
		{
			$insertReservationResource = new AddReservationResourceCommand(
				$reservationSeriesId,
				$resourceId,
				ResourceLevel::Additional);
					
			$database->Execute($insertReservationResource);
		}

		return $reservationSeriesId;
	}

	
	public function Delete(ExistingReservationSeries $existingReservationSeries)
	{
		$this->ExecuteEvents($existingReservationSeries);
	}
	
	private function ExecuteEvents(ExistingReservationSeries $existingReservationSeries)
	{
		$database = ServiceLocator::GetDatabase();
		$events = $existingReservationSeries->GetEvents();
		
		foreach ($events as $event)
		{
			$command = $this->GetReservationCommand($event, $existingReservationSeries);
				
			if ($command != null)
			{
				$command->Execute($database);
			}
		}
	}

	/**
	 * @return EventCommand
	 */
	private function GetReservationCommand($event, $series)
	{
		return ReservationEventMapper::Instance()->Map($event, $series);
	}

	// LOAD BY ID HELPER FUNCTIONS
	
	private function BuildSeries($reader)
	{
		$series = new ExistingReservationSeries();
		if ($row = $reader->GetRow())
		{
			$repeatType = $row[ColumnNames::REPEAT_TYPE];
			$configurationString = $row[ColumnNames::REPEAT_OPTIONS];
				
			$repeatOptions = $this->BuildRepeatOptions($repeatType, $configurationString);
			$series->WithRepeatOptions($repeatOptions);

			$seriesId = $row[ColumnNames::SERIES_ID];
			$scheduleId = $row[ColumnNames::SCHEDULE_ID];
			$title = $row[ColumnNames::RESERVATION_TITLE];
			$description = $row[ColumnNames::RESERVATION_DESCRIPTION];
				
			$series->WithId($seriesId);
			$series->WithSchedule($scheduleId);
			$series->WithTitle($title);
			$series->WithDescription($description);

			$startDate = Date::FromDatabase($row[ColumnNames::RESERVATION_START]);
			$endDate = Date::FromDatabase($row[ColumnNames::RESERVATION_END]);
			$duration = new DateRange($startDate, $endDate);
				
			$instance = new Reservation(
				$series,
				$duration,
				$row[ColumnNames::RESERVATION_INSTANCE_ID],
				$row[ColumnNames::REFERENCE_NUMBER]);

			$series->WithCurrentInstance($instance);
		}
		$reader->Free();
		
		return $series;
	}
	
	private function AddInstances(ExistingReservationSeries $series)
	{
		// get all series instances
		$getInstancesCommand = new GetReservationSeriesInstances($series->SeriesId());
		$reader = ServiceLocator::GetDatabase()->Query($getInstancesCommand);
		while ($row = $reader->GetRow())
		{
			$start = Date::FromDatabase($row[ColumnNames::RESERVATION_START]);
			$end = Date::FromDatabase($row[ColumnNames::RESERVATION_END]);
				
			$reservation = new Reservation(
				$series,
				new DateRange($start, $end),
				$row[ColumnNames::RESERVATION_INSTANCE_ID],
				$row[ColumnNames::REFERENCE_NUMBER]);

			$series->WithInstance($reservation);
		}
		$reader->Free();
	}
	
	private function AddResources(ExistingReservationSeries $series)
	{
		// get all reservation resources
		$getResourcesCommand = new GetReservationResourcesCommand($series->SeriesId());
		$reader = ServiceLocator::GetDatabase()->Query($getResourcesCommand);
		while ($row = $reader->GetRow())
		{
			$resourceId = $row[ColumnNames::RESOURCE_ID];
			if ($row[ColumnNames::RESOURCE_LEVEL_ID] == ResourceLevel::Primary)
			{
				$series->WithPrimaryResource($resourceId);
			}
			else
			{
				$series->WithResource($resourceId);
			}
		}
		$reader->Free();
	}
	
	private function AddParticipants(ExistingReservationSeries $series)
	{
		$reservationId = $series->CurrentInstance()->ReservationId();
		
		$getParticipantsCommand = new GetReservationParticipantsCommand($reservationId);

		$reader = ServiceLocator::GetDatabase()->Query($getParticipantsCommand);
		while ($row = $reader->GetRow())
		{
			$userId = $row[ColumnNames::USER_ID];
			if ($row[ColumnNames::RESERVATION_USER_LEVEL] == ReservationUserLevel::OWNER)
			{
				$series->WithOwner($userId);
			}
			// TODO:  Add to participant list
		}
		$reader->Free();
	}

	private function BuildRepeatOptions($repeatType, $configurationString)
	{
		$configuration = RepeatConfiguration::Create($repeatType, $configurationString);
		$factory = new RepeatOptionsFactory();
		return $factory->Create($repeatType, $configuration->Interval, $configuration->TerminationDate, $configuration->Weekdays, $configuration->MonthlyType);
	}
	
	// LOAD BY ID HELPER FUNCTIONS END
}

class ReservationEventMapper
{
	private $buildMethods = array();
	private static $instance;

	private function __construct()
	{
		$this->buildMethods['SeriesDeletedEvent'] = 'BuildDeleteSeriesCommand';

		$this->buildMethods['InstanceAddedEvent'] = 'BuildAddReservationCommand';
		$this->buildMethods['InstanceRemovedEvent'] = 'BuildRemoveReservationCommand';
		$this->buildMethods['InstanceUpdatedEvent'] = 'BuildUpdateReservationCommand';
	}

	public static function Instance()
	{
		if (!isset(self::$instance))
		{
			self::$instance = new ReservationEventMapper();
		}

		return self::$instance;
	}

	/**
	 * @return EventCommand
	 */
	public function Map($event, ExistingReservationSeries $series)
	{
		$eventType = get_class($event);
		if (!isset($this->buildMethods[$eventType]))
		{
			Log::Debug("No command event mapper found for event $eventType");
			return null;
		}

		$method = $this->buildMethods[$eventType];
		return $this->$method($event, $series);
	}

	private function BuildDeleteSeriesCommand(SeriesDeletedEvent $event)
	{
		$series = $event->Series();
		
		return new EventCommand(
			new DeleteSeriesCommand($series->SeriesId())
		);
	}
	
	private function BuildAddReservationCommand(InstanceAddedEvent $event, ExistingReservationSeries $series)
	{
		$reservation = $event->Instance();
		
		return new InstanceAddedEventCommand($event->Instance(), $series);
	}
	
	private function BuildRemoveReservationCommand(InstanceRemovedEvent $event)
	{
		return new EventCommand(
			new RemoveReservationCommand($event->Instance()->ReferenceNumber())
		);
	}

	private function BuildUpdateReservationCommand(InstanceUpdatedEvent $event, ExistingReservationSeries $series)
	{
		$instance = $event->Instance();
		
		return new EventCommand(
			new UpdateReservationCommand(
				$instance->ReferenceNumber(),
				$series->SeriesId(),
				$instance->StartDate(),
				$instance->EndDate())
			);
	}	
}

class EventCommand
{
	/**
	 * @var ISqlCommand
	 */
	private $command;
	
 	public function __construct(ISqlCommand $command)
 	{
 		$this->command = $command;
 	}
 	
	public function Execute(Database $database)
	{
		$database->Execute($this->command);
	}
}

class InstanceAddedEventCommand extends EventCommand
{
	/**
	 * @var Reservation
	 */
	private $instance;
	
	/**
	 * @var ReservationSeries
	 */
	private $series;
	
	public function __construct(Reservation $instance, ReservationSeries $series)
	{
		$this->instance = $instance;
		$this->series = $series;
	}
	
	public function Execute(Database $database)
	{
		$insertReservation = new AddReservationCommand(
				$this->instance->StartDate(),
				$this->instance->EndDate(),
				$this->instance->ReferenceNumber(),
				$this->series->SeriesId());
				
		$reservationId = $database->ExecuteInsert($insertReservation);
			
		$insertReservationUser = new AddReservationUserCommand(
			$reservationId,
			$this->series->UserId(),
			ReservationUserLevel::OWNER);

		$database->Execute($insertReservationUser);
	}
}

interface IReservationRepository
{
	/**
	 * Returns all ScheduleReservations within the date range
	 *
	 * @param Date $startDate
	 * @param Date $endDate
	 * @param int $scheduleId (defaults to all schedules
	 * @return array of ScheduleReservation
	 */
	public function GetWithin(Date $startDate, Date $endDate, $scheduleId = ReservationRepository::ALL_SCHEDULES);

	/**
	 * Insert a new reservation
	 *
	 * @param ReservationSeries $reservation
	 * @return void
	 */
	public function Add(ReservationSeries $reservation);

	/**
	 * Return an existing reservation series
	 *
	 * @param int $reservationInstanceId
	 * @return ExistingReservationSeries or null if no reservation found
	 */
	public function LoadById($reservationInstanceId);

	/**
	 * Update an existing reservation
	 *
	 * @param ExistingReservationSeries $existingReservationSeries
	 * @return void
	 */
	public function Update(ExistingReservationSeries $existingReservationSeries);

	/**
	 * Delete all or part of an existing reservation
	 *
	 * @param ExistingReservationSeries $existingReservationSeries
	 * @return void
	 */
	public function Delete(ExistingReservationSeries $existingReservationSeries);
}
?>
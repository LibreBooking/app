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
	
	public function Add(ReservationSeries $reservationSeries)
	{
		$database = ServiceLocator::GetDatabase();
		
		$reservationSeriesId = $this->InsertSeries($reservationSeries);
		
		$instances = $reservationSeries->Instances();
			
		foreach($instances as $reservation)
		{
			$insertReservation = new AddReservationCommand(
								$reservation->StartDate(), 
								$reservation->EndDate(), 
								$reservation->ReferenceNumber(),
								$reservationSeriesId);
			
			$reservationId = $database->ExecuteInsert($insertReservation);
		}
	}

	public function Update(ExistingReservationSeries $reservationSeries)
	{
		$database = ServiceLocator::GetDatabase();
		$events = $reservationSeries->GetEvents();
		
		if ($reservationSeries->RequiresNewSeries())
		{
			$newSeriesId = $this->InsertSeries($reservationSeries);

			$instance = $reservationSeries->CurrentInstance();
			
			// move all instances
			$updateReservationCommand = new UpdateReservationCommand(
									$instance->ReferenceNumber(),
									$newSeriesId,
									$instance->StartDate(),
									$instance->EndDate());
			
			$database->Execute($updateReservationCommand);
		}
		else
		{
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
		
		// delete removed instances
		// add new instances
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
									ReservationStatus::Created
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
		
		$insertReservationUser = new AddReservationUserCommand(
										$reservationSeriesId, 
										$reservationSeries->UserId(), 
										ReservationUserLevel::OWNER);
		
		$database->Execute($insertReservationUser);

		return $reservationSeriesId;
	}
	
	public function LoadById($reservationId)
	{
		$getReservationCommand = new GetReservationByIdCommand($reservationId);
	
		$reader = ServiceLocator::GetDatabase()->Query($getReservationCommand);
		
		if ($reader->NumRows() != 1)
		{
			Log::Debug("LoadById() - Reservation not found. ID: %s", $reservationId);
			return null;
		}
		
		$ownerId = -1;
		$primaryResourceId = -1;
		
		$series = new ExistingReservationSeries();
		if ($row = $reader->GetRow())
		{	
			$seriesId = $row[ColumnNames::SERIES_ID];
			$scheduleId = $row[ColumnNames::SCHEDULE_ID];
			$title = $row[ColumnNames::RESERVATION_TITLE];
			$description = $row[ColumnNames::RESERVATION_DESCRIPTION];
			
			$repeatType = $row[ColumnNames::REPEAT_TYPE];
			$configurationString = $row[ColumnNames::REPEAT_OPTIONS];			
			
			$repeatOptions = $this->BuildRepeatOptions($repeatType, $configurationString);
			$series->WithRepeatOptions($repeatOptions);

			$series->WithId($seriesId);
			$series->WithSchedule($scheduleId);
			$series->WithTitle($title);
			$series->WithDescription($description);
		
			$startDate = Date::FromDatabase($row[ColumnNames::RESERVATION_START]);
			$endDate = Date::FromDatabase($row[ColumnNames::RESERVATION_END]);
			$duration = new DateRange($startDate, $endDate);		
			
			$instance = new Reservation($series, $duration);
			$instance->SetReservationId($row[ColumnNames::RESERVATION_INSTANCE_ID]);
			$instance->SetReferenceNumber($row[ColumnNames::REFERENCE_NUMBER]);	

			$series->WithCurrentInstance($instance);
		}
		
		// get all series instances
		$getInstancesCommand = new GetReservationSeriesInstances($seriesId);
		$reader = ServiceLocator::GetDatabase()->Query($getInstancesCommand);
		while ($row = $reader->GetRow())
		{
			$start = Date::FromDatabase($row[ColumnNames::RESERVATION_START]);
			$end = Date::FromDatabase($row[ColumnNames::RESERVATION_END]);
			$reservation = new Reservation($series, new DateRange($start, $end));
			$reservation->SetReferenceNumber($row[ColumnNames::REFERENCE_NUMBER]);
			$reservation->SetReservationId($row[ColumnNames::RESERVATION_INSTANCE_ID]);
			$series->WithInstance($reservation);
		}
		
		// get all reservation resources
		$getResourcesCommand = new GetReservationResourcesCommand($seriesId);
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

		return $series;
	}
	
	private function BuildRepeatOptions($repeatType, $configurationString)
	{
		$configuration = RepeatConfiguration::Create($repeatType, $configurationString);
		$factory = new RepeatOptionsFactory();
		return $factory->Create($repeatType, $configuration->Interval, $configuration->TerminationDate, $configuration->Weekdays, $configuration->MonthlyType);
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
	
}
?>
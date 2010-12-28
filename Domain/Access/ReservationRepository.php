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
	
	public function LoadById($reservationId)
	{
		$getReservationCommand = new GetReservationByIdCommand($reservationId);
		$getResourcesCommand = new GetReservationResourcesCommand($reservationId);
		$getParticipantsCommand = new GetReservationParticipantsCommand($reservationId);
		
		$reader = ServiceLocator::GetDatabase()->Query($getReservationCommand);
		
		if ($reader->NumRows() != 1)
		{
			return null;
		}
		
		$ownerId = -1;
		$primaryResourceId = -1;
		
		$reservation = new ExistingReservation();
		
		while ($row = $reader->GetRow())
		{	
			$startDate = Date::FromDatabase($row[ColumnNames::RESERVATION_START]);
			$endDate = Date::FromDatabase($row[ColumnNames::RESERVATION_END]);
			$scheduleId = $row[ColumnNames::SCHEDULE_ID];
			$title = $row[ColumnNames::RESERVATION_TITLE];
			$description = $row[ColumnNames::RESERVATION_DESCRIPTION];
			$repeatType = $row[ColumnNames::REPEAT_TYPE];
			$configurationString = $row[ColumnNames::REPEAT_OPTIONS];
			
			$duration = new DateRange($startDate, $endDate);
			$repeatOptions = $this->BuildRepeatOptions($repeatType, $configurationString, $duration);
			
			$reservation->SetReservationId($row[ColumnNames::RESERVATION_INSTANCE_ID]);
			$reservation->SetReferenceNumber($row[ColumnNames::REFERENCE_NUMBER]);
			$reservation->IsPartOfSeries($row[ColumnNames::SERIES_ID]);
			$reservation->UpdateDuration($duration);
			$reservation->Repeats($repeatOptions);
		}
		
		$reader = ServiceLocator::GetDatabase()->Query($getResourcesCommand);
		while ($row = $reader->GetRow())
		{
			$resourceId = $row[ColumnNames::RESOURCE_ID];
			if ($row[ColumnNames::RESOURCE_LEVEL_ID] == ResourceLevel::Primary)
			{
				$primaryResourceId = $resourceId;
			}
			else
			{
				$reservation->AddResource($resourceId);
			}
		}
		
		$reader = ServiceLocator::GetDatabase()->Query($getParticipantsCommand);
		while ($row = $reader->GetRow())
		{
			$userId = $row[ColumnNames::USER_ID];
			if ($row[ColumnNames::RESERVATION_USER_LEVEL] == ReservationUserLevel::OWNER)
			{
				$ownerId = $userId;
			}
			// TODO:  Add to participant list
		}
		
		$reservation->Update($ownerId, $primaryResourceId, $scheduleId, $title, $description);
		
		return $reservation;
	}
	
	public function Update(ReservationSeries $reservation)
	{
		throw new Exception('Not Implemented');
	}
	
	private function BuildRepeatOptions($repeatType, $configurationString, $duration)
	{
		$configuration = RepeatConfiguration::Create($repeatType, $configurationString);
		$factory = new RepeatOptionsFactory();
		return $factory->Create($repeatType, $configuration->Interval, $configuration->TerminationDate, $duration, $configuration->Weekdays, $configuration->MonthlyType);
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
	 * Return an existing reservation
	 * 
	 * @param int $reservationId
	 * @return Reservation or null if no reservation found
	 */
	public function LoadById($reservationId);
	
	/**
	 * Update an existing reservation
	 * 
	 * @param ReservationSeries $reservation
	 * @return void
	 */
	public function Update(ReservationSeries $reservation);
	
}
?>
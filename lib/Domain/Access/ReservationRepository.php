<?php
require_once(ROOT_DIR . 'lib/Domain/ReservationFactory.php');

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
	
	public function Add(Reservation $reservation)
	{
		$insertReservation = new AddReservationCommand(
										$reservation->StartDate()->ToUtc(), 
										$reservation->EndDate()->ToUtc(), 
										Date::Now()->ToUtc(), 
										$reservation->Title(), 
										$reservation->Description(),
										$reservation->RepeatOptions()->RepeatType(),
										$reservation->RepeatOptions()->ConfigurationString(),
										$reservation->ReferenceNumber(),
										$reservation->ScheduleId(),
										ReservationTypes::Reservation,
										ReservationStatus::Created);
		
		$reservationId = ServiceLocator::GetDatabase()->ExecuteInsert($insertReservation);
		
		$insertReservationResource = new AddReservationResourceCommand(
										$reservationId, 
										$reservation->ResourceId(),
										ResourceLevel::Primary);
					
		ServiceLocator::GetDatabase()->Execute($insertReservationResource);
		
		foreach($reservation->Resources() as $resourceId)
		{
			$insertReservationResource = new AddReservationResourceCommand(
										$reservationId, 
										$resourceId,
										ResourceLevel::Additional);
					
			ServiceLocator::GetDatabase()->Execute($insertReservationResource);
		}
		
		$insertReservationUser = new AddReservationUserCommand(
										$reservationId, 
										$reservation->UserId(), 
										ReservationUserLevel::OWNER);
		
		ServiceLocator::GetDatabase()->Execute($insertReservationUser);
		
		foreach($reservation->RepeatedDates() as $date)
		{
			$insertRepeatedDate = new AddReservationRepeatDateCommand(
									$reservationId, 
									$date->GetBegin(), 
									$date->GetEnd());
			ServiceLocator::GetDatabase()->Execute($insertRepeatedDate);
		}
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
	 * @param Reservation $reservation
	 * @return void
	 */
	public function Add(Reservation $reservation);
}
?>
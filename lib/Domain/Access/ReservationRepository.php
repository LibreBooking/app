<?php
class ReservationRepository implements IReservationRepository
{
	public function GetWithin(Date $startDate, Date $endDate, $scheduleId)
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
										$reservation->Description());
		
		$reservationId = ServiceLocator::GetDatabase()->ExecuteInsert($insertReservation);
		
		$insertReservationResource = new AddReservationResourceCommand($reservationId, $reservation->ResourceId());
		
		ServiceLocator::GetDatabase()->Execute($insertReservationResource);
		
		$insertReservationUser = new AddReservationUserCommand(
										$reservationId, 
										$reservation->UserId(), 
										ReservationUserLevel::OWNER);
		
		ServiceLocator::GetDatabase()->Execute($insertReservationUser);
	}
}

interface IReservationRepository
{
	/**
	 * Returns all ScheduleReservations within the date range
	 *
	 * @param Date $startDate
	 * @param Date $endDate
	 * @param int $scheduleId
	 * @return array of ScheduleReservation
	 */
	public function GetWithin(Date $startDate, Date $endDate, $scheduleId);

	public function Add(Reservation $reservation);
}
?>
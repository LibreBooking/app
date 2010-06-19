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
<?php
interface IReservationCoordinator
{
	function AddReservation(ScheduleReservation $reservation);
	
	/**
	 * @param string $timezone
	 * @param DateRange $validDates
	 * @return IReservationListing
	 */
	function Arrange($timezone, DateRange $validDates);
}
class ReservationCoordinator
{
	private $_reservations = array();
	
	public function AddReservation(ScheduleReservation $reservation)
	{
		$this->_reservations[] = $reservation;
	}
	
	public function Arrange($timezone, DateRange $validDates)
	{
		$listing = new ReservationListing($timezone);
		
		foreach ($this->_reservations as $reservation)
		{
			$start = $reservation->GetStartDate()->ToTimezone($timezone);
			$end = $reservation->GetEndDate()->ToTimezone($timezone);
			
			$splitUp = $this->Split($reservation, $start, $end);
			
			foreach ($splitUp as $item)
			{
				if ($validDates->ContainsRange(new DateRange($item['startDate'], $item['endDate'])))
				{
					$listing->Add($item['reservation']);
				}
			}
		}
		
		return $listing;
	}
	
	private function Split($reservation, $startDate, $endDate)
	{
		$reservationList = array();
		
		for ($date = $startDate; $date->DateCompare($endDate) <= 0; $date = $date->AddDays(1))
		{
			$start = $startDate;
			$end = $endDate;
			
			if (!$date->DateEquals($startDate))
			{
				$start = Date::Create($date->Year(), $date->Month(), $date->Day(), 0, 0, 0, $startDate->Timezone());
			}
			
			if (!$date->DateEquals($endDate))
			{
				$end = Date::Create($date->Year(), $date->Month(), $date->Day(), 0, 0, 0, $startDate->Timezone())->AddDays(1);
			}
			
			$reservationList[] = array ('startDate' => $start, 'endDate' => $end, 'reservation' => $reservation);
		}
		
		return $reservationList;
	}
}

interface IReservationCoordinatorFactory
{
	/**
	 * @return IReservationCoordinator
	 */
	function CreateCoordinator();
}

class ReservationCoordinatorFactory implements IReservationCoordinatorFactory
{
	public function CreateCoordinator()
	{
		return new ReservationCoordinator();
	}
}
?>
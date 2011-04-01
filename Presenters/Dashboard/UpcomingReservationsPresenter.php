<?php
require_once(ROOT_DIR . 'Controls/Dashboard/UpcomingReservations.php');

class UpcomingReservationsPresenter
{
	/**
	 * @var IUpcomingReservationsControl
	 */
	private $control;
	
	/**
	 * @var IReservationViewRepository
	 */
	private $repository;
	
	public function __construct(IUpcomingReservationsControl $control, IReservationViewRepository $repository)
	{
		$this->control = $control;
		$this->repository = $repository;
	}
	
	public function PageLoad()
	{
		$user = ServiceLocator::GetServer()->GetUserSession();
		$currentUserId = $user->UserId;
		$timezone = $user->Timezone;
		
		$now = Date::Now();
		$today = $now->ToTimezone($timezone)->GetDate();
		$dayOfWeek = $today->Weekday();
		
		$lastDate = $now->AddDays(13-$dayOfWeek-1);
		$reservations = $this->repository->GetReservationList($now, $lastDate, $currentUserId);
		$tomorrow = $today->AddDays(1);
		
		$startOfNextWeek = $today->AddDays(7-$dayOfWeek);
		
		$todays = array();
		$tomorrows = array();
		$thisWeeks = array();
		$nextWeeks = array();
		
		/* @var $reservation ReservationItemView */
		foreach ($reservations as $reservation)
		{
			$start = $reservation->StartDate->ToTimezone($timezone);
			
			if ($start->DateEquals($today))
			{
				$todays[] = $reservation;
			}
			else if ($start->DateEquals($tomorrow))
			{
				$tomorrows[] = $reservation;
			}
			else if ($start->LessThan($startOfNextWeek))
			{
				$thisWeeks[] = $reservation;
			}
			else 
			{
				$nextWeeks[] = $reservation;
			}
		}
		
		$this->control->SetTotal(count($reservations));
		$this->control->SetTimezone($timezone);
		
		$this->control->BindToday($todays);
		$this->control->BindTomorrow($tomorrows);
		$this->control->BindThisWeek($thisWeeks);
		$this->control->BindNextWeek($nextWeeks);
	}
}
?>
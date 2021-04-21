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

	/**
	 * @var int
	 */
	private $searchUserId = ReservationViewRepository::ALL_USERS;

	/**
	 * @var int
	 */
	private $searchUserLevel = ReservationUserLevel::ALL;

	public function __construct(IUpcomingReservationsControl $control, IReservationViewRepository $repository)
	{
		$this->control = $control;
		$this->repository = $repository;
	}

	public function SetSearchCriteria($userId, $userLevel)
	{
		$this->searchUserId = $userId;
		$this->searchUserLevel = $userLevel;
	}

	public function PageLoad()
	{
		$user = ServiceLocator::GetServer()->GetUserSession();
		$timezone = $user->Timezone;

		$now = Date::Now();
		$today = $now->ToTimezone($timezone)->GetDate();
		$dayOfWeek = $today->Weekday();

		$lastDate = $now->AddDays(13-$dayOfWeek-1);
        $consolidated = $this->repository->GetReservations($now, $lastDate, $this->searchUserId, $this->searchUserLevel, null, null, true);
		$tomorrow = $today->AddDays(1);

		$startOfNextWeek = $today->AddDays(7-$dayOfWeek);

		$todays = array();
		$tomorrows = array();
		$thisWeeks = array();
		$nextWeeks = array();

		/* @var $reservation ReservationItemView */
		foreach ($consolidated as $reservation)
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

		$this->control->SetTotal(count($consolidated));
		$this->control->SetTimezone($timezone);
		$this->control->SetUserId($user->UserId);

		$this->control->BindToday($todays);
		$this->control->BindTomorrow($tomorrows);
		$this->control->BindThisWeek($thisWeeks);
		$this->control->BindNextWeek($nextWeeks);
	}
}

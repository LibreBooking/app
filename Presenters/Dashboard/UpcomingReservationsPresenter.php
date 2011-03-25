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
		$now = Date::Now();
		$twoWeeksFromNow = $now->AddDays(14);
		$currentUserId = ServiceLocator::GetServer()->GetUserSession()->UserId;
		
		$reservations = $this->repository->GetReservationList($now, $twoWeeksFromNow, $currentUserId);
		
		$this->control->BindReservations($reservations);
	}
}
?>
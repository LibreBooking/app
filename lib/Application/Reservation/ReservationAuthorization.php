<?php
interface IReservationAuthorization
{
	/**
	 * @abstract
	 * @param UserSession $currentUser
	 * @return bool
	 */
	function CanChangeUsers(UserSession $currentUser);

	/**
	 * @abstract
	 * @param ReservationView $reservationView
	 * @param UserSession $currentUser
	 * @return bool
	 */
	function CanEdit(ReservationView $reservationView, UserSession $currentUser);

	/**
	 * @abstract
	 * @param ReservationView $reservationView
	 * @param UserSession $currentUser
	 * @return bool
	 */
	function CanApprove(ReservationView $reservationView, UserSession $currentUser);
}

class ReservationAuthorization implements IReservationAuthorization
{
	/**
	 * @var \IAuthorizationService
	 */
	private $authorizationService;
	
	public function __construct(IAuthorizationService $authorizationService)
	{
		$this->authorizationService = $authorizationService;
	}
	
	public function CanEdit(ReservationView $reservationView, UserSession $currentUser)
	{
		$ongoingReservation = Date::Now()->LessThan($reservationView->EndDate);

		if ($ongoingReservation)
		{
			if ($reservationView->OwnerId == $currentUser->UserId)
			{
				return true;
			}
			else
			{
				return $this->authorizationService->CanReserveFor($currentUser, $reservationView->OwnerId);
			}
		}
		
		return $currentUser->IsAdmin;	// only admins can edit reservations that have ended
	}

	function CanChangeUsers(UserSession $currentUser)
	{
		return $currentUser->IsAdmin || $this->authorizationService->CanReserveForOthers($currentUser);
	}

	function CanApprove(ReservationView $reservationView, UserSession $currentUser)
	{
		if (!$reservationView->RequiresApproval())
		{
			return false;
		}
		
		return $currentUser->IsAdmin || $this->authorizationService->CanApproveFor($currentUser, $reservationView->OwnerId);
	}
}
?>
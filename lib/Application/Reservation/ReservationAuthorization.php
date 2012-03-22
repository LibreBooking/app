<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

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
				$canReserveForUser = $this->authorizationService->CanReserveFor($currentUser, $reservationView->OwnerId);
                if ($canReserveForUser)
                {
                    return true;
                }

                foreach ($reservationView->Resources as $resource)
                {
                    if ($this->authorizationService->CanEditForResource($currentUser, $resource))
                    {
                        return true;
                    }
                }
			}
		}

		return $currentUser->IsAdmin;	// only admins can edit reservations that have ended
	}

	public function CanChangeUsers(UserSession $currentUser)
	{
		return $currentUser->IsAdmin || $this->authorizationService->CanReserveForOthers($currentUser);
	}

	public function CanApprove(ReservationView $reservationView, UserSession $currentUser)
	{
		if (!$reservationView->RequiresApproval())
		{
			return false;
		}

		if ($currentUser->IsAdmin)
        {
            return true;
        }

        $canReserveForUser = $this->authorizationService->CanApproveFor($currentUser, $reservationView->OwnerId);
        if ($canReserveForUser)
        {
            return true;
        }

        foreach ($reservationView->Resources as $resource)
        {
            if ($this->authorizationService->CanApproveForResource($currentUser, $resource))
            {
                return true;
            }
        }

        return false;
	}
}
?>
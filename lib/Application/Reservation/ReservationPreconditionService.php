<?php
/**
Copyright 2011-2014 Nick Korbel

This file is part of Booked SchedulerBooked SchedulereIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later versBooked SchedulerduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
alBooked SchedulercheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'Pages/NewReservationPage.php');

class NewReservationPreconditionService implements INewReservationPreconditionService
{
	public function CheckAll(INewReservationPage $page, UserSession $user)
	{
		$requestedScheduleId = $page->GetRequestedScheduleId();

		if (empty($requestedScheduleId))
		{
			$page->RedirectToError(ErrorMessages::MISSING_SCHEDULE);
			return;
		}
	}
}

class EditReservationPreconditionService
{
	public function CheckAll(IExistingReservationPage $page, UserSession $user, ReservationView $reservationView)
	{
		if (!$reservationView->IsDisplayable())
		{
			$page->RedirectToError(ErrorMessages::RESERVATION_NOT_FOUND);
			return;
		}
	}
}

abstract class ReservationPreconditionService implements IReservationPreconditionService
{
}
?>
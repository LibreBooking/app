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

require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/IReservationNotificationService.php');

class AddReservationNotificationService extends ReservationNotificationService
{
	public function __construct(IUserRepository $userRepo, IResourceRepository $resourceRepo)
	{
		$notifications = array();
		$notifications[] = new OwnerEmailCreatedNotification($userRepo);
		$notifications[] = new AdminEmailCreatedNotification($userRepo, $userRepo);
		$notifications[] = new ParticipantAddedEmailNotification($userRepo);
		$notifications[] = new InviteeAddedEmailNotification($userRepo);

		parent::__construct($notifications);
	}
}
?>
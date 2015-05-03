<?php
/**
Copyright 2011-2015 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/IReservationNotificationService.php');

class UpdateReservationNotificationService extends ReservationNotificationService
{
	public function __construct(IUserRepository $userRepo, IResourceRepository $resourceRepo, IAttributeRepository $attributeRepo)
	{
		$notifications = array();
		$notifications[] = new OwnerEmailUpdatedNotification($userRepo, $attributeRepo);
		$notifications[] = new AdminEmailUpdatedNotification($userRepo, $userRepo, $attributeRepo);
		$notifications[] = new AdminEmailApprovalNotification($userRepo,  $userRepo, $attributeRepo);
		$notifications[] = new ParticipantAddedEmailNotification($userRepo, $attributeRepo);
		$notifications[] = new InviteeAddedEmailNotification($userRepo, $attributeRepo);
		$notifications[] = new ParticipantUpdatedEmailNotification($userRepo, $attributeRepo);
		$notifications[] = new InviteeUpdatedEmailNotification($userRepo, $attributeRepo);

		parent::__construct($notifications);
	}
}
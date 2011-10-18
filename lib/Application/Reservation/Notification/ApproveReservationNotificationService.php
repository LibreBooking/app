<?php
require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/IReservationNotificationService.php');

class ApproveReservationNotificationService extends ReservationNotificationService
{
	public function __construct(IUserRepository $userRepo, IResourceRepository $resourceRepo)
	{
		$notifications = array();
//		$notifications[] = new OwnerEmailApprovedNotificaiton($userRepo, $resourceRepo);
//		$notifications[] = new ParticipantAddedEmailNotification($userRepo);
//		$notifications[] = new InviteeAddedEmailNotification($userRepo);

		parent::__construct($notifications);
	}
}

?>
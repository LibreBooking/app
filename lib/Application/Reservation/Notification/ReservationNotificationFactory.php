<?php
class ReservationNotificationFactory implements IReservationNotificationFactory
{
	public function Create($reservationAction)
	{
		if ($reservationAction == ReservationAction::Update)
		{
			return new UpdateReservationNotificationService();
		}

		$userRepo = new UserRepository();
		$resourceRepo = new ResourceRepository();
		
		$notifications[] = new OwnerEmailNotificaiton($userRepo, $resourceRepo);
		$notifications[] = new AdminEmailNotificaiton($userRepo, $resourceRepo);
		
		return new AddReservationNotificationService($notifications);
	}
}
?>
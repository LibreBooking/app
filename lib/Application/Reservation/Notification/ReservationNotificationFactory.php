<?php
class ReservationNotificationFactory implements IReservationNotificationFactory
{
	public function Create($reservationAction)
	{
		$userRepo = new UserRepository();
		$resourceRepo = new ResourceRepository();
		
		if ($reservationAction == ReservationAction::Update)
		{
			$notifications[] = new OwnerEmailUpdatedNotificaiton($userRepo, $resourceRepo);
			$notifications[] = new AdminEmailUpdatedNotificaiton($userRepo, $resourceRepo);
			
			return new UpdateReservationNotificationService($notifications);
		}
		else 
		{
			$notifications[] = new OwnerEmailCreatedNotificaiton($userRepo, $resourceRepo);
			$notifications[] = new AdminEmailCreatedNotificaiton($userRepo, $resourceRepo);
		
			return new AddReservationNotificationService($notifications);
		}
	}
}
?>
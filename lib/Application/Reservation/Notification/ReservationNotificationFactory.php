<?php
class ReservationNotificationFactory implements IReservationNotificationFactory
{
	public function Create($reservationAction)
	{
		$userRepo = new UserRepository();
		$resourceRepo = new ResourceRepository();
		
		if ($reservationAction == ReservationAction::Update)
		{
			return $this->CreateUpdateService($userRepo, $resourceRepo);
		}
		else if ($reservationAction == ReservationAction::Delete)
		{
			return $this->CreateDeleteService($userRepo, $resourceRepo);
		}
		else 
		{
			return $this->CreateAddService($userRepo, $resourceRepo);
		}
	}
	
	private function CreateAddService($userRepo, $resourceRepo)
	{
		$notifications = array();
		$notifications[] = new OwnerEmailCreatedNotificaiton($userRepo, $resourceRepo);
		$notifications[] = new AdminEmailCreatedNotification($userRepo, $resourceRepo);
		$notifications[] = new ParticipantAddedEmailNotification($userRepo);
		
		return new AddReservationNotificationService($notifications);
	}
	
	private function CreateDeleteService($userRepo, $resourceRepo)
	{
		$notifications = array();
		return new DeleteReservationNotificationService($notifications);
	}
	
	private function CreateUpdateService($userRepo, $resourceRepo)
	{
		$notifications = array();
		$notifications[] = new OwnerEmailUpdatedNotificaiton($userRepo, $resourceRepo);
		$notifications[] = new AdminEmailUpdatedNotification($userRepo, $resourceRepo);
			
		return new UpdateReservationNotificationService($notifications);
	}
}
?>
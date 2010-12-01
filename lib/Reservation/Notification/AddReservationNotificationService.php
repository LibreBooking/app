<?php
class AddReservationNotificationService implements IReservationNotificationService 
{
	/**
	 * @var IReservationNotification[]
	 */
	private $notifications;
	
	/**
	 * @param IReservationNotification[] $notifications
	 */
	public function __construct($notifications)
	{
		$this->notifications = $notifications;	
	}
	
	/**
	 * @see IReservationNotificationService::Notify()
	 */
	public function Notify($reservation)
	{
		foreach ($this->notifications as $notification)
		{
			try
			{
				Log::Debug("Calling notify on %s for reservation %s", get_class($notification), $reservation->ReferenceNumber());
				
				$notification->Notify($reservation);
			}
			catch(Exception $ex)
			{
				Log::Error("Error sending notification of type %s for reservation %s. Exception: %s", get_class($notification), $reservation->ReferenceNumber(), $ex);
			}
		}
	}
}
?>
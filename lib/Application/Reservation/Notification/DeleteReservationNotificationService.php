<?php
require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/IReservationNotificationService.php');

interface IDeleteReservationNotificationService extends IReservationNotificationService
{
	/**
	 * @param ExistingReservationSeries $reservationSeries
	 */
	//function Notify($reservationSeries);
}


class DeleteReservationNotificationService implements IDeleteReservationNotificationService
{
	private $notifications;
	
	public function __construct($notifications)
	{
		$this->notifications = $notifications;	
	}
	
	/**
	 * @param ExistingReservationSeries $reservationSeries
	 */
	public function Notify($reservationSeries)
	{
		$referenceNumber = $reservationSeries->CurrentInstance()->ReferenceNumber();
		
		foreach ($this->notifications as $notification)
		{
			try
			{
				Log::Debug("Calling notify on %s for reservation %s", get_class($notification), $referenceNumber);
				
				$notification->Notify($reservationSeries);
			}
			catch(Exception $ex)
			{
				Log::Error("Error sending notification of type %s for reservation %s. Exception: %s", get_class($notification), $referenceNumber, $ex);
			}
		}
	}
}
?>
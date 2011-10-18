<?php
require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/IReservationNotificationService.php');

class DeleteReservationNotificationService extends ReservationNotificationService
{
	public function __construct()
	{
		$notifications = array();
		parent::__construct($notifications);
	}
}
?>
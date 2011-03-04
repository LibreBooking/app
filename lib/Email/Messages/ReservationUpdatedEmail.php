<?php
require_once(ROOT_DIR . 'lib/Email/namespace.php');
require_once(ROOT_DIR . 'lib/Email/Messages/ReservationCreatedEmail.php');

class ReservationUpdatedEmail extends ReservationCreatedEmail
{
	public function __construct(User $reservationOwner, ExistingReservationSeries $reservationSeries, IResource $primaryResource)
	{
		parent::__construct($reservationOwner, $reservationSeries, $primaryResource);
	}
	
	public function Subject()
	{
		return $this->Translate('ReservationUpdatedSubject');
	}
}
?>
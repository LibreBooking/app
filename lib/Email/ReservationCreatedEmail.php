<?php
class ReservationCreatedEmail implements IEmailMessage
{
	private $email;
	
	/**
	 * @var User
	 */
	private $reservationOwner;
	
	/**
	 * @var Reservation
	 */
	private $reservation;
	
	/**
	 * @var IResource
	 */
	private $primaryResource;
	
	public function __construct(User $reservationOwner, Reservation $reservation, IResource $primaryResource)
	{
		$this->email = new SmartyEmail();
		$this->reservationOwner = $reservationOwner;
		$this->reservation = $reservation;
		$this->resource = $primaryResource;
	}
	
	private function Set($var, $value)
	{
		$this->email->assign($var, $value);
	}
	
	private function PopulateTemplate()
	{
		//$lang = $reservationOwner->Language();
		//$timezone = $reservationOwner->Timezone();
		$timezone = 'US/Central';
		
		$this->Set('StartDate', $this->reservation->StartDate()->ToTimezone($timezone));
		$this->Set('EndDate', $this->reservation->EndDate()->ToTimezone($timezone));
		
		$this->Set('Title', $this->reservation->Title());
		$this->Set('Description', $this->reservation->Description());
		
		$repeatDates = array();
		foreach ($this->reservation->RepeatedDates() as $repeated)
		{
			$repeatDates[] = $repeated->GetBegin()->ToTimezone($timezone);
		}
		$this->Set('RepeatDates', $repeatDates);
		$this->Set('ReservationUrl', "reservation.php?" . QueryStringKeys::REFERENCE_NUMBER . '=' . $this->reservation->ReferenceNumber());
	}
	
	public function Body()
	{
		$this->PopulateTemplate();
		return $this->email->fetch("en_us/ReservationCreated.tpl"); 
	}
}
?>
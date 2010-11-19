<?php

class ReservationCreatedEmail extends EmailMessage
{
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
	
	private $timezone;
	
	public function __construct(User $reservationOwner, Reservation $reservation, IResource $primaryResource)
	{
		parent::__construct($reservationOwner->Language());
		
		$this->reservationOwner = $reservationOwner;
		$this->reservation = $reservation;
		$this->resource = $primaryResource;
		$this->timezone = $reservationOwner->Timezone();
	}
	
	/**
	 * @see IEmailMessage::To()
	 */
	public function To()
	{
		$address = $this->reservationOwner->EmailAddress();
		$name = $this->reservationOwner->FullName();
		
		return array(new EmailAddress($address, $name));
	}
	
	/**
	 * @see IEmailMessage::Subject()
	 */
	public function Subject()
	{
		return $this->Translate('ReservationCreatedSubject');
	}
	
	/**
	 * @see IEmailMessage::Body()
	 */
	public function Body()
	{
		$this->PopulateTemplate();
		return $this->FetchTemplate("ReservationCreated.tpl"); 
	}
	
	private function PopulateTemplate()
	{	
		$this->Set('StartDate', $this->reservation->StartDate()->ToTimezone($this->timezone));
		$this->Set('EndDate', $this->reservation->EndDate()->ToTimezone($this->timezone));
		
		$this->Set('Title', $this->reservation->Title());
		$this->Set('Description', $this->reservation->Description());
		
		$repeatDates = array();
		foreach ($this->reservation->RepeatedDates() as $repeated)
		{
			$repeatDates[] = $repeated->GetBegin()->ToTimezone($this->timezone);
		}
		$this->Set('RepeatDates', $repeatDates);
		$this->Set('ReservationUrl', "reservation.php?" . QueryStringKeys::REFERENCE_NUMBER . '=' . $this->reservation->ReferenceNumber());
	}
}
?>
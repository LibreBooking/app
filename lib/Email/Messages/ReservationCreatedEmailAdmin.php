<?php
class ReservationCreatedEmailAdmin extends EmailMessage
{
	/**
	 * @var UserDto
	 */
	private $adminDto;
	
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
	private $resource;
	
	/**
	 * @param UserDto $adminDto
	 * @param User $reservationOwner
	 * @param Reservation $reservation
	 * @param IResource $primaryResource
	 */
	public function __construct($adminDto, User $reservationOwner, Reservation $reservation, IResource $primaryResource)
	{
		parent::__construct($adminDto->Language());
		
		$this->adminDto = $adminDto;
		$this->reservationOwner = $reservationOwner;
		$this->reservation = $reservation;
		$this->resource = $primaryResource;
		$this->timezone = $adminDto->Timezone();
	}
	
	/**
	 * @see IEmailMessage::To()
	 */
	public function To()
	{
		$address = $this->adminDto->EmailAddress();
		$name = $this->adminDto->FullName();
		
		return array(new EmailAddress($address, $name));
	}
	
	/**
	 * @see IEmailMessage::Subject()
	 */
	public function Subject()
	{
		return $this->Translate('ReservationCreatedAdminSubject');
	}
	
	/**
	 * @see IEmailMessage::Body()
	 */
	public function Body()
	{
		$this->PopulateTemplate();
		return $this->FetchTemplate("ReservationCreatedAdmin.tpl"); 
	}
	
	private function PopulateTemplate()
	{	
		$this->Set('UserName', $this->reservationOwner->FullName());
		
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
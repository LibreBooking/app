<?php
require_once(ROOT_DIR . 'lib/Email/namespace.php');
require_once(ROOT_DIR . 'Pages/Pages.php');

class ParticipantAddedEmail extends EmailMessage
{
	/**
	 * @var User
	 */
	private $reservationOwner;

	/**
	 * @var User
	 */
	private $participant;
	
	/**
	 * @var ReservationSeries
	 */
	private $reservationSeries;
	
	private $timezone;
	
	public function __construct(User $reservationOwner, User $participant, ReservationSeries $reservationSeries)
	{
		parent::__construct($participant->Language());
		
		$this->reservationOwner = $reservationOwner;
		$this->reservationSeries = $reservationSeries;
		$this->timezone = $participant->Timezone();
		$this->participant = $participant;
	}
	
	/**
	 * @see IEmailMessage::To()
	 */
	public function To()
	{
		$address = $this->participant->EmailAddress();
		$name = $this->participant->FullName();
		
		return array(new EmailAddress($address, $name));
	}
	
	/**
	 * @see IEmailMessage::Subject()
	 */
	public function Subject()
	{
		return $this->Translate('ParticipantAddedSubject');
	}

	/**
	 *  @see IEmailMessage::From()
	 */
	public function From()
	{
		return new EmailAddress($this->reservationOwner->EmailAddress(), $this->reservationOwner->FullName());
	}
	
	/**
	 * @see IEmailMessage::Body()
	 */
	public function Body()
	{
		$this->PopulateTemplate();
		return $this->FetchTemplate('ReservationCreated.tpl');
	}
	
	private function PopulateTemplate()
	{	
		$currentInstance = $this->reservationSeries->CurrentInstance();
		$this->Set('StartDate', $currentInstance->StartDate()->ToTimezone($this->timezone));
		$this->Set('EndDate', $currentInstance->EndDate()->ToTimezone($this->timezone));
		
		$this->Set('Title', $this->reservationSeries->Title());
		$this->Set('Description', $this->reservationSeries->Description());
		
		$repeatDates = array();
		foreach ($this->reservationSeries->Instances() as $repeated)
		{
			$repeatDates[] = $repeated->StartDate()->ToTimezone($this->timezone);
		}
		$this->Set('RepeatDates', $repeatDates);
		$this->Set('RequiresApproval', $this->reservationSeries->RequiresApproval());
		$this->Set('ReservationUrl', sprintf("%s?%s=%s", Pages::RESERVATION, QueryStringKeys::REFERENCE_NUMBER, $currentInstance->ReferenceNumber()));
	}
}
?>
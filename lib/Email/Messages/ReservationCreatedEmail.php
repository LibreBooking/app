<?php
require_once(ROOT_DIR . 'lib/Email/namespace.php');
require_once(ROOT_DIR . 'Pages/Pages.php');

// TODO: Need a way to unit test this
class ReservationCreatedEmail extends EmailMessage
{
	/**
	 * @var User
	 */
	private $reservationOwner;
	
	/**
	 * @var ReservationSeries
	 */
	private $reservationSeries;
	
	/**
	 * @var IResource
	 */
	private $primaryResource;
	
	private $timezone;
	
	public function __construct(User $reservationOwner, ReservationSeries $reservationSeries, IResource $primaryResource)
	{
		parent::__construct($reservationOwner->Language());
		
		$this->reservationOwner = $reservationOwner;
		$this->reservationSeries = $reservationSeries;
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
		$this->Set('ReservationUrl', sprintf("%s?%s=%s", Pages::RESERVATION, QueryStringKeys::REFERENCE_NUMBER, $currentInstance->ReferenceNumber()));
	}
}
?>
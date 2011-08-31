<?php
require_once(ROOT_DIR . 'lib/Email/namespace.php');

// TODO: Need a way to unit test this
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
	 * @var ReservationSeries
	 */
	private $reservationSeries;
	
	/**
	 * @var IResource
	 */
	private $resource;
	
	/**
	 * @param UserDto $adminDto
	 * @param User $reservationOwner
	 * @param ReservationSeries $reservationSeries
	 * @param IResource $primaryResource
	 */
	public function __construct($adminDto, User $reservationOwner, ReservationSeries $reservationSeries, IResource $primaryResource)
	{
		parent::__construct($adminDto->Language());
		
		$this->adminDto = $adminDto;
		$this->reservationOwner = $reservationOwner;
		$this->reservationSeries = $reservationSeries;
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
		$this->Set('RequiresApproval', $this->reservationSeries->RequiresApproval());
		$this->Set('RepeatDates', $repeatDates);
		$this->Set('ReservationUrl', Pages::RESERVATION . "?" . QueryStringKeys::REFERENCE_NUMBER . '=' . $currentInstance->ReferenceNumber());
	}
}
?>
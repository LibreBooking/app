<?php
class ReservationCreatedEmail implements IEmailMessage
{
	private $email;
	
	public function __construct(User $reservationOwner, Reservation $reservation, IResource $primaryResource)
	{
		$this->email = new SmartyEmail();
		//$lang = $reservationOwner->Language();
		//$timezone = $reservationOwner->Timezone();
		$timezone = 'US/Central';
		
		$this->Set('StartDate', $reservation->StartDate()->ToTimezone($timezone));
		$this->Set('EndDate', $reservation->EndDate()->ToTimezone($timezone));
		
		$repeatDates = array();
		foreach ($reservation->RepeatedDates() as $repeated)
		{
			$repeatDates[] = $repeated->GetBegin()->ToTimezone($timezone);
		}
		$this->Set('RepeatDates', $repeatDates);
	}
	
	private function Set($var, $value)
	{
		$this->email->assign($var, $value);
	}
	
	public function Body()
	{
		return $this->email->fetch("en_us/ReservationCreated.tpl"); 
	}
}
?>
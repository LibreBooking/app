<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . 'lib/Email/namespace.php');
require_once(ROOT_DIR . 'Pages/Pages.php');
require_once(ROOT_DIR . 'Domain/Values/InvitationAction.php');

class InviteeAddedEmail extends EmailMessage
{
	/**
	 * @var User
	 */
	private $reservationOwner;

	/**
	 * @var User
	 */
	private $invitee;
	
	/**
	 * @var ReservationSeries
	 */
	private $reservationSeries;
	
	private $timezone;
	
	public function __construct(User $reservationOwner, User $invitee, ReservationSeries $reservationSeries)
	{
		parent::__construct($invitee->Language());
		
		$this->reservationOwner = $reservationOwner;
		$this->reservationSeries = $reservationSeries;
		$this->timezone = $invitee->Timezone();
		$this->invitee = $invitee;
	}
	
	/**
	 * @see IEmailMessage::To()
	 */
	public function To()
	{
		$address = $this->invitee->EmailAddress();
		$name = $this->invitee->FullName();
		
		return array(new EmailAddress($address, $name));
	}
	
	/**
	 * @see IEmailMessage::Subject()
	 */
	public function Subject()
	{
		return $this->Translate('InviteeAddedSubject');
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
		return $this->FetchTemplate('ReservationInvitation.tpl');
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
		$this->Set('AcceptUrl', sprintf("%s?%s=%s&%s=%s", Pages::INVITATION_RESPONSES, QueryStringKeys::REFERENCE_NUMBER, $currentInstance->ReferenceNumber(), QueryStringKeys::INVITATION_ACTION, InvitationAction::Accept));
		$this->Set('DeclineUrl', sprintf("%s?%s=%s&%s=%s", Pages::INVITATION_RESPONSES, QueryStringKeys::REFERENCE_NUMBER, $currentInstance->ReferenceNumber(), QueryStringKeys::INVITATION_ACTION, InvitationAction::Decline));
		$this->Set('ReservationUrl', sprintf("%s?%s=%s", Pages::RESERVATION, QueryStringKeys::REFERENCE_NUMBER, $currentInstance->ReferenceNumber()));
	}
}
?>
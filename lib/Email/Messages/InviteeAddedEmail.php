<?php
/**
 * Copyright 2011-2017 Nick Korbel
 *
 * This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/Email/Messages/ReservationEmailMessage.php');
require_once(ROOT_DIR . 'Domain/Values/InvitationAction.php');

class InviteeAddedEmail extends ReservationEmailMessage
{
	/**
	 * @var User
	 */
	private $invitee;

	public function __construct(User $reservationOwner, User $invitee, ReservationSeries $reservationSeries, IAttributeRepository $attributeRepository)
	{
		parent::__construct($reservationOwner, $reservationSeries, $invitee->Language(), $attributeRepository);

		$this->reservationOwner = $reservationOwner;
		$this->reservationSeries = $reservationSeries;
		$this->timezone = $invitee->Timezone();
		$this->invitee = $invitee;
	}

	public function To()
	{
		$address = $this->invitee->EmailAddress();
		$name = $this->invitee->FullName();

		return array(new EmailAddress($address, $name));
	}

	public function Subject()
	{
		return $this->Translate('InviteeAddedSubjectWithResource', array($this->reservationOwner->FullName(), $this->primaryResource->GetName()));
	}

	public function From()
	{
		return new EmailAddress($this->reservationOwner->EmailAddress(), $this->reservationOwner->FullName());
	}

	public function GetTemplateName()
	{
		return 'ReservationInvitation.tpl';
	}

	protected function PopulateTemplate()
	{
		$currentInstance = $this->reservationSeries->CurrentInstance();
		parent::PopulateTemplate();

		$this->Set('AcceptUrl', sprintf("%s?%s=%s&%s=%s", Pages::INVITATION_RESPONSES, QueryStringKeys::REFERENCE_NUMBER, $currentInstance->ReferenceNumber(),
										QueryStringKeys::INVITATION_ACTION, InvitationAction::Accept));
		$this->Set('DeclineUrl', sprintf("%s?%s=%s&%s=%s", Pages::INVITATION_RESPONSES, QueryStringKeys::REFERENCE_NUMBER, $currentInstance->ReferenceNumber(),
										 QueryStringKeys::INVITATION_ACTION, InvitationAction::Decline));
	}
}

class InviteeRemovedEmail extends InviteeAddedEmail
{
	public function Subject()
	{
		return $this->Translate('ParticipantDeletedSubjectWithResource', array($this->reservationOwner->FullName(), $this->primaryResource->GetName()));
	}

	public function GetTemplateName()
	{
		return 'ReservationDeleted.tpl';
	}
}
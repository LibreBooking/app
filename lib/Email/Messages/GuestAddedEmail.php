<?php
/**
 * Copyright 2017-2019 Nick Korbel
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

class GuestAddedEmail extends ReservationEmailMessage
{
    /**
     * @var string
     */
    protected $guestEmail;

    public function __construct(User $reservationOwner, $guestEmail, ReservationSeries $reservationSeries, IAttributeRepository $attributeRepository, IUserRepository $userRepository)
	{
        parent::__construct($reservationOwner, $reservationSeries, $reservationOwner->Language(), $attributeRepository, $userRepository);

        $this->reservationOwner = $reservationOwner;
        $this->reservationSeries = $reservationSeries;
        $this->timezone = $reservationOwner->Timezone();
        $this->guestEmail = $guestEmail;
    }

    public function To()
    {
        return array(new EmailAddress($this->guestEmail));
    }

    public function Subject()
    {
        return $this->Translate('ParticipantAddedSubjectWithResource', array($this->reservationOwner->FullName(), $this->primaryResource->GetName()));
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

        $this->Set('AcceptUrl', sprintf("%s?%s=%s&%s=%s&%s=%s", Pages::GUEST_INVITATION_RESPONSES, QueryStringKeys::REFERENCE_NUMBER, $currentInstance->ReferenceNumber(), QueryStringKeys::EMAIL, $this->guestEmail, QueryStringKeys::INVITATION_ACTION, InvitationAction::Accept));
        $this->Set('DeclineUrl', sprintf("%s?%s=%s&%s=%s&%s=%s", Pages::GUEST_INVITATION_RESPONSES, QueryStringKeys::REFERENCE_NUMBER, $currentInstance->ReferenceNumber(), QueryStringKeys::EMAIL, $this->guestEmail, QueryStringKeys::INVITATION_ACTION, InvitationAction::Decline));
    }
}
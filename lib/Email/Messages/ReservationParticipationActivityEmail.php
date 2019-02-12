<?php
/**
 * Copyright 2019 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/Email/EmailMessage.php');

class ReservationParticipationActivityEmail extends EmailMessage
{
    /**
     * @var ExistingReservationSeries
     */
    private $series;
    /**
     * @var InvitationAction|string
     */
    private $invitationAction;
    /**
     * @var User
     */
    private $owner;
    /**
     * @var string
     */
    private $participantDetails;
    /**
     * @var string
     */
    private $timezone;

    /**
     * @param ExistingReservationSeries $series
     * @param string|InvitationAction $invitationAction
     * @param User $owner
     * @param string $participantDetails
     */
    public function __construct($series, $invitationAction, $owner, $participantDetails)
    {
        parent::__construct($owner->Language());
        $this->timezone = $owner->Timezone();
        $this->series = $series;
        $this->invitationAction = $invitationAction;
        $this->owner = $owner;
        $this->participantDetails = $participantDetails;
    }

    public function To()
    {
        return new EmailAddress($this->owner->EmailAddress(), $this->owner->FullName());
    }

    public function Subject()
    {
        $subject = 'ReservationParticipantAccept';
        if ($this->invitationAction == InvitationAction::Decline || $this->invitationAction == InvitationAction::CancelAll || $this->invitationAction == InvitationAction::CancelInstance){
            $subject = 'ReservationParticipantDecline';
        }
        else if ($this->invitationAction == InvitationAction::Join || $this->invitationAction == InvitationAction::JoinAll)
        {
            $subject = 'ReservationParticipantJoin';
        }
        return $this->Translate($subject, array($this->participantDetails, $this->series->Resource()->GetName(), $this->series->CurrentInstance()->StartDate()->ToTimezone($this->timezone)->Format(Resources::GetInstance()->GeneralDateFormat())));
    }

    public function Body()
    {
        $currentInstance = $this->series->CurrentInstance();
        $this->Set('UserName', $this->owner->FullName());
        $this->Set('StartDate', $currentInstance->StartDate()->ToTimezone($this->timezone));
        $this->Set('EndDate', $currentInstance->EndDate()->ToTimezone($this->timezone));
        $this->Set('ResourceName', $this->series->Resource()->GetName());
        $this->Set('Title', $this->series->Title());
        $this->Set('Description', $this->series->Description());
        $this->Set('ReservationUrl', sprintf("%s?%s=%s", Pages::RESERVATION, QueryStringKeys::REFERENCE_NUMBER, $currentInstance->ReferenceNumber()));

        $resourceNames = array();
        foreach ($this->series->AllResources() as $resource)
        {
            $resourceNames[] = $resource->GetName();
        }
        $this->Set('ResourceNames', $resourceNames);
        $this->Set('Accessories', $this->series->Accessories());
        $this->Set('ReferenceNumber', $currentInstance->ReferenceNumber());

        return $this->FetchTemplate('ReservationParticipationActivity.tpl');
    }
}
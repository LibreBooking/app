<?php

require_once(ROOT_DIR . 'lib/Email/Messages/ReservationEmailMessage.php');
require_once(ROOT_DIR . 'lib/Email/Messages/InviteeAddedEmail.php');

class ParticipantAddedEmail extends InviteeAddedEmail
{
    public function Subject()
    {
        return $this->Translate('ParticipantAddedSubjectWithResource', [$this->reservationOwner->FullName(), $this->primaryResource->GetName()]);
    }
}

class ParticipantUpdatedEmail extends InviteeUpdatedEmail
{
    public function Subject()
    {
        return $this->Translate('ParticipantUpdatedSubjectWithResource', [$this->reservationOwner->FullName(), $this->primaryResource->GetName()]);
    }
}

class ParticipantDeletedEmail extends InviteeRemovedEmail
{
    public function Subject()
    {
        return $this->Translate('ParticipantDeletedSubjectWithResource', [$this->reservationOwner->FullName(), $this->primaryResource->GetName()]);
    }
}

<?php

require_once(ROOT_DIR . 'lib/Email/Messages/ReservationEmailMessage.php');

// TODO: Need a way to unit test this
class ReservationCreatedEmail extends ReservationEmailMessage
{
    public function Subject()
    {
        return $this->Translate('ReservationCreatedSubjectWithResource', [$this->primaryResource->GetName()]);
    }

    protected function GetTemplateName()
    {
        return 'ReservationCreated.tpl';
    }
}

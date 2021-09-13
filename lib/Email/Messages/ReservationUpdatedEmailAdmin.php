<?php

require_once(ROOT_DIR . 'lib/Email/Messages/ReservationCreatedEmailAdmin.php');

class ReservationUpdatedEmailAdmin extends ReservationCreatedEmailAdmin
{
    public function Subject()
    {
        return $this->Translate('ReservationUpdatedAdminSubjectWithResource', [$this->resource->GetName()]);
    }
}

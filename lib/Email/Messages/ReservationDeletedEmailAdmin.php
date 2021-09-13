<?php

require_once(ROOT_DIR . 'lib/Email/Messages/ReservationCreatedEmailAdmin.php');

class ReservationDeletedEmailAdmin extends ReservationCreatedEmailAdmin
{
    public function Subject()
    {
        return $this->Translate('ReservationDeleteAdminSubjectWithResource', [$this->resource->GetName()]);
    }

    public function PopulateTemplate()
    {
        if (method_exists($this->reservationSeries, 'GetDeleteReason')) {
            $this->Set('DeleteReason', $this->reservationSeries->GetDeleteReason());
        }
        parent::PopulateTemplate();
    }

    protected function GetTemplateName()
    {
        return 'ReservationDeleted.tpl';
    }
}

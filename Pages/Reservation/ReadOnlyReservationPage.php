<?php

require_once(ROOT_DIR . 'Pages/Ajax/AutoCompletePage.php');
require_once(ROOT_DIR . 'Pages/Reservation/NewReservationPage.php');
require_once(ROOT_DIR . 'Pages/Reservation/ExistingReservationPage.php');
require_once(ROOT_DIR . 'lib/Application/Authorization/GuestPermissionServiceFactory.php');

class ReadOnlyReservationPage extends ExistingReservationPage
{
    public function __construct()
    {
        $this->permissionServiceFactory = new GuestPermissionServiceFactory();
        parent::__construct();
        $this->IsEditable = false;
        $this->IsApprovable = false;
    }

    public function PageLoad()
    {
        parent::PageLoad();
    }

    public function SetIsEditable($canBeEdited)
    {
        // no-op
    }

    public function SetIsApprovable($canBeApproved)
    {
        // no-op
    }
}

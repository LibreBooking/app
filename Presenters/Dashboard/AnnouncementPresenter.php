<?php

require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Authorization/namespace.php');

class AnnouncementPresenter
{
    private $_control;
    private $_announcements;
    private $_permissionService;

    /**
     * @param IAnnouncementsControl $control the control to populate
     * @param IAnnouncementRepository $announcements Announcements domain object
     * @param IPermissionService $permissionService
     */
    public function __construct(IAnnouncementsControl $control, IAnnouncementRepository $announcements, IPermissionService $permissionService)
    {
        $this->_control = $control;
        $this->_announcements = $announcements;
        $this->_permissionService = $permissionService;
    }

    public function PageLoad()
    {
        $this->PopulateAnnouncements();
    }

    private function PopulateAnnouncements()
    {
        $announcements = $this->_announcements->GetFuture(Pages::ID_DASHBOARD);
        $user = ServiceLocator::GetServer()->GetUserSession();

        $userAnnouncement = [];
        foreach ($announcements as $announcement) {
            if ($announcement->AppliesToUser($user, $this->_permissionService)) {
                $userAnnouncement[] = $announcement;
            }
        }
        $this->_control->SetAnnouncements($userAnnouncement);
    }
}

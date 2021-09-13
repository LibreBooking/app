<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Admin/ResourceAdminManageReservationsPage.php');

class GroupAdminManageReservationsPage extends ManageReservationsPage
{
    public function __construct()
    {
        parent::__construct();

        $userRepository = new UserRepository();
        $this->presenter = new ManageReservationsPresenter(
            $this,
            new GroupAdminManageReservationsService(new ReservationViewRepository(), $userRepository, new ReservationAuthorization(PluginManager::Instance()->LoadAuthorization())),
            new ScheduleRepository(),
            new ResourceRepository(),
            new AttributeService(new AttributeRepository()),
            $userRepository,
            new TermsOfServiceRepository()
        );

        $this->SetCanUpdateResourceStatus(false);
    }
}

$page = new RoleRestrictedPageDecorator(new GroupAdminManageReservationsPage(), [RoleLevel::GROUP_ADMIN]);
$page->PageLoad();

<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Admin/ManageReservationsPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageReservationsPresenter.php');

$page = new AdminPageDecorator(new ManageReservationsPage());
$page->PageLoad();

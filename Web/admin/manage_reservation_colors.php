<?php

define('ROOT_DIR', '../../');
require_once(ROOT_DIR . 'Pages/Admin/ManageReservationColorsPage.php');

$page = new AdminPageDecorator(new ManageReservationColorsPage());
$page->PageLoad();

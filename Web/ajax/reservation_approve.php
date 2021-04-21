<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Ajax/ReservationApprovalPage.php');

$page = new ReservationApprovalPage();
$page->PageLoad();

<?php 
define('ROOT_DIR', './');

require_once(ROOT_DIR . '/Pages/ReservationPage.php');

$usersession = new UserSession(1);
//$usersession->Timezone = 'US/Central';
$usersession->Timezone = 'UTC';
ServiceLocator::GetServer()->SetSession(SessionKeys::USER_SESSION, $usersession);

$page = new ReservationPage();
$page->PageLoad();
?>
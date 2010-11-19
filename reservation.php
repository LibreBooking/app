<?php 
define('ROOT_DIR', './');

require_once(ROOT_DIR . '/Pages/ReservationPage.php');

$usersession = new UserSession(1);
$usersession->Timezone = 'US/Central';
//$usersession->Timezone = 'UTC';
ServiceLocator::GetServer()->SetSession(SessionKeys::USER_SESSION, $usersession);

$server = ServiceLocator::GetServer();

$page = new NewReservationPage();

if (!is_null($server->GetQuerystring(QueryStringKeys::REFERENCE_NUMBER)))
{
	$page = new ExistingReservationPage();
}

$page->PageLoad();
?>
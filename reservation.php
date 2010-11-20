<?php 
define('ROOT_DIR', './');

require_once(ROOT_DIR . '/Pages/NewReservationPage.php');
require_once(ROOT_DIR . '/Pages/ExistingReservationPage.php');

$usersession = new UserSession(1);
$usersession->Timezone = 'America/Chicago';
$server = ServiceLocator::GetServer();
$server->SetSession(SessionKeys::USER_SESSION, $usersession);

$page = new NewReservationPage();

if (!is_null($server->GetQuerystring(QueryStringKeys::REFERENCE_NUMBER)))
{
	$page = new ExistingReservationPage();
}

$page->PageLoad();
?>
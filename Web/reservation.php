<?php 
define('ROOT_DIR', '../');

require_once(ROOT_DIR . '/Pages/NewReservationPage.php');
require_once(ROOT_DIR . '/Pages/ExistingReservationPage.php');

$server = ServiceLocator::GetServer();

if (!is_null($server->GetQuerystring(QueryStringKeys::REFERENCE_NUMBER)))
{
	$page = new ExistingReservationPage();
}
else
{
	$page = new NewReservationPage();
}

$page->PageLoad();
?>
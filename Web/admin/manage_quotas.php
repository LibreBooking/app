<?php
define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Admin/ManageQuotasPage.php');
require_once(ROOT_DIR . 'Pages/Ajax/AutoCompletePage.php');

$page = new ManageQuotasPage();
if ($page->TakingAction())
{
	$page->ProcessAction();
}
else if ($page->RequestingData())
{
	$page->FulfilDataRequest();
}
else
{
	$page->PageLoad();
}
?>
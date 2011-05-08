<?php
define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Admin/ManageGroupsPage.php');

$page = new ManageGroupsPage();
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
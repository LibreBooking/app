<?php
define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Admin/ManageAnnouncementsPage.php');

$page = new ManageAnnouncementsPage();
if ($page->TakingAction())
{
	$page->ProcessAction();
}
else
{
	$page->PageLoad();
}
?>
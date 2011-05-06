<?php 
define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Admin/ManageUsersPage.php');
//require_once(ROOT_DIR . 'Presenters/Admin/ManageResourcesPresenter.php');

$page = new ManageUsersPage();
if ($page->TakingAction())
{
	$page->ProcessAction();
}
else 
{
	$page->PageLoad();
}
?>
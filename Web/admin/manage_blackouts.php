<?php 
define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Admin/ManageBlackoutsPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageBlackoutsPresenter.php');

$page = new ManageBlackoutsPage();
if ($page->TakingAction())
{
	$page->ProcessAction();
}
else 
{
	$page->PageLoad();
}
?>
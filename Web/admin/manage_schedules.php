<?php 
define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Admin/ManageSchedulesPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageSchedulesPresenter.php');

$page = new ManageSchedulesPage();
if ($page->TakingAction())
{
	$page->ProcessAction();
}
else 
{
	$page->PageLoad();
}
?>
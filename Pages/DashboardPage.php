<?php
require_once(ROOT_DIR . 'Pages/SecurePage.php');

class DashboardPage extends SecurePage implements IDashboardPage
{
	public function __construct()
	{
		parent::__construct('MyDashboard');
	}
	
	public function SetAnnouncements($announcements)
	{
		$this->smarty->assign('Announcements', $announcements);	
	}
}

interface IDashboardPage
{
	public function SetAnnouncements($announcements);
}
?>
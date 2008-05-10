<?php
require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/DashboardPresenter.php');

class DashboardPage extends SecurePage implements IDashboardPage
{
	public function __construct()
	{
		parent::__construct('MyDashboard');
		$this->_presenter = new DashboardPresenter($this);
	}
	
	public function PageLoad()
	{
		$this->_presenter->PageLoad();
		$this->smarty->display('dashboard.tpl');		
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
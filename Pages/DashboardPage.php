<?php
require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/DashboardPresenter.php');

class DashboardPage extends SecurePage implements IDashboardPage
{
	private $items = array();
	
	public function __construct()
	{
		parent::__construct('MyDashboard');
		$this->_presenter = new DashboardPresenter($this);
	}
	
	public function PageLoad()
	{
		$this->_presenter->Initialize();
		
		$this->smarty->assign('items', $this->items);
		$this->smarty->display('dashboard.tpl');		
	}
	
	public function AddItem(DashboardItem $item)
	{
		$this->items[] = $item;
	}
}

interface IDashboardPage
{
	function AddItem(DashboardItem $item);
}
?>
<?php
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Database/Commands/namespace.php');

class DashboardPresenter
{
	private $_page;
	
	public function __construct(IDashboardPage $page)
	{
		$this->_page = $page;
	}
	
	public function PageLoad()
	{
	}
}
?>
<?php
require_once(ROOT_DIR . 'Controls/Control.php');

abstract class DashboardItem extends Control
{
	public function __construct(SmartyPage $smarty)
	{
		parent::__construct($smarty);
	}
	
	protected function Display($templateName)
	{
		$this->smarty->display("Dashboard/$templateName");
	}
	
	protected function Assign($name, $value)
	{
		$this->smarty->assign($name, $value);
	}
}
?>
<?php
require('Control.php');

class LeaderBoard extends Control
{
	public function __construct(SmartyPage $smarty = null)
	{
		parent::__construct($smarty);
	}
	
	public function PageLoad()
	{
		$this->smarty->display('LeaderBoard.tpl');		
	}
	
	public function Set($var, $val)
	{
		$this->smarty->assign($var, $val);
	}
}
?>
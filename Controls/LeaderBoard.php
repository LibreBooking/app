<?php
require(ROOT_DIR . '/Controls/Control.php');

class LeaderBoard extends Control
{
	public function __construct(SmartyPage $smarty)
	{
		parent::__construct($smarty);
	}
	
	public function PageLoad()
	{
		$this->smarty->display('LeaderBoard.tpl');		
	}
}
?>
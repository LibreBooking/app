<?php
require_once(ROOT_DIR . 'Controls/Control.php');

class LeaderBoard extends Control
{
	public function __construct(SmartyPage $smarty)
	{
		parent::__construct($smarty);
	}
	
	public function PageLoad()
	{
		$this->smarty->display('Controls/LeaderBoard.tpl');		
	}
}
?>
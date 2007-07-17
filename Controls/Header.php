<?php
abstract class Control
{
	protected $smarty = null;
	
	public function __construct(SmartyPage $smarty)
	{
		$this->smarty =& $smarty;
	}
	
	abstract function PageLoad();
}

class Header extends Control
{
	public function __construct(SmartyPage $smarty = null)
	{
		parent::__construct($smarty);
	}
	
	public function PageLoad()
	{
		$this->smarty->display('HeaderControl.tpl');		
	}
	
	public function Set($var, $val)
	{
		$this->smarty->assign($var, $val);
	}
}
?>
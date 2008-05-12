<?php
abstract class Control
{
	protected $smarty = null;
	
	public function __construct(SmartyPage $smarty)
	{
		$this->smarty =& $smarty;
	}
	
	public function Set($var, $value)
	{
		$this->smarty->assign($var, $value);
	}
	
	abstract function PageLoad();
}
?>
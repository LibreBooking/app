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
	
	protected function Get($var)
	{
		return $this->smarty->get_template_vars($var);
	}
	
	abstract function PageLoad();
}
?>
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
?>
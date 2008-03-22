<?php
require_once($root . 'Smarty/Smarty.class.php');

class FakeSmarty extends Smarty 
{
	public $_LastVar;
	public $_Value;
	
	function get_template_vars($varname)
	{
		$this->_LastVar = $varname;
		
		return $this->_Value;
	}	
}

?>
<?php
require_once(ROOT_DIR . 'lib/external/Smarty/Smarty.class.php');

class FakeSmarty extends Smarty 
{
	public $_LastVar;
	public $_Value;
	
	function getTemplateVars($varname)
	{
		$this->_LastVar = $varname;
		
		return $this->_Value;
	}	
}

?>
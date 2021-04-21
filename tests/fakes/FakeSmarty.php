<?php

require_once(ROOT_DIR . 'lib/external/Smarty/Smarty.class.php');

class FakeSmarty extends Smarty
{
	public $_LastVar;
	public $_Value;

	public function getTemplateVars($varname = null, Smarty_Internal_Data $_ptr = null, $search_parents = true)
	{
		$this->_LastVar = $varname;

		return $this->_Value;
	}
}

?>

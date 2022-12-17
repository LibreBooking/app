<?php

if (file_exists(ROOT_DIR . 'vendor/autoload.php')) {
  require_once ROOT_DIR . 'vendor/autoload.php';
}

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

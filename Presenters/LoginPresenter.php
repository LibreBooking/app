<?php
require_once(dirname(__FILE__) . '/../lib/Config/namespace.php');

class LoginPresenter
{
	var $_page = null;
	var $_server = null;
	var $_configKeys = null;
	var $_config = null;
	
	function LoginPresenter(&$page, &$server)
	{
		$this->_page =& $page;
		$this->_server =& $server;
		$this->_configKeys = new ConfigKeys();
		$this->_config = new Configuration();
	}
	
	function PageLoad()
	{
		$allowRegistration = (bool)$this->_config->GetKey($this->_configKeys->ALLOW_REGISTRATION);
		$this->_page->setShowRegisterLink($allowRegistration);
		$this->_page->PageLoad();
	}
	
	function Login(&$auth)
	{
		if ($auth->Validate($this->_page->getEmailAddress(), $this->_page->getPassword()))
		{
			$auth->Login($this->_page->getEmailAddress(), $this->_page->getPersistLogin());		
			$this->_Redirect();
		}
	}

	function _Redirect()
	{
		$keys = new QueryStringKeys();
		$redirect = $this->_server->GetQuerystring($keys->REDIRECT);
		
		if (!empty($redirect))
		{
			$this->_page->Redirect($redirect);
		}
		else
		{
			$this->_page->Redirect('ctrlpnl.php');
		}
	}
}
?>

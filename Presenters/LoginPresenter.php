<?php

class LoginPresenter
{
	var $_page = null;
	var $_server = null;
	
	function LoginPresenter(&$page, &$server)
	{
		$this->_page = $page;
		$this->_server = $server;
	}
	
	function Login(&$auth)
	{
		if ($auth->Validate($this->_page->get_EmailAddress(), $this->_page->get_Password()))
		{
			$auth->Login($this->_page->get_EmailAddress(), $this->_page->get_PersistLogin());
		}
	}	
}

class ILoginPage extends IPage
{
	function get_EmailAddress() { die ('Not implemented'); }
	function get_Password() { die ('Not implemented'); }
	function get_PersistLogin()  { die ('Not implemented'); }
}

class IPage
{
	function Redirect($url) { die ('Not implemented'); }
}
?>

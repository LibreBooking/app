<?php
require_once(ROOT_DIR . 'plugins/Authentication/Ldap/LdapOptions.php');

class FakeLdapOptions extends LdapOptions
{
	public $_Options = array();
	public $_Hosts = array();
	public $_RetryAgainstDatabase = false;
	
	public function AdLdapOptions()
	{
		return $this->_Options;
		
	}
	public function Hosts()
	{
		return $this->_Hosts;
	}
	
	public function RetryAgainstDatabase()
	{
		return $this->_RetryAgainstDatabase;
	}
}
?>
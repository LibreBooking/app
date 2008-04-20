<?php
require_once(ROOT_DIR . 'lib/Authorization/namespace.php');
require_once(ROOT_DIR . 'plugins/Auth/Ldap/ldap.config.php');

class Ldap implements IAuthorization
{
	private $authToDecorate;
	private $ldap;
	private $options;
	
	public function __construct($authorization, $ldapImplementation, $ldapOptions)
	{
		$this->authToDecorate = $authorization; 
		$this->ldap = $ldapImplementation;
		$this->options = $ldapOptions;
	}
	
	public function Validate($username, $password)
	{
		$this->ldap->Connect();
		return $this->ldap->Authenticate($username, $password);
	}
	
	public function Login($username, $persist)
	{
		// check for user in db, register if needed
	}
	
	public function CookieLogin($cookieValue)
	{
		$this->authToDecorate->CookieLogin($cookieValue);
	}
}
?>
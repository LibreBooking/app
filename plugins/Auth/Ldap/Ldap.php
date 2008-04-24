<?php
require_once(ROOT_DIR . 'lib/Authorization/namespace.php');
require_once(ROOT_DIR . 'plugins/Auth/Ldap/ldap.config.php');

class Ldap implements IAuthorization
{
	private $authToDecorate;
	private $ldap;
	private $options;
	
	private $user;
	
	public function __construct($authorization, $ldapImplementation, $ldapOptions)
	{
		$this->authToDecorate = $authorization; 
		$this->ldap = $ldapImplementation;
		$this->options = $ldapOptions;
	}
	
	public function Validate($username, $password)
	{
		$this->ldap->Connect();
		
		$this->user = $this->ldap->GetLdapUser($username);
		
		$isValid = false;
		
		if ($this->user != null)
		{
			$isValid = $this->ldap->Authenticate($username, $password);
		}
		else
		{
			if ($this->options->RetryAgainstDatabase())
			{
				$isValid = $this->authToDecorate->Validate($username, $password);
			}
		}
		
		return $isValid;
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
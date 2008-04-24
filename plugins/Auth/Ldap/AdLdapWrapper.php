<?php
require_once(ROOT_DIR . 'plugins/Auth/Ldap/adLdap.php');

class AdLdapWrapper implements ILdap
{
	private $config;
	private $ldap;
	
	public function __construct($config)
	{
		$this->config = $config;
	}
	
	public function Connect()
	{
		$connected = false;
		$attempts = 0;
		$hosts = $this->config->Hosts();
		$options = $this->config->AdLdapOptions();
		
		while (!$connected && $attempts < count($hosts))
		{
			try 
			{
				$options['host'] = $hosts[$attempts];
				$attempts++;
				$this->ldap = new adLdap($options);
				$connected = true;
			}
			catch (Exception $ex)
			{
				// adLdap throws exception when cannot connect
			}			
		}
		
		return $connected;
	}
	
	public function Authenticate($username, $password)
	{
		return $this->ldap->authenticate($username, $password);
	}
	
	public function GetLdapUser($username)
	{
		$attributes = array( 'sn', 'givenname', 'mail', 'telephonenumber', 'physicaldeliveryofficename', 'title' );
		$entries = $this->ldap->user_info($username, $attributes);
		
		if (count($entries) > 0)
		{
			return new LdapUser($entries);
		}
		
		return null;
	}
}
?>
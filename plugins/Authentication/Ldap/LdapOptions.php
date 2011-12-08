<?php
require_once(ROOT_DIR . '/lib/Config/namespace.php');

class LdapOptions
{
	private $_options = array();
	
	public function __construct()
	{
        require_once(dirname(__FILE__) . '/Ldap.config.php');

		Configuration::Instance()->Register(
					dirname(__FILE__) . '/Ldap.config.php',
					LdapConfig::CONFIG_ID);
	}
	
	public function AdLdapOptions()
	{
		$hosts = $this->GetHosts();
		$this->SetOption('domain_controllers', $hosts);
		$this->SetOption('port', $this->GetConfig(LdapConfig::PORT), new IntConverter());
		$this->SetOption('ad_username', $this->GetConfig(LdapConfig::USERNAME));
		$this->SetOption('ad_password', $this->GetConfig(LdapConfig::PASSWORD));
		$this->SetOption('base_dn', $this->GetConfig(LdapConfig::BASEDN));
		$this->SetOption('use_ssl', $this->GetConfig(LdapConfig::USE_SSL, new BooleanConverter()));
		$this->SetOption('account_suffix', $this->GetConfig(LdapConfig::ACCOUNT_SUFFIX));
		$this->SetOption('ldap_version', $this->GetConfig(LdapConfig::VERSION), new IntConverter());
		
		return $this->_options;
	}
	
	public function RetryAgainstDatabase()
	{
		return $this->GetConfig(LdapConfig::RETRY_AGAINST_DATABASE, new BooleanConverter());
	}
	
	public function Controllers()
	{
		return $this->GetHosts();
	}
	
	private function SetOption($key, $value)
	{
        if (empty($value))
        {
            $value = null;
        }

		$this->_options[$key] = $value;
	}
	
	private function GetConfig($keyName, $converter = null)
	{
		return Configuration::Instance()->File(LdapConfig::CONFIG_ID)->GetKey($keyName, $converter);
	}
	
	private function GetHosts()
	{
		$hosts = explode(',', $this->GetConfig(LdapConfig::DOMAIN_CONTROLLERS));

		for ($i = 0; $i < count($hosts); $i++)
		{
			$hosts[$i] = trim($hosts[$i]);
		}
		
		return $hosts;
	}
	
}
?>
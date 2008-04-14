<?php
require_once(ROOT_DIR . 'lib/pear/LDAP2.php');
require_once(ROOT_DIR . 'Config/namespace.php');

class PearLdapOptions
{
	private $_options = array();
	
	public function __construct()
	{
		Configuration::Instance()->Register(
					dirname(__FILE__) . 'Ldap.config.php', 
					LdapConfig::CONFIG_ID);
	}
	
	public function ConstructOptions()
	{
		$this->SetOption('host', $this->GetHosts());
		$this->SetOption('port', $this->GetConfig(LdapConfig::PORT));
		$this->SetOption('binddn', $this->GetConfig(LdapConfig::USERNAME));
		$this->SetOption('bindpw', $this->GetConfig(LdapConfig::PASSWORD));
		$this->SetOption('base', $this->GetConfig(LdapConfig::BASE));
		$this->SetOption('starttls', $this->GetConfig(LdapConfig::START_TLS, new BooleanConverter()));
		$this->SetOption('filter', $this->GetConfig(LdapConfig::FILTER));
		$this->SetOption('scope', $this->GetConfig(LdapConfig::SCOPE));
		$this->SetOption('version', $this->GetConfig(LdapConfig::VERSION));
		
		return $this->_options;
	}
	
	private function SetOption($key, $value)
	{
		if (!empty($value))
		{
			$this->_options[$key] = $value;
		}
	}
	
	private function GetConfig($keyName, $converter = null)
	{
		return Configuration::Instance()->File(LdapConfig::CONFIG_ID)->GetKey($keyName, $converter);
	}
	
	private function GetHosts()
	{
		$hosts = explode(',', $this->GetConfig(LdapConfig::HOST));

		for ($i = 0; $i < count($hosts); $i++)
		{
			$hosts[$i] = trim($hosts[$i]);
		}
		
		return $hosts;
	}
	
}
?>
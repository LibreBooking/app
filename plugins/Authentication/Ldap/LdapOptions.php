<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

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
		$this->SetOption('ad_port', $this->GetConfig(LdapConfig::PORT), new IntConverter());
		$this->SetOption('admin_username', $this->GetConfig(LdapConfig::USERNAME));
		$this->SetOption('admin_password', $this->GetConfig(LdapConfig::PASSWORD));
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
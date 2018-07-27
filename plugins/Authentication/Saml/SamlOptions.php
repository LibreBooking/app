<?php
/**
File in Authentication plugin package for ver 2.1.4 Booked Scheduler
to implement Single Sign On Capability.  Based on code from the
Booked Scheduler Authentication Ldap plugin as well as a SAML
Authentication plugin for Moodle 1.9+.
See http://moodle.org/mod/data/view.php?d=13&rid=2574
This plugin uses the SimpleSAMLPHP version 1.8.2 libraries.
http://simplesamlphp.org/

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . '/lib/Config/namespace.php');

class SamlOptions
{
	private $_options = array();

	public function __construct()
	{
        require_once(dirname(__FILE__) . '/Saml.config.php');

		Configuration::Instance()->Register(
					dirname(__FILE__) . '/Saml.config.php',
					SamlConfig::CONFIG_ID);
	}

	public function AdSamlOptions()
	{
		$this->SetOption('ssphp_lib', $this->GetConfig(SamlConfig::SIMPLESAMLPHP_LIB));
		$this->SetOption('ssphp_config', $this->GetConfig(SamlConfig::SIMPLESAMLPHP_CONFIG));
		$this->SetOption('ssphp_sp', $this->GetConfig(SamlConfig::SIMPLESAMLPHP_SP));
		$this->SetOption('ssphp_username', $this->GetConfig(SamlConfig::USERNAME));
		$this->SetOption('ssphp_firstname', $this->GetConfig(SamlConfig::FIRSTNAME));
		$this->SetOption('ssphp_lastname', $this->GetConfig(SamlConfig::LASTNAME));
		$this->SetOption('ssphp_email', $this->GetConfig(SamlConfig::EMAIL));
		$this->SetOption('ssphp_phone', $this->GetConfig(SamlConfig::PHONE));
		$this->SetOption('ssphp_organization', $this->GetConfig(SamlConfig::ORGANIZATION));
		$this->SetOption('ssphp_position', $this->GetConfig(SamlConfig::POSITION));

		return $this->_options;
	}

	public function ReturnTo()
    {
        return $this->GetConfig(SamlConfig::RETURN_TO);
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
		return Configuration::Instance()->File(SamlConfig::CONFIG_ID)->GetKey($keyName, $converter);
	}
}
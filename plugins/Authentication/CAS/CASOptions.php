<?php
/**
Copyright 2012 Bart Verheyde
bart.verheyde@ugent.be

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

class CASOptions
{
	private $_options = array();

	public function __construct()
	{

//  this gave error cannot redeclair CASConfig 
		require_once(dirname(__FILE__) . '/CASConfig.php');


		Configuration::Instance()->Register(dirname(__FILE__) . '/CASConfig.php',CASConfig2::CONFIG_ID);

	}

	public function CAS2Config()
	{
		$this->SetOption('cas_version', $this->GetConfig(CASConfig::CAS_VERSION));
		$this->SetOption('cas_url_server', $this->GetConfig(CASConfig::CAS_URL_SERVER));
		$this->SetOption('cas_port', $this->GetConfig(CASConfig::CAS_PORT, new IntConverter()));
		$this->SetOption('cas_uri_server', $this->GetConfig(CASConfig::CAS_URI_SERVER));
		$this->SetOption('cas_changeSessionID', $this->GetConfig(CASConfig::CAS_CHANGESESSIONID, new BooleanConverter()));
		$this->SetOption('cas_communicationprotocol', $this->GetConfig(CASConfig::CAS_COMMUNICATIONPROTOCOL));
		$this->SetOption('cas_certificates', $this->GetConfig(CASConfig::CAS_CERTIFICATES));

		$logout_servers = $this->GetLogoutServers();
		$this->SetOption('cas_logout_servers', $logout_servers);

		$this->SetOption('user_id_attribute', $this->GetConfig(CASConfig::USER_ID_ATTRIBUTE));

		return $this->_options;
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
		return Configuration::Instance()->File(CASConfig::CONFIG_ID)->GetKey($keyName, $converter);
	}

	private function GetLogoutServers()
	{
		$servers = explode(',', $this->GetConfig(CASConfig::CAS_LOGOUT_SERVERS));

		for ($i = 0; $i < count($servers); $i++)
		{
			$servers[$i] = trim($servers[$i]);
		}

		return $servers;
	}

	public function IsCASpDebugOn()
	{
		return $this->GetConfig('cas_debug', new BooleanConverter());
	}

	public function Attributes()
	{
		$attributes = $this->AttributeMapping();
		return array_values($attributes);
	}

	public function AttributeMapping()
	{
		$attributes = array('sn' => 'sn',
							'givenname' => 'givenname',
							'mail' => 'mail',
							'telephonenumber' => 'telephonenumber',
							'physicaldeliveryofficename' => 'physicaldeliveryofficename',
							'title' => 'title');
		$configValue = $this->GetConfig(CASConfig::ATTRIBUTE_MAPPING);

		if (!empty($configValue))
		{
			$attributePairs = explode(',', $configValue);
			foreach ($attributePairs as $attributePair)
			{
				$pair = explode('=', trim($attributePair));
				$attributes[trim($pair[0])] = trim($pair[1]);
			}
		}

		return $attributes;
	}

	public function GetUserIdAttribute()
	{
		$attribute = $this->GetConfig(CASConfig::USER_ID_ATTRIBUTE);

		if (empty($attribute))
		{
			return 'uid';
		}

		return $attribute;
	}

}

?>

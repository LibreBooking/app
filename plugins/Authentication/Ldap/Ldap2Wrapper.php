<?php
/**
Copyright 2012 Nick Korbel

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

require_once(ROOT_DIR . 'plugins/Authentication/Ldap/LDAP2.php');

class Ldap2Wrapper
{
	/**
	 * @var LdapOptions
	 */
	private $options;

	/**
	 * @var Net_LDAP2|null
	 */
	private $ldap;

	/**
	 * @var string
	 */
	private $successfulDn;

	/**
	 * @param LdapOptions $ldapOptions
	 */
	public function __construct($ldapOptions)
	{
		$this->options = $ldapOptions;
	}

	public function Connect()
	{
		Log::Debug('Trying to connect to LDAP');

		$this->ldap = Net_LDAP2::connect($this->options->Ldap2Config());
		if (PEAR::isError($this->ldap))
		{
			$message = 'Could not connect to LDAP server. Check your settings in Ldap.config.php : ' . $this->ldap->getMessage();
			Log::Error($message);
			throw new Exception($message);
		}

		return true;
	}

	/**
	 * @param string $username
	 * @return array|string[]
	 */
	private function GetDnsWithUid($username)
	{
		$fullDns = array();
		$baseDns = $this->options->BaseDns();
		foreach ($baseDns as $baseDn)
		{
			$fullDns[] = "uid=$username,$baseDn";
		}
		return $fullDns;
	}

	/**
	 * @param $username string
	 * @param $password string
	 * @return bool
	 */
	public function Authenticate($username, $password)
	{
		Log::Debug('Trying to authenticate user %s against ldap', $username);
		foreach ($this->GetDnsWithUid($username) as $dn)
		{
			Log::Debug('Using %s to authenticate user %s', $dn, $username);
			$result = $this->ldap->bind($dn, $password);
			if ($result === true)
			{
				Log::Debug('Authentication was successful');
				$this->successfulDn = $dn;
				return true;
			}

			if (Net_LDAP2::isError($result))
			{
				$message = 'Could not authenticate user against ldap %s: ' . $result->getMessage();
				Log::Error($message, $username);
			}
		}
		return false;
	}

	/**
	 * @param $username string
	 * @return LdapUser|null
	 */
	public function GetLdapUser($username)
	{
		Log::Debug('Getting ldap user entry for user %s', $username);

		$attributes = array('sn', 'givenname', 'mail', 'telephonenumber', 'physicaldeliveryofficename', 'title');

		$entry = $this->ldap->getEntry($this->successfulDn, $attributes);

		if (Net_LDAP2::isError($entry))
		{
			$message = 'Could not fetch ldap entry for user %s: ' . $entry->getMessage();
			Log::Error($message, $username);
			return null;
		}

		/** @var Net_LDAP2_Entry $entry  */
		return new LdapUser($entry);
	}
}

?>
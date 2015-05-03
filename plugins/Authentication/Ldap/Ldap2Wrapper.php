<?php
/**
Copyright 2012-2015 Nick Korbel

This file is part of Booked Scheduler.

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
	 * @var LdapUser|null
	 */
	private $user;

	/**
	 * @param LdapOptions $ldapOptions
	 */
	public function __construct($ldapOptions)
	{
		$this->options = $ldapOptions;
		$this->user = null;
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
	 * @param $username string
	 * @param $password string
	 * @param $filter string
	 * @return bool
	 */
     public function Authenticate($username, $password, $filter)
    {
          $this->PopulateUser($username, $filter);

         if ($this->user == null)
         {
			return false;
		}

		Log::Debug('Trying to authenticate user %s against ldap with dn %s', $username, $this->user->GetDn());

		$result = $this->ldap->bind($this->user->GetDn(), $password);
		if ($result === true)
		{
			Log::Debug('Authentication was successful');

			return true;
		}

		if (Net_LDAP2::isError($result))
		{
			$message = 'Could not authenticate user against ldap %s: ' . $result->getMessage();
			Log::Error($message, $username);
		}
		return false;
	}

	/**
	 * @param $username string
	 * @param $configFilter string
	 * @return void
	 */
	private function PopulateUser($username, $configFilter)
	{
		$uidAttribute = $this->options->GetUserIdAttribute();
		Log::Debug('LDAP - uid attribute: %s', $uidAttribute);
		$RequiredGroup = $this->options->GetRequiredGroup();

		$filter = Net_LDAP2_Filter::create($uidAttribute, 'equals', $username);

		if ($configFilter)
		{
			$configFilter = Net_LDAP2_Filter::parse($configFilter);
			if (Net_LDAP2::isError($configFilter))
			{
				$message = 'Could not parse search filter %s: ' . $configFilter->getMessage();
				Log::Error($message, $username);
			}
			$filter = Net_LDAP2_Filter::combine('and', array($filter, $configFilter));
		}

		$attributes = $this->options->Attributes();
		Log::Debug('LDAP - Loading user attributes: %s', implode(', ', $attributes));

		$options = array('attributes' => $attributes);

		Log::Debug('Searching ldap for user %s', $username);
		$searchResult = $this->ldap->search(null, $filter, $options);

		if (Net_LDAP2::isError($searchResult))
		{
			$message = 'Could not search ldap for user %s: ' . $searchResult->getMessage();
			Log::Error($message, $username);
		}

		$currentResult = $searchResult->current();
		if ($searchResult->count() == 1 && $currentResult !== false)
		{
			Log::Debug('Found user %s', $username);

			if (!empty($RequiredGroup))
			{
				Log::Debug('LDAP - Required Group: %s', $RequiredGroup);
				$group_filter = Net_LDAP2_Filter::create('uniquemember', 'equals', $currentResult->dn());
				$group_searchResult = $this->ldap->search($RequiredGroup, $group_filter, null);
				if (Net_LDAP2::isError($group_searchResult) && !empty($RequiredGroup))
				{
					$message = 'Could not match Required Group %s: ' . $group_searchResult->getMessage();
					Log::Error($message, $username);
				}

				if ($group_searchResult->count() == 1 && $group_searchResult !== false)
				{
					Log::Debug('Matched Required Group %s', $RequiredGroup);
					/** @var Net_LDAP2_Entry $entry  */
					$this->user = new LdapUser($currentResult, $this->options->AttributeMapping());
				}
			}
			else
			{
				/** @var Net_LDAP2_Entry $entry  */
				$this->user = new LdapUser($currentResult, $this->options->AttributeMapping());
			}
		}
		else
		{
			Log::Debug('Could not find user %s', $username);
		}
	}

	/**
	 * @param $username string
	 * @return LdapUser|null
	 */
	public function GetLdapUser($username)
	{
		return $this->user;
    }
}

?>
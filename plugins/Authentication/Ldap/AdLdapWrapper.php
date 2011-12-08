<?php
require_once(ROOT_DIR . 'plugins/Authentication/Ldap/adLDAP.php');

class AdLdapWrapper implements ILdap
{
	/**
	 * @var LdapOptions
	 */
	private $options;

	/**
	 * @var adLdap|null
	 */
	private $ldap;

	/**
	 * @param LdapOptions $ldapOptions
	 */
	public function __construct($ldapOptions)
	{
		$this->options = $ldapOptions;
	}

	public function Connect()
	{
		$connected = false;
		$attempts = 0;
		$hosts = $this->options->Hosts();
		$options = $this->options->AdLdapOptions();

		while (!$connected && $attempts < count($hosts))
		{
			try
			{
				$options['host'] = $hosts[$attempts];
				$attempts++;
				$this->ldap = new adLdap($options);
				$connected = true;
			}
			catch (adLDAPException $ex)
			{
				Log::Error($ex);
                throw($ex);
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

		/** @var adLDAPUserCollection $entries  */
		$entries = $this->ldap->user()->infoCollection($username, $attributes);
		if (count($entries) > 0)
		{
			return new LdapUser($entries);
		}

		return null;
	}
}
?>
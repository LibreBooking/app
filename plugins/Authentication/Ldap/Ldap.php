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

require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');
require_once(ROOT_DIR . 'plugins/Authentication/Ldap/namespace.php');

/**
 * Provides LDAP authentication/synchronization for phpScheduleIt
 * @see IAuthorization
 */
class Ldap implements IAuthentication
{
	/**
	 * @var IAuthentication
	 */
	private $authToDecorate;

	/**
	 * @var AdLdapWrapper
	 */
	private $ldap;

	/**
	 * @var LdapOptions
	 */
	private $options;

	/**
	 * @var IRegistration
	 */
	private $_registration;

	/**
	 * @var PasswordEncryption
	 */
	private $_encryption;

	/**
	 * @var LdapUser
	 */
	private $user;

	/**
	 * @var string
	 */
	private $password;

	public function SetRegistration($registration)
	{
		$this->_registration = $registration;
	}

	private function GetRegistration()
	{
		if ($this->_registration == null)
		{
			$this->_registration = new Registration();
		}

		return $this->_registration;
	}

	public function SetEncryption($passwordEncryption)
	{
		$this->_encryption = $passwordEncryption;
	}

	private function GetEncryption()
	{
		if ($this->_encryption == null)
		{
			$this->_encryption = new PasswordEncryption();
		}

		return $this->_encryption;
	}


	/**
	 * @param IAuthentication $authentication Authentication class to decorate
	 * @param ILdap $ldapImplementation The actual LDAP implementation to work against
	 * @param LdapOptions $ldapOptions Options to use for LDAP configuration
	 */
	public function __construct(IAuthentication $authentication, $ldapImplementation = null, $ldapOptions = null)
	{
		$this->authToDecorate = $authentication;

		$this->options = $ldapOptions;
		if ($ldapOptions == null)
		{
			$this->options = new LdapOptions();
		}

		$this->ldap = $ldapImplementation;
		if ($ldapImplementation == null)
		{
			$this->ldap = new AdLdapWrapper($this->options);
		}
	}

	public function Validate($username, $password)
	{
		$this->password = $password;

		$connected = $this->ldap->Connect();

        if (!$connected)
        {
            throw new Exception("Could not connect to LDAP server. Please check your LDAP configuration settings");
        }

        $isValid = $this->ldap->Authenticate($username, $password);
        Log::Debug("Result of LDAP Authenticate for user %s: %d", $username, $isValid);

        if ($isValid)
        {
            $this->user = $this->ldap->GetLdapUser($username);
            $userLoaded = $this->LdapUserExists();

            if (!$userLoaded)
            {
                Log::Error("Could not load user details from LDAP. Check your basedn setting. User: %s", $username);
            }
            return $userLoaded;
        }
        else
        {
            if ($this->options->RetryAgainstDatabase())
            {
                return $this->authToDecorate->Validate($username, $password);
            }
        }

		return false;
	}

	public function Login($username, $loginContext)
	{
		if ($this->LdapUserExists())
		{
			$this->Synchronize($username);
		}

		$this->authToDecorate->Login($username, $loginContext);
	}

	public function Logout(UserSession $user)
	{
		$this->authToDecorate->Logout($user);
	}

	public function CookieLogin($cookieValue, $loginContext)
	{
		$this->authToDecorate->CookieLogin($cookieValue, $loginContext);
	}

	public function AreCredentialsKnown()
	{
		return false;
	}

	public function HandleLoginFailure(ILoginPage $loginPage)
	{
		$this->authToDecorate->HandleLoginFailure($loginPage);
	}

	private function LdapUserExists()
	{
		return $this->user != null;
	}

	private function Synchronize($username)
	{
		$registration = $this->GetRegistration();

		$registration->Synchronize(
			new AuthenticatedUser(
                $username,
                $this->user->GetEmail(),
                $this->user->GetFirstName(),
                $this->user->GetLastName(),
                $this->password,
                Configuration::Instance()->GetKey(ConfigKeys::LANGUAGE),
				Configuration::Instance()->GetKey(ConfigKeys::SERVER_TIMEZONE),
				$this->user->GetPhone(), $this->user->GetInstitution(),
                $this->user->GetTitle())
		);
	}
}

?>
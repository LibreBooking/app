<?php
/**
Copyright 2011-2013 Nick Korbel

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
require_once(ROOT_DIR . 'plugins/Authentication/WordPress/namespace.php');

/**
 * Provides WordPress authentication/synchronization for phpScheduleIt
 * @see IAuthorization
 */
class WordPress extends Authentication implements IAuthentication
{
	/**
	 * @var IAuthentication
	 */
	private $authToDecorate;

	/**
	 * @var WordPressOptions
	 */
	private $options;

	/**
	 * @var IRegistration
	 */
	private $_registration;

	/**
	 * @var string
	 */
	private $password;

	/** @var WP_User */
	private $user;

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

	/**
	 * @param IAuthentication $authentication Authentication class to decorate
	 */
	public function __construct(IAuthentication $authentication)
	{
		$this->authToDecorate = $authentication;

		$this->options = new WordPressOptions();

		require_once($this->options->GetPath() . 'pluggable.php');
	}

	public function Validate($username, $password)
	{
		Log::Debug('Attempting to authenticate user against WordPress. User=%s', $username);

		$user = wp_authenticate($username, $password);

        if ($user->exists())
        {
			Log::Debug('WordPress authentication successful. User=%s', $username);
            $this->user = $user;

            return true;
        }
        else
        {
			Log::Debug('WordPress authentication failed. User=%s', $username);
            if ($this->options->RetryAgainstDatabase())
            {
				Log::Debug('WordPress authentication retrying against database');
                return $this->authToDecorate->Validate($username, $password);
            }
        }

		return false;
	}

	public function Login($username, $loginContext)
	{
		$username = $this->CleanUsername($username);
		Log::Debug('ActiveDirectory - Login() in with username: %s', $username);
		if ($this->LdapUserExists())
		{
			Log::Debug('Running ActiveDirectory user synchronization for username: %s, Attributes: %s', $username, $this->user->__toString());
			$this->Synchronize($username);
		}
		else
		{
			Log::Debug('Skipping ActiveDirectory user synchronization, user not loaded');
		}

		return $this->authToDecorate->Login($username, $loginContext);
	}

	public function Logout(UserSession $user)
	{
		$this->authToDecorate->Logout($user);
	}

	public function AreCredentialsKnown()
	{
		return false;
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

	private function CleanUsername($username)
	{
		if (StringHelper::Contains($username, '@'))
		{
			Log::Debug('ActiveDirectory - Username %s appears to be an email address. Cleaning...', $username);
			$parts = explode('@', $username);
			$username = $parts[0];
		}
		if (StringHelper::Contains($username, '\\'))
		{
			Log::Debug('ActiveDirectory - Username %s appears contain a domain. Cleaning...', $username);
			$parts = explode('\\', $username);
			$username = $parts[1];
		}

		return $username;
	}
}

?>
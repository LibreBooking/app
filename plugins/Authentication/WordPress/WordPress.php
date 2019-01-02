<?php
/**
Copyright 2011-2019 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');
require_once(ROOT_DIR . 'plugins/Authentication/WordPress/namespace.php');

/**
 * Provides WordPress authentication/synchronization for Booked Scheduler
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

		require_once($this->options->GetPath() . '../wp-load.php');
		require_once($this->options->GetPath() . 'pluggable.php');

		if (!function_exists('wp_authenticate'))
		{
			throw new Exception('Could not load WordPress authentication hook. Please verify wp_includes.directory config setting');
		}
	}

	public function Validate($username, $password)
	{
		Log::Debug('Attempting to authenticate user against WordPress. User=%s', $username);

		$user = wp_authenticate($username, $password);

		if (is_wp_error($user))
		{
			Log::Error('WordPress authentication error: %s', $user->get_error_message());
			return false;
		}

        if ($user->exists())
        {
			Log::Debug('WordPress authentication successful. User=%s', $username);
            $this->user = $user;
			$this->password = $password;
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
		Log::Debug('WordPress - Login() in with username: %s', $username);
		if ($this->UserExists())
		{
			Log::Debug('Running WordPress user synchronization for username: %s', $username);
			$this->Synchronize();
		}
		else
		{
			Log::Debug('Skipping WordPress user synchronization, user not loaded');
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

	private function UserExists()
	{
		return $this->user != null && $this->user->exists();
	}

	private function Synchronize()
	{
		$registration = $this->GetRegistration();

		Log::Debug('WordPress - Syncing username = %s, email = %s, firstname = %s, lastname = %s',
				   $this->user->user_login,
				   $this->user->user_email,
					$this->user->user_firstname,
					$this->user->user_lastname);

		$registration->Synchronize(
			new AuthenticatedUser(
                $this->user->user_login,
                $this->user->user_email,
                $this->user->user_firstname,
                $this->user->user_lastname,
                $this->password,
                Configuration::Instance()->GetKey(ConfigKeys::LANGUAGE),
				Configuration::Instance()->GetDefaultTimezone(),
				null, null, null)
		);
	}
}
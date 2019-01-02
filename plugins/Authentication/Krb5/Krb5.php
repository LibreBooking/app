<?php
/**
Copyright 2011-2019 Nick Korbel
Copyright 2012-2014 Alois Schloegl

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

class Krb5 extends Authentication implements IAuthentication
{
	private $authToDecorate;
	private $_registration;

	private function GetRegistration()
	{
		if ($this->_registration == null)
		{
			$this->_registration = new Registration();
		}

		return $this->_registration;
	}

	public function __construct(Authentication $authentication)
	{
		$this->authToDecorate = $authentication;
	}

	public function Validate($username, $password)
	{
		$ru = explode('@', $_SERVER['REMOTE_USER']);
		$user = $ru[0];
		$realm = $ru[1];
		## TODO: supported REALM should be obtained from configuration file
		return ($realm == 'IST.LOCAL' || $realm == 'ISTA.LOCAL');
	}

	public function Login($username, $loginContext)
	{
		$ru = explode('@', $_SERVER['REMOTE_USER']);
		$username = $ru[0];
		return $this->authToDecorate->Login($username, $loginContext);
	}

	public function Logout(UserSession $user)
	{
		$this->authToDecorate->Logout($user);
	}

	public function AreCredentialsKnown()
	{
		return (bool)$_SERVER['REMOTE_USER'];
	}

	public function ShowUsernamePrompt()
	{
		return false;
	}

	public function ShowPasswordPrompt()
	{
		return false;
	}

	public function ShowPersistLoginPrompt()
	{
		return false;
	}

	public function ShowForgotPasswordPrompt()
	{
		return false;
	}
}

?>
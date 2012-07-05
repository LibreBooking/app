<?php
/**
Copyright 2011-2012 Nick Korbel
Copyright 2012 Alois Schloegl 

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

class Krb5 implements IAuthentication
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
		$domain = $ru[1];
		## TODO: supported realm should be obtained from configuration file
		if ($domain == 'IST.LOCAL' || $domain == 'ISTA.LOCAL')
		{
			$lu = explode('@', $username);
			return ($lu[0] == $user);
		}
		return false;
	}

	public function Login($username, $loginContext)
	{
		$lu = explode('@', $username);
		$username = $lu[0];

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
		$ru = $_SERVER['REMOTE_USER'];
		if ($ru)
		{
			return (bool)$ru;
		}
		else
		{
			return false;
		}
	}

	public function HandleLoginFailure(ILoginPage $loginPage)
	{
		$this->authToDecorate->HandleLoginFailure($loginPage);
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

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
class FakeWebAuthentication implements IWebAuthentication
{
	/**
	 * @var string
	 */
	public $_LastLogin;
	public $_LastPassword;

	/**
	 * @var ILoginContext
	 */
	public $_LastLoginContext;
	public $_LastLoginId;
	public $_CookieLoginCalled = false;
	public $_LastLoginCookie;
	public $_CookieValidateResult = false;
	public $_LoginCalled = false;

	public $_ValidateResult = false;

	public $_ShowUsernamePrompt = false;
	public $_ShowPasswordPrompt = false;
	public $_ShowPersistLoginPrompt = false;
	public $_ShowForgotPasswordPrompt = false;

	public function Validate($username, $password)
	{
		$this->_LastLogin = $username;
		$this->_LastPassword = $password;

		return $this->_ValidateResult;
	}

	public function Login($username, $context)
	{
		$this->_LoginCalled = true;
		$this->_LastLogin = $username;
		$this->_LastLoginContext = $context;
	}

	public function Logout(UserSession $user)
	{

	}

	public function CookieLogin($cookie, $context)
	{
		$this->_CookieLoginCalled = true;
		$this->_LastLoginCookie = $cookie;
		$this->_LastLoginContext = $context;

		return $this->_CookieValidateResult;
	}

	public function AreCredentialsKnown()
	{
		return true;
	}

	public function HandleLoginFailure(ILoginPage $loginPage)
	{

	}

	/**
	 * @return bool
	 */
	public function ShowUsernamePrompt()
	{
		return $this->_ShowUsernamePrompt;
	}

	/**
	 * @return bool
	 */
	public function ShowPasswordPrompt()
	{
		return $this->_ShowPasswordPrompt;
	}

	/**
	 * @return bool
	 */
	public function ShowPersistLoginPrompt()
	{
		return $this->_ShowPersistLoginPrompt;
	}

	/**
	 * @return bool
	 */
	public function ShowForgotPasswordPrompt()
	{
		return $this->_ShowForgotPasswordPrompt;
	}
}
?>
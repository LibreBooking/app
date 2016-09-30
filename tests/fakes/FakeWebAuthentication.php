<?php
/**
Copyright 2012-2016 Nick Korbel

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

class FakeAuthentication implements IAuthentication
{
	public $_ValidateResult = false;
	public $_UserSession;

	/**
	 * @param string $username
	 * @param string $password
	 * @return bool If user is valid
	 */
	public function Validate($username, $password)
	{
		return $this->_ValidateResult;
	}

	/**
	 * @param string $username
	 * @param ILoginContext $loginContext
	 * @return UserSession
	 */
	public function Login($username, $loginContext)
	{
		return $this->_UserSession;
	}

	/**
	 * @param UserSession $user
	 * @return void
	 */
	public function Logout(UserSession $user)
	{
		// TODO: Implement Logout() method.
	}

	/**
	 * @return bool
	 */
	public function AreCredentialsKnown()
	{
		// TODO: Implement AreCredentialsKnown() method.
	}

	/**
	 * @param IAuthenticationPage $loginPage
	 * @return void
	 */
	public function HandleLoginFailure(IAuthenticationPage $loginPage)
	{
		// TODO: Implement HandleLoginFailure() method.
	}

	/**
	 * @return bool
	 */
	public function ShowUsernamePrompt()
	{
		// TODO: Implement ShowUsernamePrompt() method.
	}

	/**
	 * @return bool
	 */
	public function ShowPasswordPrompt()
	{
		// TODO: Implement ShowPasswordPrompt() method.
	}

	/**
	 * @return bool
	 */
	public function ShowPersistLoginPrompt()
	{
		// TODO: Implement ShowPersistLoginPrompt() method.
	}

	/**
	 * @return bool
	 */
	public function ShowForgotPasswordPrompt()
	{
		// TODO: Implement ShowForgotPasswordPrompt() method.
	}

	/**
	 * @return bool
	 */
	public function AllowUsernameChange()
	{
		// TODO: Implement AllowUsernameChange() method.
	}

	/**
	 * @return bool
	 */
	public function AllowEmailAddressChange()
	{
		// TODO: Implement AllowEmailAddressChange() method.
	}

	/**
	 * @return bool
	 */
	public function AllowPasswordChange()
	{
		// TODO: Implement AllowPasswordChange() method.
	}

	/**
	 * @return bool
	 */
	public function AllowNameChange()
	{
		// TODO: Implement AllowNameChange() method.
	}

	/**
	 * @return bool
	 */
	public function AllowPhoneChange()
	{
		// TODO: Implement AllowPhoneChange() method.
	}

	/**
	 * @return bool
	 */
	public function AllowOrganizationChange()
	{
		// TODO: Implement AllowOrganizationChange() method.
	}

	/**
	 * @return bool
	 */
	public function AllowPositionChange()
	{
		// TODO: Implement AllowPositionChange() method.
	}
}

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
	public $_LogoutCalled = false;
	public $_IsLoggedIn = false;

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
		$this->_LogoutCalled = true;
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

	/**
	 * @return mixed
	 */
	public function IsLoggedIn()
	{
		return $this->_IsLoggedIn;
	}

	/**
	 * @return string
	 */
	public function GetRegistrationUrl()
	{
		return '';
	}

	/**
	 * @return string
	 */
	public function GetPasswordResetUrl()
	{
		return '';
	}
}
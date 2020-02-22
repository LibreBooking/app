<?php
/**
Copyright 2011-2020 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

interface IAuthenticationPage
{
	/**
	 * @return string
	 */
	public function GetEmailAddress();

	/**
	 * @return string
	 */
	public function GetPassword();

	/**
	 * @return void
	 */
	public function SetShowLoginError();
}

interface IAuthentication extends IAuthenticationPromptOptions, IAuthenticationActionOptions
{
	/**
	 * @abstract
	 * @param string $username
	 * @param string $password
	 * @return bool If user is valid
	 */
	public function Validate($username, $password);

	/**
	 * @abstract
	 * @param string $username
	 * @param ILoginContext $loginContext
	 * @return UserSession
	 */
	public function Login($username, $loginContext);

	/**
	 * @param UserSession $user
	 * @return void
	 */
	public function Logout(UserSession $user);

	/**
	 * @return bool
	 */
	public function AreCredentialsKnown();

	/**
	 * @param IAuthenticationPage $loginPage
	 * @return void
	 */
	public function HandleLoginFailure(IAuthenticationPage $loginPage);
}

interface IAuthenticationPromptOptions
{
	/**
	 * @abstract
	 * @return bool
	 */
	public function ShowUsernamePrompt();

	/**
	 * @abstract
	 * @return bool
	 */
	public function ShowPasswordPrompt();

	/**
	 * @abstract
	 * @return bool
	 */
	public function ShowPersistLoginPrompt();

	/**
	 * @abstract
	 * @return bool
	 */
	public function ShowForgotPasswordPrompt();
}

interface IAuthenticationActionOptions
{
	/**
	 * @return bool
	 */
	public function AllowUsernameChange();

	/**
	 * @return bool
	 */
	public function AllowEmailAddressChange();

	/**
	 * @return bool
	 */
	public function AllowPasswordChange();

	/**
	 * @return bool
	 */
	public function AllowNameChange();

	/**
	 * @return bool
	 */
	public function AllowPhoneChange();

	/**
	 * @return bool
	 */
	public function AllowOrganizationChange();

	/**
	 * @return bool
	 */
	public function AllowPositionChange();
}
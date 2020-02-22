<?php
/**
Copyright 2011-2020 Nick Korbel

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

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/PasswordPresenter.php');


interface IPasswordPage extends IPage
{
	public function GetCurrentPassword();
	public function GetPassword();
	public function GetPasswordConfirmation();

	public function ResettingPassword();

	public function ShowResetPasswordSuccess($resetPasswordSuccess);

	/**
	 * @param IAuthenticationActionOptions $authenticationOptions
	 */
	public function SetAllowedActions($authenticationOptions);
}

class PasswordPage extends SecurePage implements IPasswordPage
{
	/**
	 * @var \PasswordPresenter
	 */
	private $presenter;

	public function __construct()
	{
	    parent::__construct('ChangePassword');
		$this->presenter = new PasswordPresenter($this, new UserRepository(), new PasswordEncryption());
	}

	public function PageLoad()
	{
		$this->presenter->PageLoad();
		$this->Display('MyAccount/password.tpl');
	}

	public function GetCurrentPassword()
	{
		return $this->GetRawForm(FormKeys::CURRENT_PASSWORD);
	}

	public function GetPassword()
	{
		return $this->GetRawForm(FormKeys::PASSWORD);
	}

	public function GetPasswordConfirmation()
	{
		return $this->GetRawForm(FormKeys::PASSWORD_CONFIRM);
	}

	public function ResettingPassword()
	{
		$x = $this->GetForm(Actions::CHANGE_PASSWORD);

		return !empty($x);
	}

	public function SetAllowedActions($authenticationOptions)
	{
        $allowPasswordChange = !Configuration::Instance()->GetKey(ConfigKeys::DISABLE_PASSWORD_RESET, new BooleanConverter());
		$this->Set('AllowPasswordChange', $authenticationOptions->AllowPasswordChange() && $allowPasswordChange);
	}

	public function ShowResetPasswordSuccess($resetPasswordSuccess)
	{
		$this->Set('ResetPasswordSuccess', $resetPasswordSuccess);
	}
}
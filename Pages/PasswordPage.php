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

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/PasswordPresenter.php');


interface IPasswordPage extends IPage
{
	public function GetCurrentPassword();
	public function GetPassword();
	public function GetPasswordConfirmation();

	public function ResettingPassword();

	public function ShowResetPasswordSuccess($resetPasswordSuccess);
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
		$this->Display('password.tpl');
	}

	public function GetCurrentPassword()
	{
		return $this->GetForm(FormKeys::CURRENT_PASSWORD);
	}

	public function GetPassword()
	{
		return $this->GetForm(FormKeys::PASSWORD);
	}

	public function GetPasswordConfirmation()
	{
		return $this->GetForm(FormKeys::PASSWORD_CONFIRM);
	}

	public function ResettingPassword()
	{
		$x = $this->GetForm(Actions::CHANGE_PASSWORD);

		return !empty($x);
	}

	public function ShowResetPasswordSuccess($resetPasswordSuccess)
	{
		$this->Set('ResetPasswordSuccess', $resetPasswordSuccess);
	}
}

?>
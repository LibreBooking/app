<?php
/**
Copyright 2011-2015 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Email/Messages/ForgotPasswordEmail.php');

class ForgotPwdPresenter
{
	/**
	 * @var IForgotPwdPage
	 */
	private $_page = null;

	public function __construct(IForgotPwdPage $page)
	{
		$this->_page = $page;
	}

	public function PageLoad()
	{
		if (Configuration::Instance()->GetKey(ConfigKeys::DISABLE_PASSWORD_RESET, new BooleanConverter())
				|| !PluginManager::Instance()->LoadAuthentication()->ShowForgotPasswordPrompt())
		{
			$this->_page->SetEnabled(false);
			return;
		}

		if ($this->_page->ResetClicked())
		{
			$this->SendRandomPassword();
			$this->_page->ShowResetEmailSent(true);
		}
	}

	public function SendRandomPassword()
	{
		$emailAddress = $this->_page->GetEmailAddress();

		Log::Debug('Password reset request for email address %s requested from REMOTE_ADDR: %s REMOTE_HOST: %s', $emailAddress, $_SERVER['REMOTE_ADDR'], $_SERVER['REMOTE_HOST']);

		$temporaryPassword = Password::GenerateRandom();

		$passwordEncryption = new PasswordEncryption();
		$salt = $passwordEncryption->Salt();
		$encrypted = $passwordEncryption->Encrypt($temporaryPassword, $salt);

		$userRepository = new UserRepository();
		$user = $userRepository->FindByEmail($emailAddress);

		if ($user != null)
		{
			$user->ChangePassword($encrypted, $salt);
			$userRepository->Update($user);

			$emailMessage = new ForgotPasswordEmail($user, $temporaryPassword);
			ServiceLocator::GetEmailService()->Send($emailMessage);
		}
	}
}
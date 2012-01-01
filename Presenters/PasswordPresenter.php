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

require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Common/Validators/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

class PasswordPresenter
{
	/**
	 * @var \IPasswordPage
	 */
	private $page;

	/**
	 * @var \IUserRepository
	 */
	private $userRepository;

	/**
	 * @var \PasswordEncryption
	 */
	private $passwordEncryption;

	public function __construct(IPasswordPage $page, IUserRepository $userRepository, PasswordEncryption $passwordEncryption)
	{
		$this->page = $page;
		$this->userRepository = $userRepository;
		$this->passwordEncryption = $passwordEncryption;
	}

	public function PageLoad()
	{
		if ($this->page->ResettingPassword())
		{
			$this->LoadValidators();

			if ($this->page->IsValid())
			{
				$user = $this->GetUser();
				$password = $this->page->GetPassword();
				$encrypted = $this->passwordEncryption->EncryptPassword($password);

				$user->ChangePassword($encrypted->EncryptedPassword(), $encrypted->Salt());
				$this->userRepository->Update($user);

				$this->page->ShowResetPasswordSuccess(true);
			}
		}
	}

	private function LoadValidators()
	{
		$this->page->RegisterValidator('currentpassword', new PasswordValidator($this->page->GetCurrentPassword(), $this->GetUser()));
		$this->page->RegisterValidator('passwordmatch', new EqualValidator($this->page->GetPassword(), $this->page->GetPasswordConfirmation()));
		$this->page->RegisterValidator('passwordcomplexity', new RegexValidator($this->page->GetPassword(), Configuration::Instance()->GetKey(ConfigKeys::PASSWORD_PATTERN)));
	}

	/**
	 * @return User
	 */
	private function GetUser()
	{
		$userId = ServiceLocator::GetServer()->GetUserSession()->UserId;

		return $this->userRepository->LoadById($userId);
	}
}

?>
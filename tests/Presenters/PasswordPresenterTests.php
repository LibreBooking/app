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

require_once(ROOT_DIR . 'Pages/PasswordPage.php');
require_once(ROOT_DIR . 'Presenters/PasswordPresenter.php');

class PasswordPresenterTests extends TestBase
{
	public function testResetsPassword()
	{
		$page = $this->getMock('IPasswordPage');
		$userRepo = $this->getMock('IUserRepository');
		$encryption = $this->getMock('PasswordEncryption');
		$user =  $this->getMock('User');

		$newPassword = 'new password';
		$encryptedValue = 'enc';
		$salt = 'salt';

		$encryptedPassword = new EncryptedPassword($encryptedValue, $salt);

		$presenter = new PasswordPresenter($page, $userRepo, $encryption);

		$page->expects($this->once())
				->method('ResettingPassword')
				->will($this->returnValue(true));

		$page->expects($this->once())
				->method('IsValid')
				->will($this->returnValue(true));

		$page->expects($this->atLeastOnce())
				->method('GetPassword')
				->will($this->returnValue($newPassword));

		$userRepo->expects($this->atLeastOnce())
				->method('LoadById')
				->with($this->equalTo($this->fakeUser->UserId))
				->will($this->returnValue($user));

		$encryption->expects($this->once())
				->method('EncryptPassword')
				->with($this->equalTo($newPassword))
				->will($this->returnValue($encryptedPassword));

		$user->expects($this->once())
				->method('ChangePassword')
				->with($this->equalTo($encryptedValue), $this->equalTo($salt));

		$userRepo->expects($this->once())
				->method('Update')
				->with($this->equalTo($user));

		$page->expects($this->once())
				->method('ShowResetPasswordSuccess')
				->will($this->returnValue(true));

		$presenter->PageLoad();
	}

	public function testPasswordValidatorComparesStoredPasswordAgainstProvidedPassword()
	{
		$passwordEncryption = new PasswordEncryption();
		$salt = $passwordEncryption->Salt();

		$current = "some password";
		$user = new User();

		$encrypted = $passwordEncryption->Encrypt($current, $salt);

		$user->encryptedPassword = $encrypted;
		$user->passwordSalt = $salt;

		$validator = new PasswordValidator($current, $user);

		$validator->Validate();

		$this->assertTrue($validator->IsValid());
	}
}

?>
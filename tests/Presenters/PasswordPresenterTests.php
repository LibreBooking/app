<?php
/**
 * Copyright 2011-2020 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Pages/PasswordPage.php');
require_once(ROOT_DIR . 'Presenters/PasswordPresenter.php');

class PasswordPresenterTests extends TestBase
{
	public function testResetsPassword()
	{
		$this->fakeUser->ForcePasswordReset = true;
		$page = $this->createMock('IPasswordPage');
		$userRepo = new FakeUserRepository();
		$password = new FakePassword();
		$user = new FakeUser();

		$newPassword = 'new password';
		$encryptedValue = 'enc';

		$encryptedPassword = new EncryptedPassword($encryptedValue);
		$userRepo->_User = $user;
		$password->_EncryptedPassword = $encryptedPassword;

		$presenter = new PasswordPresenter($page, $userRepo, $password);

		$page->expects($this->once())
			 ->method('ResettingPassword')
			 ->will($this->returnValue(true));

		$page->expects($this->once())
			 ->method('IsValid')
			 ->will($this->returnValue(true));

		$page->expects($this->atLeastOnce())
			 ->method('GetPassword')
			 ->will($this->returnValue($newPassword));

		$page->expects($this->once())
			 ->method('ShowResetPasswordSuccess')
			 ->will($this->returnValue(true));

		$presenter->PageLoad();

		$this->assertEquals($user, $userRepo->_UpdatedUser);
		$this->assertEquals($encryptedPassword, $user->_Password);
		$this->assertEquals($newPassword, $password->_LastPlainText);
		$this->assertEquals(false, $this->fakeUser->ForcePasswordReset);
	}

	public function testPasswordValidatorComparesStoredPasswordAgainstProvidedPassword()
	{
		$password = new Password();

		$current = "some password";
		$user = new User();

		$encrypted = $password->Encrypt($current);
		$user->ChangePassword($encrypted);

		$validator = new PasswordValidator($current, $user);

		$validator->Validate();

		$this->assertTrue($validator->IsValid());
	}
}
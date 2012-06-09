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

class AccountActivationTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}

	public function testGetsActivationCodeAndSendsEmail()
	{
		$user = new FakeUser(100);
		$activationRepo = $this->getMock('IAccountActivationRepository');
		$userRepo = $this->getMock('IUserRepository');

		$activationRepo->expects($this->once())
					->method('AddActivation')
					->with($this->equalTo($user), $this->anything());
		
		$activation = new AccountActivation($activationRepo, $userRepo);
		$activation->Notify($user);

		$this->assertInstanceOf('AccountActivationEmail', $this->fakeEmailService->_LastMessage);
	}
}

?>
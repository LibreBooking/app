<?php
/**
Copyright 2012 Nick Korbel

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

class AccountActivationTests extends TestBase
{
	/**
	 * @var IAccountActivationRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $activationRepo;

	/**
	 * @var IUserRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $userRepo;

	/**
	 * @var AccountActivation
	 */
	private $activation;

	public function setup()
	{
		parent::setup();

		$this->activationRepo = $this->getMock('IAccountActivationRepository');
		$this->userRepo = $this->getMock('IUserRepository');
		$this->activation = new AccountActivation($this->activationRepo, $this->userRepo);
	}

	public function testGetsActivationCodeAndSendsEmail()
	{
		$user = new FakeUser(100);

		$this->activationRepo->expects($this->once())
				->method('AddActivation')
				->with($this->equalTo($user), $this->anything());
		$this->activation->Notify($user);

		$this->assertInstanceOf('AccountActivationEmail', $this->fakeEmailService->_LastMessage);
	}

	public function testWhenActivationCodeIsValid()
	{
		$userId = 11;
		$homepage = Pages::CALENDAR;
		$user = new FakeUser($userId);
		$user->ChangeDefaultHomePage($homepage);
		$user->SetStatus(AccountStatus::AWAITING_ACTIVATION);

		$activationCode = uniqid();

		$this->activationRepo->expects($this->once())
				->method('FindUserIdByCode')
				->with($this->equalTo($activationCode))
				->will($this->returnValue($userId));

		$this->activationRepo->expects($this->once())
				->method('DeleteActivation')
				->with($this->equalTo($activationCode));

		$this->userRepo->expects($this->once())
				->method('LoadById')
				->with($this->equalTo($userId))
				->will($this->returnValue($user));

		$this->userRepo->expects($this->once())
				->method('Update')
				->with($this->equalTo($user));

		$result = $this->activation->Activate($activationCode);

		$this->assertTrue($result->Activated());
		$this->assertEquals($user, $result->User());
		$this->assertEquals(AccountStatus::ACTIVE, $user->StatusId());
	}

	public function testWhenActivationCodeIsInvalid()
	{
		$activationCode = uniqid();

		$this->activationRepo->expects($this->once())
				->method('FindUserIdByCode')
				->with($this->equalTo($activationCode))
				->will($this->returnValue(null));

		$result = $this->activation->Activate($activationCode);

		$this->assertFalse($result->Activated());
	}
}

?>
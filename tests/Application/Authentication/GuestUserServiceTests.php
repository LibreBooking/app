<?php
/**
 * Copyright 2017-2019 Nick Korbel
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

require_once(ROOT_DIR . 'lib/Application/Authentication/GuestUserService.php');

class GuestUserServiceTests extends TestBase
{
	/**
	 * @var FakeAuthentication
	 */
	private $authentication;

	/**
	 * @var GuestUserService
	 */
	private $service;

	/**
	 * @var FakeRegistration
	 */
	private $registration;

	public function setup()
	{
		$this->authentication = new FakeAuthentication();
		$this->registration = new FakeRegistration();
		$this->service = new GuestUserService($this->authentication, $this->registration);
		parent::setup();
	}

	public function testWhenUserAlreadyExists()
	{
		$email = 'test@email.com';
		$session = new FakeUserSession();
		$this->authentication->_UserSession = $session;

		$user = $this->service->CreateOrLoad($email);
		
		$this->assertEquals($session, $user);
	}

	public function testWhenUserDoesntExistCreateGuest()
	{
		$email = 'guest@user.com';
		$this->authentication->_UserSession = new NullUserSession();

		$this->service->CreateOrLoad($email);

		$this->assertEquals($email, $this->registration->_Login);
		$this->assertEquals($email, $this->registration->_Email);
	}
}
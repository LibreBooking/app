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

require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');

class RegistrationTests extends TestBase
{
	/**
	 * @var Registration
	 */
	private $registration;

	/**
	 * @var FakePasswordEncryption
	 */
	private $fakeEncryption;

	/**
	 * @var IUserRepository
	 */
	private $userRepository;

	private $login = 'testlogin';
	private $email = 'test@test.com';
	private $fname = 'First';
	private $lname = 'Last';
	private $phone = '123.123.1234';
	private $organization = 'organization';
	private $position = 'position';
	private $additionalFields = array();
	private $password = 'password';
	private $timezone = 'US/Eastern';
	private $language = 'en_US';
	private $homepageId = 1;
	private $attributes = array();

	public function setUp()
	{
		parent::setup();

		$this->userRepository = $this->getMock('IUserRepository');

		$this->fakeEncryption = new FakePasswordEncryption();
		$this->registration = new Registration($this->fakeEncryption, $this->userRepository);

		$this->additionalFields = array('phone' => $this->phone, 'organization' => $this->organization, 'position' => $this->position);
		$this->attributes = array(new AttributeValue(1, 1));
	}

	public function tearDown()
	{
		parent::teardown();
		$this->registration = null;
	}

	public function testRegistersUserWhenNoManualActivationRequired()
	{
		$this->fakeConfig->SetKey(ConfigKeys::REGISTRATION_REQUIRE_ACTIVATION, null);

		$user = User::Create($this->fname,
							 $this->lname,
							 $this->email,
							 $this->login,
							 $this->language,
							 $this->timezone,
							 $this->fakeEncryption->_Encrypted,
							 $this->fakeEncryption->_Salt,
							 $this->homepageId);

		$user->ChangeAttributes($this->phone, $this->organization, $this->position);
		$user->ChangeCustomAttributes($this->attributes);

		$this->userRepository->expects($this->once())
				->method('Add')
				->with($this->equalTo($user));

		$registeredUser = $this->registration->Register(
			$this->login,
			$this->email,
			$this->fname,
			$this->lname,
			$this->password,
			$this->timezone,
			$this->language,
			$this->homepageId,
			$this->additionalFields,
			$this->attributes);

		$this->assertTrue($this->fakeEncryption->_EncryptPasswordCalled);
		$this->assertEquals($this->password, $this->fakeEncryption->_LastPassword);
		$this->assertEquals($user, $registeredUser);
	}

	public function testDoesNotActivateUserIfManualActivationIsRequired()
	{
		$this->fakeConfig->SetKey(ConfigKeys::REGISTRATION_REQUIRE_ACTIVATION, 'true');

		$user = User::CreatePending($this->fname,
									$this->lname,
									$this->email,
									$this->login,
									$this->language,
									$this->timezone,
									$this->fakeEncryption->_Encrypted,
									$this->fakeEncryption->_Salt,
									$this->homepageId);

		$user->ChangeAttributes($this->phone, $this->organization, $this->position);
		$user->ChangeCustomAttributes($this->attributes);

		$this->userRepository->expects($this->once())
				->method('Add')
				->with($this->equalTo($user));

		$registeredUser = $this->registration->Register(
			$this->login,
			$this->email,
			$this->fname,
			$this->lname,
			$this->password,
			$this->timezone,
			$this->language,
			$this->homepageId,
			$this->additionalFields,
			$this->attributes);

		$this->assertTrue($this->fakeEncryption->_EncryptPasswordCalled);
		$this->assertEquals($this->password, $this->fakeEncryption->_LastPassword);
		$this->assertEquals($user, $registeredUser);
	}

	public function testAdminRegistrationNeverNeedsActivation()
	{
		$this->fakeConfig->SetKey(ConfigKeys::REGISTRATION_REQUIRE_ACTIVATION, 'true');

		$user = User::Create($this->fname,
									$this->lname,
									$this->email,
									$this->login,
									$this->language,
									$this->timezone,
									$this->fakeEncryption->_Encrypted,
									$this->fakeEncryption->_Salt,
									$this->homepageId);

		$user->ChangeAttributes($this->phone, $this->organization, $this->position);
		$user->ChangeCustomAttributes($this->attributes);

		$this->userRepository->expects($this->once())
				->method('Add')
				->with($this->equalTo($user));

		$adminRegistration = new AdminRegistration($this->fakeEncryption, $this->userRepository);

		$registeredUser = $adminRegistration->Register(
			$this->login,
			$this->email,
			$this->fname,
			$this->lname,
			$this->password,
			$this->timezone,
			$this->language,
			$this->homepageId,
			$this->additionalFields,
			$this->attributes);

		$this->assertTrue($this->fakeEncryption->_EncryptPasswordCalled);
		$this->assertEquals($this->password, $this->fakeEncryption->_LastPassword);
		$this->assertEquals($user, $registeredUser);
	}

	public function testAutoAssignsAllResourcesForThisUser()
	{
		$expectedUserId = 100;
		$this->userRepository->expects($this->once())
				->method('Add')
				->with($this->anything())
				->will($this->returnValue($expectedUserId));

		$this->registration->Register($this->login, $this->email, $this->fname, $this->lname, $this->password, $this->timezone, $this->language, $this->homepageId, $this->additionalFields);

		$command = new AutoAssignPermissionsCommand($expectedUserId);

		$this->assertEquals($command, $this->db->_Commands[0]);
	}

	public function testSynchronizeUpdatesExistingUser()
	{
		$this->db->SetRows(array(true));

		$username = 'un';
		$email = 'em';
		$fname = 'fn';
		$lname = 'ln';
		$phone = 'ph';
		$inst = 'or';
		$title = 'title';
		$encryptedPassword = $this->fakeEncryption->_Encrypted;
		$salt = $this->fakeEncryption->_Salt;

		$user = new AuthenticatedUser($username, $email, $fname, $lname, 'password', 'en_US', 'UTC', $phone, $inst, $title);
		$expectedCommand = new UpdateUserFromLdapCommand($username, $email, $fname, $lname, $encryptedPassword, $salt, $phone, $inst, $title);

		$this->registration->Synchronize($user);

		$this->assertTrue($this->db->ContainsCommand($expectedCommand));
	}

	public function testSynchronizeRegistersNewUser()
	{
		$username = 'un';
		$email = 'em';
		$fname = 'fn';
		$lname = 'ln';
		$phone = 'ph';
		$inst = 'or';
		$title = 'title';
		$langCode = 'en_US';
		$timezone = 'UTC';

		$encryptedPassword = $this->fakeEncryption->_Encrypted;
		$salt = $this->fakeEncryption->_Salt;

		$user = new AuthenticatedUser($username, $email, $fname, $lname, 'password', $langCode, $timezone, $phone, $inst, $title);

		$expectedUser = User::Create($fname,
									 $lname,
									 $email,
									 $username,
									 $langCode,
									 $timezone,
									 $encryptedPassword,
									 $salt,
									 Pages::DEFAULT_HOMEPAGE_ID);

		$expectedUser->ChangeAttributes($phone, $inst, $title);

		$this->userRepository->expects($this->once())
				->method('Add')
				->with($this->equalTo($expectedUser));

		$this->registration->Synchronize($user);
	}
	
	public function testAuthenticatedUserReturnsNullsForAllBlankValues()
	{
		$username = 'un';
		$email = 'em';
		$fname = '';
		$lname = ' ';
		$phone = '   ';
		$inst = 'or';
		$title = 'title';
		$langCode = 'en_US';
		$timezone = 'UTC';

		$user = new AuthenticatedUser($username, $email, $fname, $lname, 'password', $langCode, $timezone, $phone, $inst, $title);

		$this->assertNull($user->FirstName(), "needs to be null to make sure we do not clear values in the database");
		$this->assertNull($user->LastName(), "needs to be null to make sure we do not clear values in the database");
		$this->assertNull($user->Phone(), "needs to be null to make sure we do not clear values in the database");
		$this->assertEquals($email, $user->Email());
	}
}

?>
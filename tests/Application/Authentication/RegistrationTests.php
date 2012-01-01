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

	private $login = 'testlogin';
	private $email = 'test@test.com';
	private $fname = 'First';
	private $lname = 'Last';
	private $additionalFields = array('phone' => '123.123.1234', 'organization' => '', 'position' => '');
	private $password = 'password';
	private $confirm = 'password';
	private $timezone = 'US/Eastern';
	private $language = 'en_US';
	private $homepageId = 1;

	public function setUp()
	{
		parent::setup();

		$this->fakeEncryption = new FakePasswordEncryption();
		$this->registration = new Registration($this->fakeEncryption);
	}

	public function tearDown()
	{
		parent::teardown();
		$this->registration = null;
	}

	public function testRegistersUser()
	{
		$this->registration->Register($this->login, $this->email, $this->fname, $this->lname, $this->password, $this->timezone, $this->language, $this->homepageId, $this->additionalFields);

		$command = new RegisterUserCommand($this->login, $this->email, $this->fname, $this->lname, $this->fakeEncryption->_Encrypted, $this->fakeEncryption->_Salt, $this->timezone, $this->language, $this->homepageId, $this->additionalFields['phone'], $this->additionalFields['organization'], $this->additionalFields['position'], AccountStatus::ACTIVE);

		$this->assertEquals($command, $this->db->_Commands[0]);
		$this->assertTrue($this->fakeEncryption->_EncryptPasswordCalled);
		$this->assertEquals($this->password, $this->fakeEncryption->_LastPassword);
	}

	public function testAutoAssignsAllResourcesForThisUser()
	{
		$expectedUserId = 100;

		$this->db->_ExpectedInsertId = $expectedUserId;
		$this->registration->Register($this->login, $this->email, $this->fname, $this->lname, $this->password, $this->timezone, $this->language, $this->homepageId, $this->additionalFields);

		$command = new AutoAssignPermissionsCommand($expectedUserId);

		$this->assertEquals($command, $this->db->_Commands[1]);
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
		$expectedCommand = new RegisterUserCommand($username, $email, $fname, $lname, $encryptedPassword, $salt, $timezone, $langCode, Pages::DEFAULT_HOMEPAGE_ID, $phone, $inst, $title, AccountStatus::ACTIVE);

		$this->registration->Synchronize($user);

		$this->assertTrue($this->db->ContainsCommand($expectedCommand), 'Expected  ' . $expectedCommand);
	}
}

?>
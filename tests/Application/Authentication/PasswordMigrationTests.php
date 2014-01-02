<?php
/**
Copyright 2011-2014 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class PasswordMigrationTests extends PHPUnit_Framework_TestCase
{
	/**
	 * @var FakeDatabase
	 */
	private $_db;
	private $plaintext = 'password';
	private $newEncryption;
	private $oldEncryption;

	function setup()
	{
		$this->_db = new FakeDatabase();
		ServiceLocator::SetDatabase($this->_db);

		$this->newEncryption = new PasswordEncryption();
		$this->oldEncryption = new RetiredPasswordEncryption();
	}

	function teardown()
	{
		$this->_db = null;
	}

	function testPasswordValidatesWithNewValidationAndDoesNotMigrate()
	{
		$userid = 1;
		$oldpassword = '';
		$salt = $this->newEncryption->Salt();
		$newpassword = $this->newEncryption->Encrypt($this->plaintext, $salt);

		$migration = new PasswordMigration();
		$password = $migration->Create($this->plaintext, $oldpassword, $newpassword);

		$isValid = $password->Validate($salt);

		$this->assertTrue($isValid, 'should have validated against the new password');

		$password->Migrate($userid);
		$this->assertEquals(0, count($this->_db->_Commands));
	}

	function testOldPasswordValidatesWithOldValidatorAndMigrates()
	{
		$userid = 1;
		$fakeEncryption = new FakePasswordEncryption();
		$salt = $fakeEncryption->Salt();

		$oldpassword = $this->oldEncryption->Encrypt($this->plaintext);
		$newpassword = '';

		$migration = new PasswordMigration();
		$password = $migration->Create($this->plaintext, $oldpassword, $newpassword);
		$password->Encryption = $fakeEncryption;

		$isValid = $password->Validate('');

		$this->assertTrue($isValid, 'should have validated against the old password');

		$password->Migrate($userid);
		$encrypted = $fakeEncryption->Encrypt($this->plaintext, $salt);
		$this->assertTrue($this->_db->ContainsCommand(new MigratePasswordCommand($userid, $encrypted, $salt)), "did not migrate the password");
	}
}
?>
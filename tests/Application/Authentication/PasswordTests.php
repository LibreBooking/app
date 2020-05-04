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

require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class PasswordTests extends TestBase
{
	private $plaintext = 'password';
	/**
	 * @var Password
	 */
	private $password;

	public function setup(): void
	{
		parent::setUp();
		$this->password = new Password();
	}

	public function testValidateVersion0Hash()
	{
		$version = 0;
		$encrypted = $this->password->Encrypt($this->plaintext, $version);
		$isValid = $this->password->Validate($this->plaintext, $encrypted->EncryptedPassword(), $version, $encrypted->Salt());
		$isNotValid = $this->password->Validate("wrong", $encrypted->EncryptedPassword(), $version, $encrypted->Salt());

		$this->assertTrue($isValid);
		$this->assertFalse($isNotValid);
	}

	public function testValidateVersion1Hash()
	{
		$version = Password::$CURRENT_HASH_VERSION;
		$encrypted = $this->password->Encrypt($this->plaintext, $version);
		$isValid = $this->password->Validate($this->plaintext, $encrypted->EncryptedPassword(), $version, $encrypted->Salt());
		$isNotValid = $this->password->Validate("wrong", $encrypted->EncryptedPassword(), $version, $encrypted->Salt());

		$this->assertTrue($isValid);
		$this->assertFalse($isNotValid);
	}

	public function testMigrateVersion0Hash()
	{
		$userId = 1;
		$this->password->Migrate($userId, $this->plaintext, 0);

		$this->assertInstanceOf("MigratePasswordCommand", $this->db->_LastCommand);
	}

	public function testMigrateVersion1Hash() {
		$userId = 1;
		$this->password->Migrate($userId, $this->plaintext, Password::$CURRENT_HASH_VERSION);

		$this->assertCount(0, $this->db->_Commands);
	}
}
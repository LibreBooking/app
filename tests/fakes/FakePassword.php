<?php
/**
 * Copyright 2020 Nick Korbel
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

class FakePassword implements IPassword
{
	public $_ValidateCalled = false;
	public $_MigrateCalled = false;
	public $_LastSalt;
	public $_MigrateUserId;
	public $_MigratePlainText;
	public $_MigrateHashVersion;
	public $_ValidateResult = false;
	public $_LastEncrypted;
	public $_LastPlainText;
	public $_LastHashVersion;
	public $_EncryptCalled = false;
	/**
	 * @var EncryptedPassword | null
	 */
	public $_EncryptedPassword;

	public function Validate(string $plainText, string $encrypted, ?int $hashVersion = null, ?string $salt = null)
	{
		$this->_ValidateCalled = true;

		$this->_LastPlainText = $plainText;
		$this->_LastEncrypted = $encrypted;
		$this->_LastSalt = $salt;
		$this->_LastHashVersion = $hashVersion;

		return $this->_ValidateResult;
	}

	public function Migrate($userId, $plainText, $passwordHashVersion)
	{
		$this->_MigrateCalled = true;
		$this->_MigrateUserId = $userId;
		$this->_MigratePlainText = $plainText;
		$this->_MigrateHashVersion = $passwordHashVersion;
	}

	public function Encrypt(string $plaintext, ?int $hashVersion = null)
	{
		$this->_LastPlainText = $plaintext;
		$this->_EncryptCalled = true;
		return $this->_EncryptedPassword;
	}
}

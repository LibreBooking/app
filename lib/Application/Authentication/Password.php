<?php
/**
 * Copyright 2011-2020 Nick Korbel
 *
 * This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

interface IPassword
{
	/**
	 * @param $plainText string
	 * @param $encrypted string
	 * @param $hashVersion int|null
	 * @param $salt string|null
	 * @return bool
	 */
	public function Validate(string $plainText, string $encrypted, int $hashVersion = null, string $salt = null);

	/**
	 * @param $userId int
	 * @param $plainText string
	 * @param $passwordHashVersion int
	 * @return void
	 */
	public function Migrate($userId, $plainText, $passwordHashVersion);

	/**
	 * @param string $plainText
	 * @param int|null $hashVersion
	 * @return EncryptedPassword
	 */
	public function Encrypt(string $plainText, int $hashVersion = null);
}

class Password implements IPassword
{
	public static $CURRENT_HASH_VERSION = 1;

	/**
	 * @internal
	 * @var null|string
	 */
	public static $_Random = null;

	public function Validate(string $plainText, string $encrypted, int $hashVersion = null, string $salt = null)
	{
		$encryption = $this->GetEncryption($hashVersion);
		return $encryption->IsMatch($plainText, $encrypted, $salt);
	}

	public function Migrate($userId, $plainText, $passwordPasswordHashVersion)
	{
		if ($passwordPasswordHashVersion === self::$CURRENT_HASH_VERSION) {
			return;
		}

		$encryption = $this->GetEncryption();
		$encrypted = $encryption->EncryptPassword($plainText);

		ServiceLocator::GetDatabase()->Execute(new MigratePasswordCommand($userId, $encrypted->EncryptedPassword(), self::$CURRENT_HASH_VERSION));
	}

	private function GetEncryption(int $hashVersion = null)
	{
		$version = $hashVersion === null ? self::$CURRENT_HASH_VERSION : $hashVersion;
		if ($version == 0)
		{

			return new PasswordEncryption();
		}

		return new PasswordEncryptionV1();
	}


	/**
	 * @param string $plainText
	 * @param int|null $hashVersion
	 * @return EncryptedPassword
	 */
	public function Encrypt(string $plainText, int $hashVersion = null)
	{
		$encryption = $this->GetEncryption($hashVersion);
		return $encryption->EncryptPassword($plainText);
	}

	/**
	 * @static
	 * @return string
	 */
	public static function GenerateRandom()
	{
		if (self::$_Random != null)
		{
			return self::$_Random;
		}

		$length = 10;
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@#$%';
		$password = '';
		$max = strlen($characters) - 1;

		for ($i = 0; $i < $length; $i++)
		{
			$password .= $characters[mt_rand(0, $max)];
		}

		return $password;
	}
}
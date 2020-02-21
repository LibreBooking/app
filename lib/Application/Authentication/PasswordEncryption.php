<?php
/**
Copyright 2011-2020 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

class PasswordEncryption
{
	/**
	 * @internal only for testing, use EncryptPassword
	 * @param $password
	 * @param $salt
	 * @return string
	 */
	public function Encrypt($password, $salt)
	{
		return sha1($password . $salt);
	}

	/**
	 * @param $plainTextPassword string
	 * @return EncryptedPassword
	 */
	public function EncryptPassword($plainTextPassword)
	{
		$salt = $this->Salt();

		$encrypted = $this->Encrypt($plainTextPassword, $salt);
		return new EncryptedPassword($encrypted, $salt);
	}

	public function Salt()
	{
		return substr( str_pad( dechex( mt_rand() ), 8, '0', STR_PAD_LEFT ), -8 );
	}
}

class RetiredPasswordEncryption
{
	public function Encrypt($password)
	{
		return md5($password);
	}
}

class EncryptedPassword
{
	/**
	 * @var string
	 */
	private $encryptedPassword;

	/**
	 * @var string
	 */
	private $salt;

	/**
	 * @param $encryptedPassword string
	 * @param $salt string
	 */
	public function __construct($encryptedPassword, $salt)
	{
		$this->encryptedPassword = $encryptedPassword;
		$this->salt = $salt;
	}

	/**
	 * @return string
	 */
	public function EncryptedPassword()
	{
		return $this->encryptedPassword;
	}

	/**
	 * @return string
	 */
	public function Salt()
	{
		return $this->salt;
	}

}
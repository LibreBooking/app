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

class EncryptedPassword
{
	/**
	 * @var string
	 */
	private $encryptedPassword;

	/**
	 * @var string|null
	 */
	private $salt;

	/**
	 * @var int
	 */
	private $version;

	/**
	 * @param $encryptedPassword string
	 * @param $salt string
	 * @param int $version
	 */
	public function __construct(string $encryptedPassword, string $salt = null, int $version = null)
	{
		$this->encryptedPassword = $encryptedPassword;
		$this->salt = $salt;
		$this->version = $version === null ? Password::$CURRENT_HASH_VERSION : $version;
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

	/**
	 * @return int
	 */
	public function Version() {
		return $this->version;
	}
}
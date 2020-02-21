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


interface IPassword
{
	/**
	 * @abstract
	 * @param $salt string
	 * @return bool
	 */
	public function Validate($salt);

	/**
	 * @abstract
	 * @param $userid int
	 * @return void
	 */
	public function Migrate($userid);
}

class PasswordMigration
{
	/**
	 * @param $plaintext
	 * @param $oldpassword
	 * @param $newpassword
	 * @return IPassword
	 */
	public function Create($plaintext, $oldpassword, $newpassword)
	{
		if (!empty($newpassword))
		{
			return new Password($plaintext, $newpassword);
		}
		return new OldPassword($plaintext, $oldpassword, new RetiredPasswordEncryption());
	}
}

class Password implements IPassword
{
    /**
     * @internal
     * @var null|string
     */
    public static $_Random = null;

    /**
	 * @var \PasswordEncryption
	 */
	public $Encryption;

	/**
	 * @var string
	 */
	protected $plaintext;

	/**
	 * @var string
	 */
	protected $encrypted;

	/**
	 * @param $plaintext string
	 * @param $encrypted string
	 */
	public function __construct($plaintext, $encrypted)
	{
		$this->plaintext = $plaintext;
		$this->encrypted = $encrypted;

		$this->Encryption = new PasswordEncryption();
	}

	/**
	 * @return string
	 */
	public function PlainText()
	{
		return $this->plaintext;
	}

	/**
	 * @return string
	 */
	public function Encrypted()
	{
		return $this->encrypted;
	}

	public function Validate($salt)
	{
		$encrypted = $this->Encryption->Encrypt($this->plaintext, $salt);

		return $this->encrypted == $encrypted;
	}

	public function Migrate($userid)
	{
		// noop
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
		$password ='';
		$max = strlen($characters) - 1;

		for ($i = 0; $i < $length; $i++)
		{
			$password .= $characters[mt_rand(0, $max)];
		}

    	return $password;
	}
}

class OldPassword extends Password
{
	public $RetiredPasswordEncryption;

	public function __construct($plaintext, $encrypted)
	{
		$this->RetiredPasswordEncryption = new RetiredPasswordEncryption();
		parent::__construct($plaintext, $encrypted);
	}

	public function Validate($salt)
	{
		return $this->encrypted == $this->RetiredPasswordEncryption->Encrypt($this->plaintext);
	}

	public function Migrate($userid)
	{
		$salt = $this->Encryption->Salt();
		$encrypted = $this->Encryption->Encrypt($this->plaintext, $salt);
		ServiceLocator::GetDatabase()->Execute(new MigratePasswordCommand($userid, $encrypted, $salt));
		ServiceLocator::GetDatabase()->Execute(new RemoveLegacyPasswordCommand($userid));
	}
}
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

class FakePasswordEncryption extends PasswordEncryption
{
	public $_Salt = '123';
	public $_EncryptCalled = false;
	public $_EncryptPasswordCalled = false;
	public $_LastPassword;
	public $_LastSalt;
	public $_Encrypted = 'encryptedpw';
	
	public function Encrypt($password, $salt)
	{
		$this->_EncryptCalled = true;
		$this->_LastPassword = $password;
		$this->_LastSalt = $salt;
		
		return $this->_Encrypted;
	}

	public function EncryptPassword($password)
	{
		$this->_EncryptPasswordCalled = true;
		$this->_LastPassword = $password;

		return new EncryptedPassword($this->_Encrypted, $this->_Salt);
	}
	
	public function Salt()
	{
		return $this->_Salt;
	}
}
?>
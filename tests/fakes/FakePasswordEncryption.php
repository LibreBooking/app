<?php
//require_once('../../lib/Authorization/namespace.php');

class FakePasswordEncryption extends PasswordEncryption
{
	public $_Salt = '123';
	public $_EncryptCalled = false;
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
	
	public function Salt()
	{
		return $this->_Salt;
	}
}
?>
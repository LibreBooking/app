<?php
require_once(ROOT_DIR . 'lib/Application/Authorization/namespace.php');

class PasswordEncryptionTests extends PHPUnit_Framework_TestCase
{
	public function testGeneratesSaltAndHashesPassword()
	{
		$password = 'mypassword';
		
		$encryption = new PasswordEncryption();
		$salt = $encryption->Salt();
		$actualEncryptedPassword = $encryption->Encrypt($password, $salt);

		$expectedEncryptedPassword = sha1($password . $salt);
		
		$this->assertEquals($expectedEncryptedPassword, $actualEncryptedPassword, "Password was not encrypted correctly");
	}
}
?>
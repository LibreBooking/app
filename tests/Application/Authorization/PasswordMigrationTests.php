<?php
require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class PasswordMigrationTests extends PHPUnit_Framework_TestCase
{
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
		$this->assertEquals(new MigratePasswordCommand($userid, $encrypted, $salt), $this->_db->_LastCommand, "did not migrate the password");
	}
}
?>
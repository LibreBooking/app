<?php
require_once('PHPUnit/Framework.php');
require_once('../lib/Authorization/namespace.php');
require_once('../lib/Common/namespace.php');
require_once('fakes/DBFakes.php');

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
		$oldpassword = '';
		$salt = $this->newEncryption->Salt();		
		$newpassword = $this->newEncryption->Encrypt($this->plaintext, $salt);		
	
		$password = PasswordMigration::Create($this->plaintext, $oldpassword, $newpassword);
		
		$isValid = $password->Validate($salt);

		$this->assertTrue($isValid, 'should have validated against the new password');
		
		$password->Migrate($userid);
		$this->assertEquals(0, count($this->db->_Commands));
	}
	
	function testOldPasswordValidatesWithOldValidatorAndMigrates()
	{
		$fakeEncryption = new FakePasswordEncryption();
		$salt = $fakeEncryption->Salt();
		
		$oldpassword = $this->oldEncryption->Encrypt($this->plaintext);	
		$newpassword = '';
		
		$password = PasswordMigration::Create($this->plaintext, $oldpassword, $newpassword);
		$password->Encryption = $fakeEncryption;
		
		$isValid = $password->Validate('');

		$this->assertTrue($isValid, 'should have validated against the old password');
		
		$password->Migrate($userid);
		$encrypted = $fakeEncryption->Encrypt($this->plaintext, $salt);
		$this->assertEquals(new MigratePasswordCommand($userid, $encrypted, $salt), $this->_db->_LastCommand, "did not migrate the password");
	}
}

class FakePasswordEncryption extends PasswordEncryption
{
	public $_Salt = '123';
	
	public function Salt()
	{
		return $this->_Salt;
	}
}

interface IPassword
{
	public function Validate($salt);
	public function Migrate($userid);
}

class PasswordMigration
{		
	public static function Create($plaintext, $oldpassword, $newpassword)
	{		
		if (!empty($oldpassword))
		{
			return new OldPassword($plaintext, $oldpassword, new RetiredPasswordEncryption());
		}
		return new Password($plaintext, $newpassword);		
	}
}

class Password implements IPassword
{
	public $Encryption;
	
	protected $plaintext; 
	protected $encrypted;
	
	public function __construct($plaintext, $encrypted)
	{
		$this->plaintext = $plaintext;	
		$this->encrypted = $encrypted;
		
		$this->Encryption = new PasswordEncryption();
	}
	
	public function Validate($salt)
	{
		return $this->encrypted == $this->Encryption->Encrypt($this->plaintext, $salt);
	}
	
	public function Migrate($userid)
	{
		// noop
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
	}	
}

?>
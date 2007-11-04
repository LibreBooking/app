<?php

interface IPassword
{
	public function Validate($salt);
	public function Migrate($userid);
}

class PasswordMigration
{		
	public function Create($plaintext, $oldpassword, $newpassword)
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
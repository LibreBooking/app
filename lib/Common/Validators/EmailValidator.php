<?php
//require_once('IValidator.php');

class EmailValidator implements IValidator
{
	private $email;
	
	public function __construct($email)
	{
		$this->email = $email;
	}
	
	public function IsValid()
	{
		return eregi("^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$", $this->email);
	}
}

?>
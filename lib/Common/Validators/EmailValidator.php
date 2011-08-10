<?php

class EmailValidator extends ValidatorBase implements IValidator 
{
	private $email;
	
	public function __construct($email)
	{
		$this->email = $email;
	}

	public function Validate()
	{
		$this->isValid = preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $this->email);
	}
}

?>
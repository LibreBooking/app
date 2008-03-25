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
		$this->isValid = eregi("^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$", $this->email);
	}
}

?>
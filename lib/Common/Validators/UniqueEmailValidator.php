<?php

class UniqueEmailValidator extends ValidatorBase implements IValidator 
{
	private $_email;
	private $_userid;
	
	public function __construct($email, $userid = null)
	{
		$this->_email = $email;
		$this->_userid = $userid;
	}
	
	public function Validate()
	{
		$this->isValid = true;
		$results = ServiceLocator::GetDatabase()->Query(new CheckEmailCommand($this->_email));
		
		if ($row = $results->GetRow())
		{
			$this->isValid = ($row[ColumnNames::USER_ID] == $this->_userid);
		}
	}
}
?>
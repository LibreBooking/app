<?php

class UniqueEmailValidator implements IValidator
{
	private $_email;
	private $_userid;
	
	public function __construct($email, $userid = null)
	{
		$this->_email = $email;
		$this->_userid = $userid;
	}
	
	public function IsValid()
	{
		$results = ServiceLocator::GetDatabase()->Query(new CheckEmailCommand($this->_email));
		
		if ($row = $results->GetRow())
		{
			return $row[ColumnNames::USER_ID] == $this->_userid;
		}
		
		return true;
	}
}
?>
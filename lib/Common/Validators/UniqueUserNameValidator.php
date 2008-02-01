<?php

class UniqueUserNameValidator implements IValidator
{
	private $_username;
	private $_userid;
	
	public function __construct($username, $userid = null)
	{
		$this->_username = $username;
		$this->_userid = $userid;
	}
	
	public function IsValid()
	{
		$results = ServiceLocator::GetDatabase()->Query(new CheckUsernameCommand($this->_username));
		
		if ($row = $results->GetRow())
		{
			return $row[ColumnNames::USER_ID] == $this->_userid;
		}
		
		return true;
	}
}
?>
<?php
class UniqueUserNameValidator  extends ValidatorBase implements IValidator 
{
	private $_username;
	private $_userid;
	
	public function __construct($username, $userid = null)
	{
		$this->_username = $username;
		$this->_userid = $userid;
	}
	
	public function Validate()
	{
		$this->isValid = true;
		$results = ServiceLocator::GetDatabase()->Query(new CheckUsernameCommand($this->_username));
		
		if ($row = $results->GetRow())
		{
			$this->isValid = ($row[ColumnNames::USER_ID] == $this->_userid);
		}
	}
}
?>
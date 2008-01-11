<?php
interface IUser
{	
	public function Populate(&$db);
	
	public function Persist(&$db);
	
	public function SetProperty($name, $value);
}

class UserSession
{
	private $_id = '';
	public $FirstName = '';
	public $LastName = '';
	public $Email = '';
	public $IsAdmin = false;
	public $Timezone = '';
	
	public function __construct($id)
	{
		$this->_id = $id;
	}
}
?>
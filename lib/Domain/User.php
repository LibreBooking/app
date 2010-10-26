<?php
class User
{
	public function FirstName()
	{
		return $this->firstName;
	}
	
	public function WantsEventEmail($event)
	{
		return true;
	}
	
	public static function FromRow($row)
	{
		$user = new User();
		$user->firstName = $row[ColumnNames::FIRST_NAME];
		
		return $user;
	}
}
?>
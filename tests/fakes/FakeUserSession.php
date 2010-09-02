<?php

class FakeUserSession extends UserSession 
{
	public function __construct($isAdmin = false, $timezone = 'US/Eastern', $userId = 1)
	{
		parent::__construct($userId);
		
		$this->FirstName = 'first';
		$this->LastName = 'last';
		$this->Email = 'first.last@email.com';
		$this->IsAdmin = $isAdmin;
		$this->Timezone = $timezone;
		$this->HomepageId = 1;
	}
}
?>
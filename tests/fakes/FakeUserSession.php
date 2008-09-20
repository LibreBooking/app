<?php

class FakeUserSession extends UserSession 
{
	public function __construct($isAdmin = false, $timezone = 'US/Eastern')
	{
		parent::__construct(1);
		
		$this->FirstName = 'first';
		$this->LastName = 'last';
		$this->Email = 'first.last@email.com';
		$this->IsAdmin = $isAdmin;
		$this->Timezone = $timezone;
		$this->HomepageId = 1;
	}
}
?>
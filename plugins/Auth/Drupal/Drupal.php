<?php

require_once(ROOT_DIR . 'lib/Authorization/namespace.php');

class Drupal implements IAuthorization
{
	public function Validate($username, $password)
	{
		flag = true;
	
		return flag;
	}
	
	public function Login($username, $password)
	{
	
	}
	
	public function CookieLogin($cookieValue)
	{
		
	}
	
}

?>
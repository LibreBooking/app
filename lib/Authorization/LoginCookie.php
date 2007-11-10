<?php
require_once('namespace.php');
require_once('../Common/namespace.php');

class LoginCookie extends Cookie
{
	public function __construct($userid, $lastLoginTime)
	{
		parent::__construct(CookieKeys::PERSIST_LOGIN, sprintf('%s|%s', $userid, $lastLoginTime));
	}
	
	public static function GetUserID($cookieValue)
	{
		$cookieParts = split('|', $cookieValue);
		
		if ($cookieParts == 2)
		{
			return $cookieParts[0];
		}
		
		return null;
	}
}

?>
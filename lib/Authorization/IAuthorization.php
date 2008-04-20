<?php
interface IAuthorization
{
	/**
	 * @return bool If user is valid
	 */
	public function Validate($username, $password);
	
	/**
	 * @return void
	 */
	public function Login($username, $persist);
	
	/**
	 * @return void
	 */
	public function CookieLogin($cookieValue);
}
?>
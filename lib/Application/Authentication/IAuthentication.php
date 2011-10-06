<?php
interface IAuthentication
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
	public function Logout(UserSession $user);
	
	/**
	 * @return void
	 */
	public function CookieLogin($cookieValue);
	
	/**
	 * @return bool
	 */
	public function AreCredentialsKnown();
	
	/**
	 * @return void
	 */
	public function HandleLoginFailure(ILoginPage $loginPage);
}
?>
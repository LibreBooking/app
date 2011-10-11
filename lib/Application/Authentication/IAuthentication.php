<?php
interface IAuthentication
{
	/**
	 * @abstract
	 * @param string $username
	 * @param string $password
	 * @return bool If user is valid
	 */
	public function Validate($username, $password);
	
	/**
	 * @abstract
	 * @param string $username
	 * @param bool $persist whether or not to persist login across sessions
	 * @return void
	 */
	public function Login($username, $persist);
	
	/**
	 * @param UserSession $user
	 * @return void
	 */
	public function Logout(UserSession $user);
	
	/**
	 * @param string $cookieValue phpScheduleIt authentication cookie value
	 * @return void
	 */
	public function CookieLogin($cookieValue);
	
	/**
	 * @return bool
	 */
	public function AreCredentialsKnown();
	
	/**
	 * @param ILoginPage $loginPage
	 * @return void
	 */
	public function HandleLoginFailure(ILoginPage $loginPage);
}
?>
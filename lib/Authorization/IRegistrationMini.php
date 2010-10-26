<?php
interface IRegistrationMini
{
	/**
	 * @param string $login
	 * @param string $email
	 * @param string $firstName
	 * @param string $lastName
	 * @param string $password unencrypted password
     * @param string $timezone name of timezone
     * @param string $language preferred language code
	 */
  public function RegisterMini($login, $email, $firstName, $lastName, $password, $timezone, $language);
	
	/**
	 * @param string $loginName
	 * @param string $emailAddress
	 * @return bool if the user exists or not
	 */
	public function UserExists($loginName, $emailAddress);
}
?>
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
	 * @param string $homepageId id number of homepage TODO fix this to default to 1 in db
	 */
  public function Register($login, $email, $firstName, $lastName, $password, $timezone, $homepageId);
	
	/**
	 * @param string $loginName
	 * @param string $emailAddress
	 * @return bool if the user exists or not
	 */
	public function UserExists($loginName, $emailAddress);
}
?>
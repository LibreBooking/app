<?php
interface IRegistration
{
	/**
	 * @param string $login
	 * @param string $email
	 * @param string $firstName
	 * @param string $lastName
	 * @param string $password unencrypted password
	 * @param string $timezone name of user timezone
	 * @param array $additionalFields key value pair of additional fields to use during registration
	 */
	public function Register($login, $email, $firstName, $lastName, $password, $timezone, $additionalFields = array());
	
	/**
	 * @param string $loginName
	 * @param string $emailAddress
	 * @return bool if the user exists or not
	 */
	public function UserExists($loginName, $emailAddress);
}
?>
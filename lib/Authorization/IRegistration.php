<?php
interface IRegistration
{
	public function Register($login, $email, $firstName, $lastName, $password, $timezone, $additionalFields = array());
	
	public function UserExists($loginName, $emailAddress);
}
?>
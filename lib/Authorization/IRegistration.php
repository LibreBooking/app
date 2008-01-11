<?php
interface IRegistration
{
	public function Register($login, $email, $firstName, $lastName, $password, $confirm, $timezone, $additionalFields = array());
	
	public function UserExists($loginName, $emailAddress);
}
?>
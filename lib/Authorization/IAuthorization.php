<?php
interface IAuthorization
{
	public function Validate($username, $password);
	
	public function Login($username, $persist);
}
?>
<?php

class AuthenticationRequest
{
	/**
	 * @var string
	 */
	public $username;
	/**
	 * @var string
	 */
	public $password;

	/**
	 * @param string $username
	 * @param string $password
	 */
	public function __construct($username = null, $password = null)
	{
		$this->username = $username;
		$this->password = $password;
	}
}

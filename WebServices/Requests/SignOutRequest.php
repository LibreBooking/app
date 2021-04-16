<?php

class SignOutRequest
{
	/**
	 * @var string
	 */
	public $userId;
	/**
	 * @var string
	 */
	public $sessionToken;

	/**
	 * @param string $userId
	 * @param string $sessionToken
	 */
	public function __construct($userId = null, $sessionToken = null)
	{
		$this->userId = $userId;
		$this->sessionToken = $sessionToken;
	}
}


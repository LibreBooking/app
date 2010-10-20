<?php
require_once(ROOT_DIR . 'lib/Authorization/namespace.php');

class Drupal implements IAuthorization
{
	/**
	 * @var IAuthorization
	 */
	private $authToDecorate;
	
	/**
	 * @var IRegistration
	 */
	private $_registration;

	/**
	* Needed to register user if they are logging in to Drupal but do not have a phpScheduleIt account yet
	*/
	private function GetRegistration()
	{
		if ($this->_registration == null)
		{
			$this->_registration = new Registration();
		}
		
		return $this->_registration;
	}
	
	/**
	 * @param IAuthorization $authorization Authorization class to decorate
	 */
	public function __construct($authorization = null)
	{
		$this->authToDecorate = $authorization; 
		if ($authorization == null)
		{
			$this->authToDecorate = new Authorization();
		}
	}
	
	/**
	* Called first to validate credentials
	* @see IAuthorization::Validate()
	*/
	public function Validate($username, $password)
	{
		// Auth against Drupal
		// Optionally auth against phpScheduleIt
		return $isValid;
	}
	
	/**
	* Called after Validate returns true
	* @see IAuthorization::Login()
	*/
	public function Login($username, $persist)
	{
		// Synchronize account information from Drupal
		
		// Always call decorated Authorization so proper phpScheduleIt functionality is executed
		$this->authToDecorate->Login($username, $persist);
	}
	
	/**
	 * @see IAuthorization::CookieLogin()
	 */
	public function CookieLogin($cookieValue)
	{
		// Do anything Drupal-specific
		
		// Always call decorated Authorization so proper phpScheduleIt functionality is executed
		$this->authToDecorate->CookieLogin(cookieValue);
	}
}

?>
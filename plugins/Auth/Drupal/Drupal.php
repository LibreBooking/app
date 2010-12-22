<?php
require_once('/Drupal.config.php');
require_once(ROOT_DIR . 'lib/Application/Authorization/namespace.php');


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
	   $isValid = false;
	   // Auth against Drupal
       // Make Drupal PHP' s current directory.
       chdir(DRUPAL_DIRECTORY);
       
       // Bootstrap Drupal up through the database phase so that we can query it
       include_once(DRUPAL_DIRECTORY . '/includes/bootstrap.inc');
       drupal_bootstrap(DRUPAL_BOOTSTRAP_DATABASE);
        
       //Query the database to see if this user is valid
       $result = db_result(db_query('SELECT uid FROM {users} WHERE uid = %d', $username));
        
       if($result)
       {//If that user exists, check to see if the password is correct
           $result = db_result(db_query('SELECT pass FROM {users} WHERE uid = %d', $username));
           if(md5($password) == $result)
                $isValid = true;
       }
        
        //TODO: Optionally auth against phpScheduleIt.
        //MPinnegar - I don't think we should auth against phpSched. Shouldn't we be authorizing exclusively against the Drupal install?
		return $isValid;
	}
	
	/**
	* Called after Validate returns true
	* @see IAuthorization::Login()
	*/
	public function Login($username, $persist)
	{
		// Synchronize account information from Drupal
            //The only thing Drupal really has is the user's e-mail address. Could syncronize that?
        
        //MPinnegar - I assume I don't do anything with persist, that's only used by another wrapper?
        
		// Always call decorated Authorization so proper phpScheduleIt functionality is executed
		$this->authToDecorate->Login($username, $persist);
	}
	
	/**
	 * @see IAuthorization::CookieLogin()
	 */
	public function CookieLogin($cookieValue)
	{
		// Do anything Drupal-specific
		  //MPinnegar - I don't think we need to do anything specific to Drupal? It shouldn't care about cookies set by phpScheduleIt
		// Always call decorated Authorization so proper phpScheduleIt functionality is executed
		$this->authToDecorate->CookieLogin(cookieValue);
	}
	
	/**
	 * @see IAuthorization::AreCredentialsKnown()
	 */
	public function AreCredentialsKnown()
	{
		return false;
	}
	
	/**
	 * @see IAuthorization::HandleLoginFailure()
	 */
	public function HandleLoginFailure(ILoginPage $loginPage)
	{
		$this->authToDecorate->HandleLoginFailure($loginPage);
	}
}

?>
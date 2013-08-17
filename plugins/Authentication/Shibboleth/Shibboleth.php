<?php
/**
Copyright 2013 Tom Francart

*/

require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');

/**
 * Provides LDAP authentication/synchronization for phpScheduleIt
 * @see IAuthorization
 */
class Shibboleth extends Authentication implements IAuthentication
{
	private $authToDecorate;
	private $_registration;


	private function GetRegistration()
	{
		if ($this->_registration == null)
		{
			$this->_registration = new Registration();
		}

		return $this->_registration;
	}


	/**
	 * @param IAuthentication $authentication Authentication class to decorate
	 */
	public function __construct(IAuthentication $authentication)
	{
	    $this->authToDecorate = $authentication;
//	    error_log('Shibboleth constructed');
	}

	public function Validate($username, $password)
	{
//	    error_log('Validate ran');
	    if (!isset ($_SERVER['Shib-Person-uid']) ) {
		error_log( "Shib does not work");
		return false;
	    } else {
	        return true;	// shibboleth let us in, so it's always fine
	    }
	}

	public function Login($username, $loginContext)
	{
//	    error_log('Login');
	    // Get data from shibboleth
	    $mail = $_SERVER['Shib-Person-mail'];

	    $uid = $_SERVER['Shib-Person-uid'];
	    $fname = $_SERVER['Shib-Person-givenName'];
	    $lname = $_SERVER['Shib-Person-surname'];
	    $phone = $_SERVER['Shib-Person-telephoneNumber'];

	    $password = "";
            for ($i = 0; $i < 12; ++$i)
		$password .= chr (mt_rand (35, 126));

	    // Enter / update user info in phpmyadmin
//	    error_log('Synchronising');
	    $registration = $this->GetRegistration();

	    $registration->Synchronize(
		new AuthenticatedUser(
		    $uid,
		    $mail,
		    $fname,
		    $lname,
		    $password,
		    Configuration::Instance()->GetKey(ConfigKeys::LANGUAGE),
		    Configuration::Instance()->GetKey(ConfigKeys::SERVER_TIMEZONE),
		    $phone, '', '' ) );


	    return $this->authToDecorate->Login($uid, $loginContext);
	}

	public function Logout(UserSession $user)
	{
		$this->authToDecorate->Logout($user);
	}

	public function AreCredentialsKnown()
	{
	    return false;
	}

	public function ShowUsernamePrompt()
	{
	    return false;
	}

	public function ShowPasswordPrompt()
	{
	    return false;
	}

	public function ShowPersistLoginPrompt()
	{
	    return false;
	}

	public function ShowForgotPasswordPrompt()
	{
	    return false;
	}

	public function HandleLoginFailure(IAuthenticationPage $loginPage)
	{
		// noop
	}


}

?>
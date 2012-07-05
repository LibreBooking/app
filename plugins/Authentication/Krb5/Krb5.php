<?php
/**
Copyright 2011-2012 Nick Korbel
Copyright 2012 Alois Schloegl 

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');
#require_once(ROOT_DIR . 'plugins/Authentication/Krb5/Krb5.config.php');


class Krb5 implements IAuthentication
{
    /**
	 * @var IAuthentication
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
	 * @param IAuthentication $authentication Authentication class to decorate
	 */
	public function __construct(IAuthentication $authentication)
	{
		$this->authToDecorate = $authentication;
	}
	
	/**
	* Called first to validate credentials
	* @see IAuthorization::Validate()
	*/
	public function Validate($username, $password)
	{
		$ru = explode('@', $_SERVER['REMOTE_USER']);
		$user   = $ru[0];
		$domain = $ru[1];
                ## TODO: supported realm should be obtained from configuration file
		if ($domain == 'IST.LOCAL' || $domain == 'ISTA.LOCAL') {
		        $lu = explode('@', $username);
			return ($lu[0]==$user);
		}
                return false; 
	}
	
	/**
	* Called after Validate returns true
	* @see IAuthorization::Login()
	*/
	public function Login($username, $loginContext)
	{
		$lu = explode('@', $username);
		$username = $lu[0]; 
		
		$server = ServiceLocator::GetServer();
		$userRepository = new UserRepository();
		$user = $userRepository->LoadByUsername($username);

		$this->authToDecorate->SetUserSession($user, $server);
	}
	
	/**
	 * @see IAuthorization::Logout()
	 */
	public function Logout(UserSession $user)
	{
		$this->authToDecorate->Logout($user);
	}
	
	/**
	 * @see IAuthorization::CookieLogin()
	 */
	public function CookieLogin($cookieValue, $loginContext)
	{
		// Do anything Drupal-specific
		  //MPinnegar - I don't think we need to do anything specific to Drupal? It shouldn't care about cookies set by phpScheduleIt
		// Always call decorated Authentication so proper phpScheduleIt functionality is executed
		$this->authToDecorate->CookieLogin($cookieValue, $loginContext);
	}
	
	/**
	 * @see IAuthorization::AreCredentialsKnown()
	 */
	public function AreCredentialsKnown()
	{
		$ru = $_SERVER['REMOTE_USER'];
		if ($ru) {
			return (bool)$ru;
		} else {
			return false;
		}
	}
	
	/**
	 * @see IAuthorization::HandleLoginFailure()
	 */
	public function HandleLoginFailure(ILoginPage $loginPage)
	{
		$this->authToDecorate->HandleLoginFailure($loginPage);
	}

        public function ShowUsernamePrompt() {
                return false;
        }

        public function ShowPasswordPrompt() {
                return false;
        }

        public function ShowPersistLoginPrompt() {
                return false;
        }

        public function ShowForgotPasswordPrompt() {
                return false;
        }
}

?>

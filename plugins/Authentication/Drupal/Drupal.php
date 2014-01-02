<?php
/**
Copyright 2011-2014 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . 'plugins/Authentication/Drupal/Drupal.config.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');

class Drupal extends Authentication implements IAuthentication
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
	* Needed to register user if they are logging in to Drupal but do not have a Booked Scheduler account yet
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
	   $isValid = false;
	   // Authentication against Drupal
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

        //TODO: Optionally auth against Booked Scheduler.
        //MPinnegar - I don't think we should auth against phpSched. Shouldn't we be authorizing exclusively against the Drupal install?
		return $isValid;
	}

	/**
	* Called after Validate returns true
	* @see IAuthorization::Login()
	*/
	public function Login($username, $loginContext)
	{
		// Synchronize account information from Drupal
            //The only thing Drupal really has is the user's e-mail address. Could syncronize that?

        //MPinnegar - I assume I don't do anything with persist, that's only used by another wrapper?

		// Always call decorated Authentication so proper Booked Scheduler functionality is executed
		return $this->authToDecorate->Login($username, $loginContext);
	}

	/**
	 * @see IAuthorization::Logout()
	 */
	public function Logout(UserSession $user)
	{
		$this->authToDecorate->Logout($user);
	}

	/**
	 * @see IAuthorization::AreCredentialsKnown()
	 */
	public function AreCredentialsKnown()
	{
		return false;
	}
}

?>
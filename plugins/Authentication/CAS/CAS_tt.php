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
require_once(ROOT_DIR . 'plugins/Authentication/CAS/namespace.php');

class CAS implements IAuthentication
{
	private $authToDecorate;
	private $_registration;

	private $user = null;
	private $options = null; 

	private function GetRegistration()
	{
		if ($this->_registration == null)
		{
			$this->_registration = new Registration();
		}

		return $this->_registration;
	}

	public function __construct(Authentication $authentication)
	{
		$this->setCASSettings();//initialise cas settings
		$this->authToDecorate = $authentication;

		//initialize cas options
		//$this->options = new CASOptions();


	}

	/*
	* CAS default settings move to settings file when ok
	*/
	private function setCASSettings(){


		//$redirect_to="http://www.we10_reservation_system.ugent.be/Web/schedule.php";
		$redirect_to="http://www.we10_reservation_system.ugent.be/Web/index.php";

		//phpCAS::setDebug('/tmp/phpCAS.log'); // Schrijft debug informatie naar een log-file

		// Parameters: CAS versie, url CAS server, poort CAS server, CAS server URI (idem als host),
		// boolean die aangeeft of sessie moet gestart worden, communicatieprotocol (SAML) tussen toepassing en CAS server
		phpCAS::client(SAML_VERSION_1_1, 'login.ugent.be',443,'', true, 'saml');


		// Geeft aan vanaf welke server logout requests mogelijk zijn
		phpCAS::handleLogoutRequests(true, array('cas1.ugent.be','cas2.ugent.be','cas3.ugent.be','cas4.ugent.be','cas5.ugent.be','cas6.ugent.be'));

		// Configuratie van het certificaat van de CAS server
		phpCAS::setExtraCurlOption(CURLOPT_SSLVERSION, 3);
		// Locatie van het "trusted certificate authorities" bestand:
		phpCAS::setCasServerCACert('/etc/ssl/certs/ca-certificates.crt');
		// Geen server verificatie (minder veilig!):
		//phpCAS::setNoCasServerValidation();

		phpCAS::setFixedServiceURL($redirect_to);

	}
	
	//hier testen tegen CAS en user opvullen
	public function Validate($username, $password)
	{

		if($this->user ==null){
			// Here happens the authentication of the user
			phpCAS::forceAuthentication();
			//here the result of the CAS ticket get returned
			$username = phpCAS::getUser();
			$this->PopulateUser($username);
		}
		//When getting here user should be loged in user was redirected by phpCAS::forceAuthentication(); whennot loged in
		//@NICK fill op user object with attribute fields of CAS of in LOGIN?
		return true;
	}

	//hier user makenen opvullen
	public function Login($username, $loginContext)
	{
/*		
		//gets the username again of cas not nessairy i think was retrived in Validate
		$username = phpCAS::getUser();

		//@NICK: populate user class should be done here?
		$this->PopulateUser($username);

*/
		$this->authToDecorate->Login($username, $loginContext);
	}

	public function Logout(UserSession $user)
	{
		$this->authToDecorate->Logout($user);
	}

	public function CookieLogin($cookieValue, $loginContext)
	{
		$this->authToDecorate->CookieLogin($cookieValue, $loginContext);
	}

	public function AreCredentialsKnown()
	{
		if ($this->user == null){
			return false;
		}
		else{
			return true;
		}
		
	}

	public function HandleLoginFailure(ILoginPage $loginPage)
	{
		$this->authToDecorate->HandleLoginFailure($loginPage);
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

//own functions for using CAS

	private function PopulateUser($username)
	{
	
	$conf['settings']['attribute_mapping'] = 'dn=uid,sn=surname,givenname=givenname,mail=mail,title=jobcategory';	// 
	$conf['settings']['user_id_attribute'] = 'uid';	// the attribute name for user identification

	$conf_mapping_array = array(	 'dn'=>'uid' ,
				 'sn'=>'surname' ,
				 'givenname'=>'givenname' ,
				 'mail'=>'mail' ,
				 'title'=>'jobcategory');
		//@GOS fill $this->user 
	    	$cas_user_attributes = phpCAS::getAttributes();

			Log::Debug('CAS PopulateUser user %s', $username);			
			//org $this->user = new CASUser($cas_user_attributes, $this->options->AttributeMapping());
			$this->user = new CASUser($cas_user_attributes,$conf_mapping_array);



	}


}

?>

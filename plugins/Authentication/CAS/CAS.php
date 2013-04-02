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
include_once('CAS-1.3.1/CAS.php');

class CAS implements IAuthentication
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

	public function __construct(Authentication $authentication)
	{
		$this->setCASSettings(); //initialise cas settings
		$this->authToDecorate = $authentication;
	}

	/*
	* CAS default settings move to settings file when ok
	*/
	private function setCASSettings()
	{
		$CAS_HOSTNAME = 'your.server.com';
		$CAS_PORT = '8443';
		$CAS_URL = '/path-to-cas';
		$CAS_CERT_DIR = '/etc/ssl/certs/ca-certificates.crt';
		phpCAS::setDebug();

		phpCAS::client(CAS_VERSION_2_0, $CAS_HOSTNAME, $CAS_PORT, $CAS_URL, false);

//		phpCAS::handleLogoutRequests(true, array('servers'));

		phpCAS::setExtraCurlOption(CURLOPT_SSLVERSION, 3);

		phpCAS::setCasServerCACert($CAS_CERT_DIR);

//		phpCAS::setFixedServiceURL($redirect_to);

	}

	public function Validate($username, $password)
	{
		try
		{
			phpCAS::forceAuthentication();

		} catch (Exception $ex)
		{
			Log::Error('CAS exception: %s', $ex);
			return false;
		}
		return true;
	}

	public function Login($username, $loginContext)
	{
		$isAuth = phpCAS::isAuthenticated();
		Log::Debug('CAS is auth ok: %s', $isAuth);
		$username = phpCAS::getUser();
		$this->Synchronize($username);
		$this->authToDecorate->Login($username, $loginContext);
	}

	public function Logout(UserSession $user)
	{
		$this->authToDecorate->Logout($user);
	}

	public function AreCredentialsKnown()
	{
		return true;
	}

	public function HandleLoginFailure(IAuthenticationPage $loginPage)
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

	private function Synchronize($username)
	{
		$registration = $this->GetRegistration();

		$registration->Synchronize(
			new AuthenticatedUser(
				$username,
				$username . '@test.com',
				$username,
				$username,
				$username,
				Configuration::Instance()->GetKey(ConfigKeys::LANGUAGE),
				Configuration::Instance()->GetKey(ConfigKeys::SERVER_TIMEZONE),
				null,
				null,
				null)
		);
	}
}

?>
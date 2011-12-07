<?php
require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');
require_once(ROOT_DIR . 'plugins/Authentication/Ldap/namespace.php');

/**
 * Provides LDAP authentication/synchronization for phpScheduleIt
 * @see IAuthorization
 */
class Ldap implements IAuthentication
{
	/**
	 * @var IAuthentication
	 */
	private $authToDecorate;

	/**
	 * @var AdLdapWrapper
	 */
	private $ldap;

	/**
	 * @var LdapOptions
	 */
	private $options;

	/**
	 * @var IRegistration
	 */
	private $_registration;

	/**
	 * @var PasswordEncryption
	 */
	private $_encryption;

	/**
	 * @var LdapUser
	 */
	private $user;

	/**
	 * @var string
	 */
	private $password;

	public function SetRegistration($registration)
	{
		$this->_registration = $registration;
	}

	private function GetRegistration()
	{
		if ($this->_registration == null)
		{
			$this->_registration = new Registration();
		}

		return $this->_registration;
	}

	public function SetEncryption($passwordEncryption)
	{
		$this->_encryption = $passwordEncryption;
	}

	private function GetEncryption()
	{
		if ($this->_encryption == null)
		{
			$this->_encryption = new PasswordEncryption();
		}

		return $this->_encryption;
	}


	/**
	 * @param IAuthentication $authentication Authentication class to decorate
	 * @param ILdap $ldapImplementation The actual LDAP implementation to work against
	 * @param LdapOptions $ldapOptions Options to use for LDAP configuration
	 */
	public function __construct(IAuthentication $authentication, $ldapImplementation = null, $ldapOptions = null)
	{
		$this->authToDecorate = $authentication;

		$this->options = $ldapOptions;
		if ($ldapOptions == null)
		{
			$this->options = new LdapOptions();
		}

		$this->ldap = $ldapImplementation;
		if ($ldapImplementation == null)
		{
			$this->ldap = new AdLdapWrapper($this->options);
		}
	}

	public function Validate($username, $password)
	{
		die("Ldap Validate: $username $password");
		$this->password = $password;

		$this->ldap->Connect();

		$this->user = $this->ldap->GetLdapUser($username);

		$isValid = false;

		if ($this->LdapUserExists())
		{
			$isValid = $this->ldap->Authenticate($username, $password);
		} else
		{
			if ($this->options->RetryAgainstDatabase())
			{
				$isValid = $this->authToDecorate->Validate($username, $password);
			}
		}

		return $isValid;
	}

	public function Login($username, $persist)
	{
		if ($this->LdapUserExists())
		{
			$this->Synchronize($username);
		}

		$this->authToDecorate->Login($username, $persist);
	}

	public function Logout(UserSession $user)
	{
		$this->authToDecorate->Logout($user);
	}

	public function CookieLogin($cookieValue)
	{
		$this->authToDecorate->CookieLogin($cookieValue);
	}

	public function AreCredentialsKnown()
	{
		return false;
	}

	public function HandleLoginFailure(ILoginPage $loginPage)
	{
		$this->authToDecorate->HandleLoginFailure($loginPage);
	}

	private function LdapUserExists()
	{
		return $this->user != null;
	}

	private function Synchronize($username)
	{
		$registration = $this->GetRegistration();

		$registration->Synchronize(
			new AuthenticatedUser($username, $this->user->GetEmail(), $this->user->GetFirstName(), $this->user->GetLastName(), $this->password,
				Configuration::Instance()->GetKey(ConfigKeys::SERVER_TIMEZONE), Configuration::Instance()->GetKey(ConfigKeys::LANGUAGE),
				$this->user->GetPhone(), $this->user->GetInstitution(), $this->user->GetTitle())
		);
	}
}

?>
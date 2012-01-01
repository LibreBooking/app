<?php
/**
Copyright 2011-2012 Nick Korbel

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

require_once(ROOT_DIR . 'plugins/Authentication/Ldap/namespace.php');

class LdapTests extends TestBase
{
	/**
	 * @var FakeAuth
	 */
	private $fakeAuth;

	/**
	 * @var FakeLdapOptions
	 */
	private $fakeLdapOptions;

	/**
	 * @var FakeLdapWrapper
	 */
	private $fakeLdap;

	/**
	 * @var LdapUser
	 */
	private $ldapUser;

	/**
	 * @var FakeRegistration
	 */
	private $fakeRegistration;

	/**
	 * @var FakePasswordEncryption
	 */
	private $encryption;

	private $username = 'username';
	private $password = 'password';

	public function setup()
	{
		parent::setup();

		$this->fakeAuth = new FakeAuth();
		$this->fakeLdapOptions = new FakeLdapOptions();
		$this->fakeLdap = new FakeLdapWrapper();
		$this->fakeRegistration = new FakeRegistration();
		$this->encryption = new FakePasswordEncryption();

		$ldapEntry = array("sn" => array('user'), "givenname" => array('test'), "mail" => array('ldap@user.com'), "telephonenumber" => array('000-000-0000'), "physicaldeliveryofficename" => array(''), "title" => array(''));

		$this->ldapUser = new LdapUser($ldapEntry);

		$this->fakeLdap->_ExpectedLdapUser = $this->ldapUser;
	}

	public function testCanValidateUser()
	{
		$this->fakeLdapOptions->_RetryAgainstDatabase = false;
		$expectedResult = true;
		$this->fakeLdap->_ExpectedAuthenticate = $expectedResult;

		$auth = new Ldap($this->fakeAuth, $this->fakeLdap, $this->fakeLdapOptions);
		$isValid = $auth->Validate($this->username, $this->password);

		$this->assertEquals($expectedResult, $isValid);
		$this->assertTrue($this->fakeLdap->_ConnectCalled);
		$this->assertTrue($this->fakeLdap->_AuthenticateCalled);
		$this->assertEquals($this->username, $this->fakeLdap->_LastUsername);
		$this->assertEquals($this->password, $this->fakeLdap->_LastPassword);
	}

	public function testNotValidIfCannotFindUser()
	{
		$this->fakeLdap->_ExpectedLdapUser = null;
		$auth = new Ldap($this->fakeAuth, $this->fakeLdap, $this->fakeLdapOptions);
		$isValid = $auth->Validate($this->username, $this->password);

		$this->assertFalse($isValid);
		$this->assertTrue($this->fakeLdap->_ConnectCalled);
		$this->assertTrue($this->fakeLdap->_AuthenticateCalled);
	}

    public function testDoesNotTryToLoadUserDetailsIfNotValid()
    {
        $this->fakeLdap->_ExpectedAuthenticate = false;
        $auth = new Ldap($this->fakeAuth, $this->fakeLdap, $this->fakeLdapOptions);
        $isValid = $auth->Validate($this->username, $this->password);

        $this->assertFalse($this->fakeLdap->_GetLdapUserCalled);
        $this->assertFalse($isValid);
    }

	public function testNotValidIfValidateFailsAndNotFailingOverToDb()
	{
		$this->fakeLdapOptions->_RetryAgainstDatabase = false;
		$expectedResult = false;
		$this->fakeLdap->_ExpectedAuthenticate = $expectedResult;

		$auth = new Ldap($this->fakeAuth, $this->fakeLdap, $this->fakeLdapOptions);
		$isValid = $auth->Validate($this->username, $this->password);

		$this->assertEquals($expectedResult, $isValid);
	}

	public function testFailOverToDbIfConfigured()
	{
		$this->fakeLdapOptions->_RetryAgainstDatabase = true;
		$this->fakeLdap->_ExpectedAuthenticate = false;

		$authResult = true;
		$this->fakeAuth->_ValidateResult = $authResult;

		$auth = new Ldap($this->fakeAuth, $this->fakeLdap, $this->fakeLdapOptions);
		$isValid = $auth->Validate($this->username, $this->password);

		$this->assertEquals($authResult, $isValid);
		$this->assertTrue($this->fakeLdap->_AuthenticateCalled);
		$this->assertEquals($this->username, $this->fakeAuth->_LastLogin);
		$this->assertEquals($this->password, $this->fakeAuth->_LastPassword);
	}

	public function testLoginSynchronizesInfoAndCallsAuthLogin()
	{
		$timezone = 'UTC';
		$this->fakeConfig->SetKey(ConfigKeys::SERVER_TIMEZONE, $timezone);
		$languageCode = 'en_US';
		$this->fakeConfig->SetKey(ConfigKeys::LANGUAGE, $languageCode);
		$persist = true;

		$expectedUser = new AuthenticatedUser(
			$this->username,
			$this->ldapUser->GetEmail(),
			$this->ldapUser->GetFirstName(),
			$this->ldapUser->GetLastName(),
			$this->password,
			$languageCode,
            $timezone,
			$this->ldapUser->GetPhone(),
			$this->ldapUser->GetInstitution(),
			$this->ldapUser->GetTitle());


		$auth = new Ldap($this->fakeAuth, $this->fakeLdap, $this->fakeLdapOptions);
		$auth->SetRegistration($this->fakeRegistration);

		$auth->Validate($this->username, $this->password);
		$auth->Login($this->username, $persist);

		$this->assertTrue($this->fakeRegistration->_SynchronizeCalled);
		$this->assertEquals($expectedUser, $this->fakeRegistration->_LastSynchronizedUser);
		$this->assertEquals($persist, $this->fakeAuth->_LastPersist);
	}

	public function testDoesNotSyncIfUserWasNotFoundInLdap()
	{
		$persist = false;
		$this->fakeLdap->_ExpectedLdapUser = null;

		$auth = new Ldap($this->fakeAuth, $this->fakeLdap, $this->fakeLdapOptions);

		$auth->Validate($this->username, $this->password);
		$auth->Login($this->username, $persist);

		$this->assertFalse($this->fakeRegistration->_SynchronizeCalled);
		$this->assertEquals($persist, $this->fakeAuth->_LastPersist);
	}

	public function testAdLdapConstructsOptionsCorrectly()
	{
		$controllers = 'localhost, localhost.2';
		$port = '389';
		$username = 'uname';
		$password = 'pw';
		$base = '';
		$usessl = 'false';
		$version = '3';
		$accountSuffix = '';

		$configFile = new FakeConfigFile();
		$configFile->SetKey(LdapConfig::DOMAIN_CONTROLLERS, $controllers);
		$configFile->SetKey(LdapConfig::PORT, $port);
		$configFile->SetKey(LdapConfig::USERNAME, $username);
		$configFile->SetKey(LdapConfig::PASSWORD, $password);
		$configFile->SetKey(LdapConfig::BASEDN, $base);
		$configFile->SetKey(LdapConfig::USE_SSL, $usessl);
		$configFile->SetKey(LdapConfig::VERSION, $version);
		$configFile->SetKey(LdapConfig::ACCOUNT_SUFFIX, $accountSuffix);

		$this->fakeConfig->SetFile(LdapConfig::CONFIG_ID, $configFile);

		$ldapOptions = new LdapOptions();
		$options = $ldapOptions->AdLdapOptions();

		$this->assertNotNull($this->fakeConfig->_RegisteredFiles[LdapConfig::CONFIG_ID]);
		$this->assertEquals('localhost', $options['domain_controllers'][0], 'domain_controllers must be an array');
		$this->assertEquals(intval($port), $options['port'], 'port should be int');
		$this->assertEquals($username, $options['ad_username']);
		$this->assertEquals($password, $options['ad_password']);
		$this->assertEquals($base, $options['base_dn']);
		$this->assertEquals(false, $options['use_ssl']);
		$this->assertEquals($accountSuffix, $options['account_suffix']);
		$this->assertEquals(intval($version), $options['ldap_version'], "version should be int");
	}

	public function testGetAllHosts()
	{
		$controllers = 'localhost, localhost.2';

		$configFile = new FakeConfigFile();
		$configFile->SetKey(LdapConfig::DOMAIN_CONTROLLERS, $controllers);
		$this->fakeConfig->SetFile(LdapConfig::CONFIG_ID, $configFile);

		$options = new LdapOptions();

		$this->assertEquals(array('localhost', 'localhost.2'), $options->Controllers(), "comma separated values should become array");
	}
}

?>
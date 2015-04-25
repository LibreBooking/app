<?php
/**
Copyright 2011-2015 Nick Korbel

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

require_once(ROOT_DIR . 'plugins/Authentication/ActiveDirectory/namespace.php');

class ActiveDirectoryTests extends TestBase
{
	/**
	 * @var FakeAuth
	 */
	private $fakeAuth;

	/**
	 * @var FakeActiveDirectoryOptions
	 */
	private $fakeLdapOptions;

	/**
	 * @var FakeActiveDirectoryWrapper
	 */
	private $fakeLdap;

	/**
	 * @var ActiveDirectoryUser
	 */
	private $ldapUser;

	/**
	 * @var FakeRegistration
	 */
	private $fakeRegistration;

	/**
	 * @var FakeGroupViewRepository
	 */
	private $fakeGroupRepository;

	/**
	 * @var FakePasswordEncryption
	 */
	private $encryption;

	private $username = 'username';
	private $password = 'password';

	/**
	 * @var ILoginContext
	 */
	private $loginContext;

	public function setup()
	{
		parent::setup();

		$this->fakeAuth = new FakeAuth();
		$this->fakeLdapOptions = new FakeActiveDirectoryOptions();
		$this->fakeLdap = new FakeActiveDirectoryWrapper();
		$this->fakeRegistration = new FakeRegistration();
		$this->encryption = new FakePasswordEncryption();
		$this->fakeGroupRepository = new FakeGroupViewRepository();

        $ldapEntry = new TestAdLdapEntry();
		$ldapEntry->sn = 'user';
        $ldapEntry->givenname = 'test';
        $ldapEntry->mail = 'ldap@user.com';
        $ldapEntry->telephonenumber = '000-000-0000';
        $ldapEntry->physicaldeliveryofficename = '';
        $ldapEntry->title = '';

		$mapping = array('sn' => 'sn',
						'givenname' => 'givenname',
						'mail' => 'mail',
						'telephonenumber' => 'telephonenumber',
						'physicaldeliveryofficename' => 'physicaldeliveryofficename',
						'title' => 'title');

		$this->ldapUser = new ActiveDirectoryUser($ldapEntry, $mapping, 'group1,group2,group3');

		$this->fakeLdap->_ExpectedLdapUser = $this->ldapUser;

		$this->loginContext = $this->getMock('ILoginContext');
	}

	public function testCanValidateUser()
	{
		$this->fakeLdapOptions->_RetryAgainstDatabase = false;
		$expectedResult = true;
		$this->fakeLdap->_ExpectedAuthenticate = $expectedResult;

		$auth = new ActiveDirectory($this->fakeAuth, $this->fakeLdap, $this->fakeLdapOptions);
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
		$auth = new ActiveDirectory($this->fakeAuth, $this->fakeLdap, $this->fakeLdapOptions);
		$isValid = $auth->Validate($this->username, $this->password);

		$this->assertFalse($isValid);
		$this->assertTrue($this->fakeLdap->_ConnectCalled);
		$this->assertTrue($this->fakeLdap->_AuthenticateCalled);
	}

    public function testDoesNotTryToLoadUserDetailsIfNotValid()
    {
        $this->fakeLdap->_ExpectedAuthenticate = false;
        $auth = new ActiveDirectory($this->fakeAuth, $this->fakeLdap, $this->fakeLdapOptions);
        $isValid = $auth->Validate($this->username, $this->password);

        $this->assertFalse($this->fakeLdap->_GetLdapUserCalled);
        $this->assertFalse($isValid);
    }

	public function testNotValidIfValidateFailsAndNotFailingOverToDb()
	{
		$this->fakeLdapOptions->_RetryAgainstDatabase = false;
		$expectedResult = false;
		$this->fakeLdap->_ExpectedAuthenticate = $expectedResult;

		$auth = new ActiveDirectory($this->fakeAuth, $this->fakeLdap, $this->fakeLdapOptions);
		$isValid = $auth->Validate($this->username, $this->password);

		$this->assertEquals($expectedResult, $isValid);
	}

	public function testFailOverToDbIfConfigured()
	{
		$this->fakeLdapOptions->_RetryAgainstDatabase = true;
		$this->fakeLdap->_ExpectedAuthenticate = false;

		$authResult = true;
		$this->fakeAuth->_ValidateResult = $authResult;

		$auth = new ActiveDirectory($this->fakeAuth, $this->fakeLdap, $this->fakeLdapOptions);
		$isValid = $auth->Validate($this->username, $this->password);

		$this->assertEquals($authResult, $isValid);
		$this->assertTrue($this->fakeLdap->_AuthenticateCalled);
		$this->assertEquals($this->username, $this->fakeAuth->_LastLogin);
		$this->assertEquals($this->password, $this->fakeAuth->_LastPassword);
	}

	public function testLoginSynchronizesInfoAndCallsAuthLogin()
	{
		$timezone = 'UTC';
		$this->fakeConfig->SetKey(ConfigKeys::DEFAULT_TIMEZONE, $timezone);
		$languageCode = 'en_US';
		$this->fakeConfig->SetKey(ConfigKeys::LANGUAGE, $languageCode);

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


		$auth = new ActiveDirectory($this->fakeAuth, $this->fakeLdap, $this->fakeLdapOptions);
		$auth->SetRegistration($this->fakeRegistration);

		$auth->Validate($this->username, $this->password);
		$auth->Login($this->username, $this->loginContext);

		$this->assertTrue($this->fakeRegistration->_SynchronizeCalled);
		$this->assertEquals($expectedUser, $this->fakeRegistration->_LastSynchronizedUser);
		$this->assertEquals($this->loginContext, $this->fakeAuth->_LastLoginContext);
	}

	public function testSyncsGroups()
	{
		$this->fakeLdapOptions->_SyncGroups = true;
		$auth = new ActiveDirectory($this->fakeAuth, $this->fakeLdap, $this->fakeLdapOptions);
		$auth->SetRegistration($this->fakeRegistration);
		$auth->SetGroupRepository($this->fakeGroupRepository);

		$this->fakeGroupRepository->_AddGroup(new GroupItemView(1, 'Group1'));
		$this->fakeGroupRepository->_AddGroup(new GroupItemView(3, 'Group3'));
		$this->fakeGroupRepository->_AddGroup(new GroupItemView(4, 'Group4'));

		$auth->Validate($this->username, $this->password);
		$auth->Login($this->username, $this->loginContext);

		$this->assertEquals(array(new UserGroup(1, 'Group1'), new UserGroup(3,'Group3')), $this->fakeRegistration->_LastSynchronizedUser->GetGroups());
	}

	public function testDoesNotSyncIfUserWasNotFoundInLdap()
	{
		$this->fakeLdap->_ExpectedLdapUser = null;

		$auth = new ActiveDirectory($this->fakeAuth, $this->fakeLdap, $this->fakeLdapOptions);

		$auth->Validate($this->username, $this->password);
		$auth->Login($this->username, $this->loginContext);

		$this->assertFalse($this->fakeRegistration->_SynchronizeCalled);
		$this->assertEquals($this->loginContext, $this->loginContext);
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
		$configFile->SetKey(ActiveDirectoryConfig::DOMAIN_CONTROLLERS, $controllers);
		$configFile->SetKey(ActiveDirectoryConfig::PORT, $port);
		$configFile->SetKey(ActiveDirectoryConfig::USERNAME, $username);
		$configFile->SetKey(ActiveDirectoryConfig::PASSWORD, $password);
		$configFile->SetKey(ActiveDirectoryConfig::BASEDN, $base);
		$configFile->SetKey(ActiveDirectoryConfig::USE_SSL, $usessl);
		$configFile->SetKey(ActiveDirectoryConfig::VERSION, $version);
		$configFile->SetKey(ActiveDirectoryConfig::ACCOUNT_SUFFIX, $accountSuffix);

		$this->fakeConfig->SetFile(ActiveDirectoryConfig::CONFIG_ID, $configFile);

		$ldapOptions = new ActiveDirectoryOptions();
		$options = $ldapOptions->AdLdapOptions();

		$this->assertNotNull($this->fakeConfig->_RegisteredFiles[ActiveDirectoryConfig::CONFIG_ID]);
		$this->assertEquals('localhost', $options['domain_controllers'][0], 'domain_controllers must be an array');
		$this->assertEquals(intval($port), $options['ad_port'], 'port should be int');
		$this->assertEquals($username, $options['admin_username']);
		$this->assertEquals($password, $options['admin_password']);
		$this->assertEquals($base, $options['base_dn']);
		$this->assertEquals(false, $options['use_ssl']);
		$this->assertEquals($accountSuffix, $options['account_suffix']);
		$this->assertEquals(intval($version), $options['ldap_version'], "version should be int");
	}

	public function testGetAllHosts()
	{
		$controllers = 'localhost, localhost.2';

		$configFile = new FakeConfigFile();
		$configFile->SetKey(ActiveDirectoryConfig::DOMAIN_CONTROLLERS, $controllers);
		$this->fakeConfig->SetFile(ActiveDirectoryConfig::CONFIG_ID, $configFile);

		$options = new ActiveDirectoryOptions();

		$this->assertEquals(array('localhost', 'localhost.2'), $options->Controllers(), "comma separated values should become array");
	}

	public function testConvertsEmailToUserName()
	{
		$email = 'user@email.com';
		$expectedUsername = 'user';

		$auth = new ActiveDirectory($this->fakeAuth, $this->fakeLdap, $this->fakeLdapOptions);
		$auth->Validate($email, $this->password);

		$this->assertEquals($expectedUsername, $this->fakeLdap->_LastUsername);
	}

	public function testConvertsUserNameWithDomainToUserName()
	{
		$username = 'domain\user';
		$expectedUsername = 'user';

		$auth = new ActiveDirectory($this->fakeAuth, $this->fakeLdap, $this->fakeLdapOptions);
		$auth->Validate($username, $this->password);

		$this->assertEquals($expectedUsername, $this->fakeLdap->_LastUsername);
	}

	public function testCanGetAttributeMapping()
	{
		$attributeMapping = "sn= sn,givenname =givenname,mail=email ,telephonenumber=phone, physicaldeliveryofficename=physicaldeliveryofficename";

		$configFile = new FakeConfigFile();
		$configFile->SetKey(ActiveDirectoryConfig::ATTRIBUTE_MAPPING, $attributeMapping);
		$this->fakeConfig->SetFile(ActiveDirectoryConfig::CONFIG_ID, $configFile);

		$options = new ActiveDirectoryOptions();

		$expectedAttributes = array( 'sn', 'givenname', 'email', 'phone', 'physicaldeliveryofficename', 'title');
		$this->assertEquals($expectedAttributes, $options->Attributes());
	}

	public function testGetsDefaultAttributes()
	{
		$configFile = new FakeConfigFile();
		$configFile->SetKey(ActiveDirectoryConfig::ATTRIBUTE_MAPPING, '');
		$this->fakeConfig->SetFile(ActiveDirectoryConfig::CONFIG_ID, $configFile);

		$options = new ActiveDirectoryOptions();

		$expectedAttributes = array( 'sn', 'givenname', 'mail', 'telephonenumber', 'physicaldeliveryofficename', 'title');
		$this->assertEquals($expectedAttributes, $options->Attributes());
	}

	public function testMapsUserAttributes()
	{
		$mapping = array('sn' => 'sn',
						'givenname' => 'givenname',
						'mail' => 'fooName',);

		$entry = new TestAdLdapEntry();
		$entry->sn = 'sn';
		$entry->givenname = 'given';
		$entry->fooName = 'foo';
		$entry->telephonenumber = 'phone';

		$user = new ActiveDirectoryUser($entry, $mapping);

		$this->assertEquals('sn', $user->GetLastName());
		$this->assertEquals('given', $user->GetFirstName());
		$this->assertEquals('foo', $user->GetEmail());
		$this->assertEquals('phone', $user->GetPhone());
	}
}

class TestAdLdapEntry
{
    public $sn;
    public $givenname;
    public $mail;
    public $telephonenumber;
    public $physicaldeliveryofficename;
    public $title;
    public $groups;
}
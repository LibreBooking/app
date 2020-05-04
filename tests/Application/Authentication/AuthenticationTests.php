<?php
/**
 * Copyright 2011-2020 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Server/namespace.php');
require_once(ROOT_DIR . 'lib/Config/namespace.php');


class AuthenticationTests extends TestBase
{
	private $username;
	private $password;
	private $id;
	private $fname;
	private $lname;
	private $email;
	private $isAdmin;
	private $timezone;
	private $lastLogin;
	private $homepageId;
	private $languageCode;
	private $publicId;
	private $scheduleId;
	private $groups;

	/**
	 * @var Authentication
	 */
	private $auth;

	/**
	 * @var FakePassword
	 */
	private $fakePassword;

	/**
	 * @var FakeAuthorizationService
	 */
	private $authorization;

	/**
	 * @var WebLoginContext
	 */
	private $loginContext;

	/**
	 * @var FakeUser
	 */
	private $user;

	/**
	 * @var FakeUserRepository
	 */
	private $userRepository;
	/**
	 * @var FakeGroupRepository
	 */
	private $groupRepository;

	/**
	 * @var FakeFirstRegistrationStrategy
	 */
	private $fakeFirstRegistration;

	function setup(): void
	{
		parent::setup();

		$this->username = 'LoGInName';
		$this->password = 'password';
		$this->id = 191;
		$this->fname = 'Test';
		$this->lname = 'Name';
		$this->email = 'my@email.com';
		$this->isAdmin = true;
		$this->timezone = "US/Central";
		$this->lastLogin = time();
		$this->homepageId = 2;
		$this->languageCode = 'en_us';
		$this->publicId = 'public_id';
		$this->scheduleId = 111;
		$this->groups = array(new UserGroup(999, '1'), new UserGroup(888, '2'));

		$this->user = new FakeUser();
		$this->user->WithId($this->id);
		$this->user->ChangeName($this->fname, $this->lname);
		$this->user->ChangeEmailAddress($this->email);
		$this->user->ChangeTimezone($this->timezone);
		$this->user->ChangeDefaultHomePage($this->homepageId);
		$this->user->SetLanguage($this->languageCode);
		$this->user->WithPublicId($this->publicId);
		$this->user->Activate();
		$this->user->WithDefaultSchedule($this->scheduleId);
		$this->user->WithGroups($this->groups);

		$this->fakePassword = new FakePassword();
		$this->authorization = new FakeAuthorizationService();
		$this->userRepository = new FakeUserRepository();
		$this->groupRepository = new FakeGroupRepository();
		$this->fakeFirstRegistration = new FakeFirstRegistrationStrategy();

		$this->auth = new Authentication($this->authorization, $this->userRepository, $this->groupRepository);
		$this->auth->SetPassword($this->fakePassword);
		$this->auth->SetFirstRegistrationStrategy($this->fakeFirstRegistration);

		$this->loginContext = new WebLoginContext(new LoginData());
	}

	function testValidateWhenUserExistsAndPasswordMatches()
	{
		$id = 10;

		$encrypted = "encrypted";
		$salt = "salt";
		$hashVersion = 0;
		$rows = array(array(ColumnNames::USER_ID => $id, ColumnNames::PASSWORD => $encrypted, ColumnNames::SALT => $salt, ColumnNames::PASSWORD_HASH_VERSION => $hashVersion));
		$this->db->SetRows($rows);

		$this->fakePassword->_ValidateResult = true;

		$isValid = $this->auth->Validate($this->username, $this->password);

		$command = new AuthorizationCommand(strtolower($this->username));

		$this->assertEquals($command, $this->db->_LastCommand);
		$this->assertEquals($isValid, $this->fakePassword->_ValidateResult);
		$this->assertTrue($this->fakePassword->_MigrateCalled);
		$this->assertTrue($this->fakePassword->_ValidateCalled);
		$this->assertEquals($this->password, $this->fakePassword->_LastPlainText);
		$this->assertEquals($this->password, $this->fakePassword->_MigratePlainText);
		$this->assertEquals($encrypted, $this->fakePassword->_LastEncrypted);
		$this->assertEquals($salt, $this->fakePassword->_LastSalt);
		$this->assertEquals($hashVersion, $this->fakePassword->_LastHashVersion);
		$this->assertEquals($hashVersion, $this->fakePassword->_MigrateHashVersion);
		$this->assertEquals($id, $this->fakePassword->_MigrateUserId);
	}

	public function testWhenUserDoesNotExist()
	{
		$this->db->SetRows([]);

		$isValid = $this->auth->Validate($this->username, $this->password);

		$this->assertFalse($isValid);
	}

	public function testWhenPasswordIsNotValid()
	{
		$id = 10;

		$rows = array(array(ColumnNames::USER_ID => $id, ColumnNames::PASSWORD => null, ColumnNames::SALT => null, ColumnNames::PASSWORD_HASH_VERSION => 0));
		$this->db->SetRows($rows);

		$this->fakePassword->_ValidateResult = false;

		$isValid = $this->auth->Validate($this->username, $this->password);

		$this->assertFalse($isValid);
		$this->assertFalse($this->fakePassword->_MigrateCalled);
		$this->assertTrue($this->fakePassword->_ValidateCalled);
	}

	function testLoginGetsUserDataFromDatabase()
	{
		CSRFToken::$_Token = 'token';
		$language = 'en_gb';

		$this->userRepository->_User = $this->user;

		$this->fakeFirstRegistration->_User = $this->user;

		LoginTime::$Now = time();

		$this->user->Login(LoginTime::Now(), $language);

		$this->authorization->_IsApplicationAdministrator = true;
		$this->authorization->_IsGroupAdministrator = true;
		$this->authorization->_IsResourceAdministrator = true;
		$this->authorization->_IsScheduleAdministrator = true;

		$context = new WebLoginContext(new LoginData(false, $language));
		$actualSession = $this->auth->Login($this->username, $context);

		$user = new UserSession($this->id);
		$user->FirstName = $this->fname;
		$user->LastName = $this->lname;
		$user->Email = $this->email;
		$user->Timezone = $this->timezone;
		$user->HomepageId = $this->homepageId;
		$user->IsAdmin = true;
		$user->IsGroupAdmin = true;
		$user->IsResourceAdmin = true;
		$user->IsScheduleAdmin = true;
		$user->LanguageCode = $language;
		$user->LoginTime = LoginTime::Now();
		$user->PublicId = $this->publicId;
		$user->ScheduleId = $this->scheduleId;
		$user->CSRFToken = CSRFToken::$_Token;
		foreach ($this->groups as $group)
		{
			$user->Groups[] = $group->GroupId;
		}
		$this->assertEquals($user, $actualSession);

		$this->assertTrue($this->fakeFirstRegistration->_Handled);

		$this->assertEquals($this->fakeFirstRegistration->_User, $this->userRepository->_UpdatedUser);
	}
}

class FakeFirstRegistrationStrategy implements IFirstRegistrationStrategy
{
	public $_Handled;
	/**
	 * @var FakeUser
	 */
	public $_User;

	public function HandleLogin(User $user, IUserRepository $userRepository, IGroupRepository $groupRepository)
	{
		$this->_Handled = true;
		return $this->_User;
	}
}
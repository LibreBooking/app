<?php

class UserRepositoryTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}
	
	public function teardown()
	{
		parent::teardown();
	}
	
	public function testGetAllUsersReturnsAllActiveUsers()
	{
		$timezone = 'UTC';
		$language = 'en_us';
		
		$userRows = array
		(
			array(ColumnNames::USER_ID => 1, ColumnNames::FIRST_NAME => "f1", ColumnNames::LAST_NAME => 'l1', ColumnNames::EMAIL => 'e1', ColumnNames::TIMEZONE_NAME => $timezone, ColumnNames::LANGUAGE_CODE => $language),
			array(ColumnNames::USER_ID => 2, ColumnNames::FIRST_NAME => "f2", ColumnNames::LAST_NAME => 'l2', ColumnNames::EMAIL => 'e2', ColumnNames::TIMEZONE_NAME => $timezone, ColumnNames::LANGUAGE_CODE => $language),
			array(ColumnNames::USER_ID => 3, ColumnNames::FIRST_NAME => "f3", ColumnNames::LAST_NAME => 'l3', ColumnNames::EMAIL => 'e3', ColumnNames::TIMEZONE_NAME => $timezone, ColumnNames::LANGUAGE_CODE => $language),
		);
		
		$this->db->SetRows($userRows);
		
		$userRepository = new UserRepository();
		$users = $userRepository->GetAll();
		
		$user1 = new UserDto(1, "f1", "l1", "e1", $timezone, $language);
		$user2 = new UserDto(2, "f2", "l2", "e2", $timezone, $language);
		$user3 = new UserDto(3, "f3", "l3", "e3", $timezone, $language);
		
		$getAllUsersCommand = new GetAllUsersByStatusCommand(AccountStatus::ACTIVE);
		
		$this->assertEquals($user1, $users[0]);
		$this->assertEquals($user2, $users[1]);
		$this->assertEquals($user3, $users[2]);
		
		$this->assertEquals(1, count($this->db->_Commands));
		$this->assertEquals($getAllUsersCommand, $this->db->_Commands[0]);
	}
	
	public function testLoadsUserFromDatabaseIfNotInCache()
	{
		$userId = 982;
		$loadByIdCommand = new GetUserByIdCommand($userId);
		$loadEmailPreferencesCommand = new GetUserEmailPreferencesCommand($userId);
		$loadPermissionsCommand = new GetUserPermissionsCommand($userId);
		$loadGroupsCommand = new GetUserGroupsCommand($userId);

		$userRows = $this->GetUserRow();
		$emailPrefRows = $this->GetEmailPrefRows();
		$permissionsRows = $this->GetPermissionsRows();
		$groupsRows = $this->GetGroupsRows();

		$this->db->SetRow(0, $userRows);
		$this->db->SetRow(1, $emailPrefRows);
		$this->db->SetRow(2, $permissionsRows);
		$this->db->SetRow(3, $groupsRows);

		$row = $userRows[0];
		
		$userRepository = new UserRepository();
		$user = $userRepository->LoadById($userId);
		
		$this->assertEquals(4, count($this->db->_Commands));
		$this->assertTrue($this->db->ContainsCommand($loadByIdCommand));
		$this->assertTrue($this->db->ContainsCommand($loadEmailPreferencesCommand));
		$this->assertTrue($this->db->ContainsCommand($loadPermissionsCommand));
		$this->assertTrue($this->db->ContainsCommand($loadGroupsCommand));

		$this->assertEquals($row[ColumnNames::FIRST_NAME], $user->FirstName());
		$this->assertTrue($user->WantsEventEmail(new ReservationCreatedEvent()));
		$this->assertContains($permissionsRows[1][ColumnNames::RESOURCE_ID], $user->AllowedResourceIds());
		$this->assertEquals($row[ColumnNames::PHONE_NUMBER], $user->GetAttribute(UserAttribute::Phone));
		$this->assertContains($groupsRows[1][ColumnNames::GROUP_ID], $user->GroupIds());
	}
	
	public function testLoadsUserFromCacheIfAlreadyLoadedFromDatabase()
	{
		$userId = 1;
		
		$row = $this->GetUserRow();
		$this->db->SetRow(0, $row);
		$this->db->SetRow(1, $this->GetEmailPrefRows());
		$this->db->SetRow(2, $this->GetPermissionsRows());
		$this->db->SetRow(3, $this->GetGroupsRows());

		$userRepository = new UserRepository();
		$user = $userRepository->LoadById($userId);
		
		$user = $userRepository->LoadById($userId); // 2nd call should load from cache
		
		$this->assertEquals(4, count($this->db->_Commands));
	}

	public function testCanGetPageableListOfUsers()
	{
		$page = 3;
		$pageSize = 5;
		$count = 51;
		$totalPages = 11;
		$offset = 10;
		$countRow = array('total' => $count);
		$row1 = $this->GetRow(1, 'first', 'last', 'email', 'un1', '2011-01-01');
		$row2 = $this->GetRow(2, 'first', 'last', 'email', null, '2010-01-01');
		$userRows = array($row1, $row2);

		$this->db->SetRow(0, array($countRow));
		$this->db->SetRow(1, $userRows);
		
		$userRepo = new UserRepository();
		$pageable = $userRepo->GetList($page, $pageSize);
		
		$this->assertEquals($count, $pageable->PageInfo()->Total);
		$this->assertEquals($totalPages, $pageable->PageInfo()->TotalPages);
		$this->assertEquals($pageSize, $pageable->PageInfo()->PageSize);
		$this->assertEquals($page, $pageable->PageInfo()->CurrentPage);

		$results = $pageable->Results();
		$this->assertEquals(UserItemView::Create($row1), $results[0]);
		$this->assertEquals(UserItemView::Create($row2), $results[1]);

		$this->assertEquals($offset, $this->db->_Offset);
		$this->assertEquals($pageSize, $this->db->_Limit);
	}

	public function testUpdateSetsUserProperties()
	{
		$userId = 987;
		$user = new User();
		$user->WithId($userId);

		$password = 'password';
		$salt = 'salt';
		$homepageId = 19;
		$fname = 'f';
		$lname = 'l';
		$email = 'e';
		$username = 'u';
		$timezone = 'America/New_York';

		$user->ChangePassword($password, $salt);
		$user->ChangeName($fname, $lname);
		$user->ChangeEmailAddress($email);
		$user->ChangeUsername($username);
		$user->ChangeDefaultHomePage($homepageId);
		$user->ChangeTimezone($timezone);

		$command = new UpdateUserCommand($userId, $user->StatusId(), $password, $salt, $fname, $lname, $email, $username, $homepageId, $timezone);

		$repo = new UserRepository();
		$repo->Update($user);

		$this->assertTrue($this->db->ContainsCommand($command));
	}

	public function testOnlyUpdatesPermissionsIfTheyHaveChanged()
	{
		$userId = 987;
		$user = new User();
		$user->WithId($userId);
		$user->WithPermissions(array(1, 2, 3, 5));
		$user->ChangePermissions(array(2, 3, 4, 6));

		$deletePermissionsCommand1 = new DeleteUserResourcePermission($userId, 1);
		$deletePermissionsCommand2 = new DeleteUserResourcePermission($userId, 5);
		$addPermissionsCommand1 = new AddUserResourcePermission($userId, 4);
		$addPermissionsCommand2 = new AddUserResourcePermission($userId, 6);

		$repo = new UserRepository();
		$repo->Update($user);

		$deleteCommands = $this->db->GetCommandsOfType('DeleteUserResourcePermission');
		$insertCommands = $this->db->GetCommandsOfType('AddUserResourcePermission');
		$this->assertEquals(2, count($deleteCommands));
		$this->assertEquals(2, count($insertCommands));

		$this->assertTrue($this->db->ContainsCommand($deletePermissionsCommand1));
		$this->assertTrue($this->db->ContainsCommand($deletePermissionsCommand2));
		$this->assertTrue($this->db->ContainsCommand($addPermissionsCommand1));
		$this->assertTrue($this->db->ContainsCommand($addPermissionsCommand2));
	}

	public function testUpdatesAttributesIfTheyHaveChanged()
	{
		$userId = 28;
		$phone = '123.456.7890';
		$organization = 'org';
		$position = 'pos';
		
		$user = new User();
		$user->WithId($userId);

		$user->ChangeAttributes($phone, $organization, $position);

		$repo = new UserRepository();
		$repo->Update($user);
		
		$updateAttributesCommand = new UpdateUserAttributesCommand($userId, $phone, $organization, $position);
		$this->assertTrue($this->db->ContainsCommand($updateAttributesCommand));
	}
	
	private function GetUserRow()
	{
		$row = array
		(
			array(
				ColumnNames::USER_ID => 1,
				ColumnNames::FIRST_NAME => 'first',
				ColumnNames::LAST_NAME => 'last',
				ColumnNames::EMAIL => 'email',
				ColumnNames::LANGUAGE_CODE => 'en_us',
				ColumnNames::TIMEZONE_NAME => 'UTC',
				ColumnNames::USER_STATUS_ID => AccountStatus::ACTIVE,
				ColumnNames::PASSWORD => 'encryptedPassword',
				ColumnNames::SALT => 'passwordsalt',
				ColumnNames::USERNAME => 'username',
				ColumnNames::HOMEPAGE_ID => 3,
				ColumnNames::PHONE_NUMBER => '123-456-7890',
				ColumnNames::POSITION => 'head honcho',
			)
		);
		
		return $row;
	}
	
	private function GetEmailPrefRows()
	{
		$row = array
		(
			array(ColumnNames::EVENT_CATEGORY => 'reservation', ColumnNames::EVENT_TYPE => ReservationEvent::Created),
			array(ColumnNames::EVENT_CATEGORY => 'reservation', ColumnNames::EVENT_TYPE => ReservationEvent::Updated),
		);
		
		return $row;
	}

	private function GetRow($userId, $first, $last, $email, $userName, $lastLogin, $timezone = 'UTC', $statusId = AccountStatus::ACTIVE)
	{
		return
			array(
				ColumnNames::USER_ID => $userId,
				ColumnNames::USERNAME => $userName,
				ColumnNames::FIRST_NAME => $first,
				ColumnNames::LAST_NAME => $last,
				ColumnNames::EMAIL => $email,
				ColumnNames::LAST_LOGIN => $lastLogin,
				ColumnNames::TIMEZONE_NAME => $timezone,
				ColumnNames::USER_STATUS_ID => $statusId
			);
	}

	private function GetPermissionsRows()
	{
		return array (
			array (ColumnNames::RESOURCE_ID => 1),
			array (ColumnNames::RESOURCE_ID => 2),
			array (ColumnNames::RESOURCE_ID => 3),
		);
	}

	private function GetGroupsRows()
	{
		return array (
			array (ColumnNames::GROUP_ID => 98017),
			array (ColumnNames::GROUP_ID => 128736),
		);
	}
}
?>
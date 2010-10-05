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
		$userRows = array
		(
			array(ColumnNames::USER_ID => 1, ColumnNames::FIRST_NAME => "f1", ColumnNames::LAST_NAME => 'l1', ColumnNames::EMAIL => 'e1'),
			array(ColumnNames::USER_ID => 2, ColumnNames::FIRST_NAME => "f2", ColumnNames::LAST_NAME => 'l2', ColumnNames::EMAIL => 'e2'),
			array(ColumnNames::USER_ID => 3, ColumnNames::FIRST_NAME => "f3", ColumnNames::LAST_NAME => 'l3', ColumnNames::EMAIL => 'e3'),
		);
		
		$this->db->SetRows($userRows);
		
		$userRepository = new UserRepository();
		$users = $userRepository->GetAll();
		
		$user1 = new UserDto(1, "f1", "l1", "e1");
		$user2 = new UserDto(2, "f2", "l2", "e2");
		$user3 = new UserDto(3, "f3", "l3", "e3");
		
		$getAllUsersCommand = new GetAllUsersByStatusCommand(AccountStatus::ACTIVE);
		
		$this->assertEquals($user1, $users[0]);
		$this->assertEquals($user2, $users[1]);
		$this->assertEquals($user3, $users[2]);
		
		$this->assertEquals(1, count($this->db->_Commands));
		$this->assertEquals($getAllUsersCommand, $this->db->_Commands[0]);
	}
}
?>
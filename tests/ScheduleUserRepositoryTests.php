<?php 
class ScheduleUserRepositoryTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}
	
	public function teardown()
	{
		parent::teardown();
	}
	
	public function testPullsAllResourcesAndGroupsForUser()
	{
		$userId = 10;
		
		$userResourceRoles = array
		(
			array(ColumnNames::USER_ID => $userId, ColumnNames::RESOURCE_ID => 1, ColumnNames::RESOURCE_NAME => 'r1'),
			array(ColumnNames::USER_ID => $userId, ColumnNames::RESOURCE_ID => 2, ColumnNames::RESOURCE_NAME => 'r2'),
			array(ColumnNames::USER_ID => $userId, ColumnNames::RESOURCE_ID => 3, ColumnNames::RESOURCE_NAME => 'r3'),
		);
		
		$groupResourceRoles = array
		(
			array(ColumnNames::GROUP_ID => 200, ColumnNames::RESOURCE_ID => 2, ColumnNames::RESOURCE_NAME => 'r2'),
			array(ColumnNames::GROUP_ID => 100, ColumnNames::RESOURCE_ID => 3, ColumnNames::RESOURCE_NAME => 'r3'),
			array(ColumnNames::GROUP_ID => 100, ColumnNames::RESOURCE_ID => 4, ColumnNames::RESOURCE_NAME => 'r4'),
			array(ColumnNames::GROUP_ID => 200, ColumnNames::RESOURCE_ID => 5, ColumnNames::RESOURCE_NAME => 'r5'),
		);
		
		$this->db->SetRow(0, $userResourceRoles);
		$this->db->SetRow(1, $groupResourceRoles);
		
		$repo = new ScheduleUserRepository();
		$user = $repo->GetUser($userId);
		
		$userCommand = new SelectUserPermissions($userId);
		$groupCommand = new SelectUserGroupPermissions($userId);
		
		$this->assertEquals(2, count($this->db->_Commands));
		$this->assertEquals($userCommand, $this->db->_Commands[0]);
		$this->assertEquals($groupCommand, $this->db->_Commands[1]);
	}
}
?>
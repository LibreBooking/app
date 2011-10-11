<?php
require_once(ROOT_DIR . 'Domain/namespace.php');

class UserTests extends TestBase
{
	public function testUserIsGroupAdminIfAtLeastOneGroupIsAnAdminGroup()
	{
		$user = new User();

		$nonAdminGroup = new UserGroup(1, 'non admin', 2, RoleLevel::NONE);
		$adminGroup = new UserGroup(2, 'admin', null, RoleLevel::GROUP_ADMIN);
		$groups = array($nonAdminGroup, $adminGroup);

		$user->WithGroups($groups);

		$this->assertTrue($user->IsGroupAdmin());
	}
	
	public function testWhenUserIsInAGroupThatCanAdminAnotherGroup()
	{
		$adminGroupId = 99;
		$groupId1 = 1;
		$groupId2 = 2;
		
		$adminUser = new User();
		$user = new User();

		$adminGroup = new UserGroup($adminGroupId, 'admin', null, RoleLevel::NONE);
		$adminGroup->AddRole(RoleLevel::GROUP_ADMIN);
		$group1 = new UserGroup($groupId1, 'random group');
		$group2 = new UserGroup($groupId2, 'group with admin', $adminGroupId, RoleLevel::NONE);
		
		$adminUserGroups = array($group1, $adminGroup);
		$userGroups = array($group2);
		
		$adminUser->WithGroups($adminUserGroups);
		$user->WithGroups($userGroups);

		$this->assertTrue($adminUser->IsAdminFor($user), 'admin of group 2');
	}

	public function testWhenUserIsNotInAGroupThatCanAdminAnotherGroup()
	{
		$adminGroupId = 99;
		$groupId1 = 1;
		$groupId2 = 2;

		$adminUser = new User();
		$user = new User();

		$adminGroup = new UserGroup($adminGroupId, 'admin', null, RoleLevel::GROUP_ADMIN);
		$group1 = new UserGroup($groupId1, 'random group');
		$group2 = new UserGroup($groupId2, 'group with admin', $groupId1, RoleLevel::NONE);

		$adminUserGroups = array($group1, $adminGroup);
		$userGroups = array($group1, $group2);

		$adminUser->WithGroups($adminUserGroups);
		$user->WithGroups($userGroups);

		$this->assertFalse($adminUser->IsAdminFor($user), 'admin is not in any group that can admin group 1 or 2');
	}
}
<?php
/**
Copyright 2012-2014 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Application/Admin/namespace.php');

class GroupAdminGroupsRepositoryTests extends TestBase
{
    public function testGetsListOfGroupsThatThisUserCanAdminister()
    {
        $user = new User();
        $adminGroup1 = new UserGroup(1, null, null, RoleLevel::GROUP_ADMIN);
        $adminGroup2 = new UserGroup(2, null, 1, RoleLevel::GROUP_ADMIN);
        $adminGroup3 = new UserGroup(3, null, 1, RoleLevel::GROUP_ADMIN);
        $user->WithOwnedGroups(array($adminGroup1, $adminGroup2, $adminGroup3));

        $userRepo = $this->getMock('IUserRepository');
        $userRepo->expects($this->once())
                ->method('LoadById')
                ->with($this->equalTo($this->fakeUser->UserId))
                ->will($this->returnValue($user));

        $groupRepository = new GroupAdminGroupRepository($userRepo, $this->fakeUser);

		$groupRows = new GroupItemRow();
		$groupRows->With(1, '1');
		$rows = $groupRows->Rows();

        $this->db->SetRow(0, array( array(ColumnNames::TOTAL => 4) ));
        $this->db->SetRow(1, $rows);

        $filter = null;
        $results = $groupRepository->GetList(1, 2, null, null, $filter);

        $getGroupsCommand = new GetAllGroupsCommand();

        $filterCommand = new FilterCommand($getGroupsCommand, new SqlFilterIn(new SqlFilterColumn(TableNames::GROUPS_ALIAS, ColumnNames::GROUP_ID), array(1, 2, 3)));
        $countCommand = new CountCommand($filterCommand);

        $this->assertEquals($countCommand, $this->db->_Commands[0]);
        $this->assertEquals($filterCommand, $this->db->_Commands[1]);

        $resultList = $results->Results();
        $this->assertEquals(count($rows), count($resultList));
        $this->assertInstanceOf('GroupItemView', $resultList[0]);
    }
}


?>
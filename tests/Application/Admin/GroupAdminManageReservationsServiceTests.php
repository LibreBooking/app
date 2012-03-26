<?php
/**
Copyright 2012 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Application/Admin/namespace.php');

class GroupAdminManageReservationsServiceTests extends TestBase
{
    public function testGetsListOfReservationsThatThisUserCanAdminister()
    {
        $user = new User();
        $adminGroup1 = new UserGroup(1, null, null, RoleLevel::GROUP_ADMIN);
        $adminGroup2 = new UserGroup(2, null, 1, RoleLevel::NONE);
        $adminGroup3 = new UserGroup(3, null, 1, RoleLevel::NONE);
        $user->WithGroups(array($adminGroup1, $adminGroup2, $adminGroup3));

        $userRepo = $this->getMock('IUserRepository');
        $userRepo->expects($this->once())
                ->method('LoadById')
                ->with($this->equalTo($this->fakeUser->UserId))
                ->will($this->returnValue($user));

        $service = new GroupAdminManageReservationsService($userRepo);

        $reservationRows = FakeReservationRepository::GetReservationRows();
        $this->db->SetRow(0, array( array(ColumnNames::TOTAL => 4) ));
        $this->db->SetRow(1, $reservationRows);

        $filter = new ReservationFilter();
        $results = $service->LoadFiltered(1, 2, $filter, $this->fakeUser);

        $getGroupReservationsCommand = new GetFullGroupReservationListCommand(array(2, 3));

        $filterCommand = new FilterCommand($getGroupReservationsCommand, $filter->GetFilter());
        $countCommand = new CountCommand($filterCommand);

        $this->assertEquals($countCommand, $this->db->_Commands[0]);
        $this->assertEquals($filterCommand, $this->db->_Commands[1]);

        $resultList = $results->Results();
        $this->assertEquals(count($reservationRows), count($resultList));
        $this->assertInstanceOf('ReservationItemView', $resultList[0]);
    }
}


?>
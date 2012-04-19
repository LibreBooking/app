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

require_once(ROOT_DIR . 'lib/Application/Reservation/ManageBlackoutsService.php');

class ReservationConflictResolutionTests extends TestBase
{
    public function setup()
    {
        parent::setup();
    }

    public function testDeletesReservation()
    {
        $id = 123;
        $reservationView = new TestReservationItemView($id, Date::Now(), Date::Now());

        $repo = $this->getMock('IReservationRepository');
        $handler = new ReservationConflictDelete($repo);

        $builder = new ExistingReservationSeriesBuilder();
        $builder->WithId($id);
        $reservation = $builder->Build();

        $repo->expects($this->once())
                ->method('LoadById')
                ->with($this->equalTo($id))
                ->will($this->returnValue($reservation));

        $repo->expects($this->once())
                ->method('Delete')
                ->with($this->equalTo($reservation));

        $handled = $handler->Handle($reservationView);

        $this->assertTrue($handled);
    }
}
?>
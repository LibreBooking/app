<?php
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
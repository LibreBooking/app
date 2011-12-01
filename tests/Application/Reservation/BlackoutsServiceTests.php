<?php
require_once(ROOT_DIR . 'lib/Application/Reservation/ManageBlackoutsService.php');

class BlackoutsServiceTests extends TestBase
{
	/**
	 * @var ManageBlackoutsService
	 */
	private $service;

	/**
	 * @var IReservationViewRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $reservationViewRepository;

	/**
	 * @var IReservationConflictResolution|PHPUnit_Framework_MockObject_MockObject
	 */
	private $conflictHandler;

	/**
	 * @var IBlackoutRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $blackoutRepository;
	
	public function setup()
	{
		parent::setup();

		$this->reservationViewRepository = $this->getMock('IReservationViewRepository');
		$this->conflictHandler = $this->getMock('IReservationConflictResolution');
		$this->blackoutRepository = $this->getMock('IBlackoutRepository');

		$this->service = new ManageBlackoutsService($this->reservationViewRepository, $this->blackoutRepository);
	}

	public function testCreatesBlackoutForEachResourceWhenNoConflicts()
	{
		$userId = $this->fakeUser->UserId;
		$start = Date::Parse('2011-01-01 01:01:01');
		$end = Date::Parse('2011-02-02 02:02:02');
		$date = new DateRange($start, $end);
		$resourceIds = array(1, 2, 3);
		$title = 'title';

		$blackoutBefore = new TestBlackoutItemView(1, Date::Parse('2010-01-01'), $start, 3);
		$blackoutAfter = new TestBlackoutItemView(2, $end,  Date::Parse('2012-01-01'), 1);
		$blackoutDuring = new TestBlackoutItemView(3, $start,  $end, 4);
		$this->reservationViewRepository->expects($this->once())
			->method('GetBlackoutsWithin')
			->with($this->equalTo($date))
			->will($this->returnValue(array($blackoutBefore, $blackoutAfter, $blackoutDuring)));

		$reservationBefore = new TestReservationItemView(1, Date::Parse('2010-01-01'), $start, 1);
		$reservationAfter =new TestReservationItemView(2, $end,  Date::Parse('2012-01-01'), 2);
		$this->reservationViewRepository->expects($this->once())
			->method('GetReservationList')
			->with($this->equalTo($start), $this->equalTo($end))
			->will($this->returnValue(array($reservationBefore, $reservationAfter)));
		
		$blackout1 = Blackout::Create($userId, $resourceIds[0], $title, $date);
		$blackout2 = Blackout::Create($userId, $resourceIds[1], $title, $date);
		$blackout3 = Blackout::Create($userId, $resourceIds[2], $title, $date);

		$this->blackoutRepository->expects($this->at(0))
			->method('Add')
			->with($this->equalTo($blackout1));

		$this->blackoutRepository->expects($this->at(1))
			->method('Add')
			->with($this->equalTo($blackout2));

		$this->blackoutRepository->expects($this->at(2))
			->method('Add')
			->with($this->equalTo($blackout3));
		
		$result = $this->service->Add($date, $resourceIds, $title, $this->conflictHandler);

		$this->assertTrue($result->WasSuccessful());
	}

	public function testDoesNotAddAnyBlackoutsIfThereAreConflictingBlackoutTimes()
	{
		$start = Date::Parse('2011-01-01 01:01:01');
		$end = Date::Parse('2011-02-02 02:02:02');
		$date = new DateRange($start, $end);
		$resourceIds = array(2, 3);
		$title = 'title';

		$blackoutDuring = new TestBlackoutItemView(1, $start, $end, 3);
		$this->reservationViewRepository->expects($this->once())
			->method('GetBlackoutsWithin')
			->with($this->equalTo($date))
			->will($this->returnValue(array($blackoutDuring)));

		$this->blackoutRepository->expects($this->never())
			->method('Add');
		
		$result = $this->service->Add($date, $resourceIds, $title, $this->conflictHandler);

		$this->assertFalse($result->WasSuccessful());
	}

	public function testConflictHandlerActsOnEachConflictingReservationAndSavesBlackout()
	{
		$userId = $this->fakeUser->UserId;
		$start = Date::Parse('2011-01-01 01:01:01');
		$end = Date::Parse('2011-02-02 02:02:02');
		$date = new DateRange($start, $end);
		$resourceIds = array(2);
		$title = 'title';

		$this->reservationViewRepository->expects($this->once())
			->method('GetBlackoutsWithin')
			->with($this->equalTo($date))
			->will($this->returnValue(array()));

		$reservation1 = new TestReservationItemView(1, $start, $end, 2);
		$reservation2 = new TestReservationItemView(2, $start, $end, 2);
		$this->reservationViewRepository->expects($this->once())
			->method('GetReservationList')
			->with($this->equalTo($start), $this->equalTo($end))
			->will($this->returnValue(array($reservation1, $reservation2)));

		$this->conflictHandler->expects($this->at(0))
			->method('Handle')
			->with($this->equalTo($reservation1))
			->will($this->returnValue(true));

		$this->conflictHandler->expects($this->at(1))
			->method('Handle')
			->with($this->equalTo($reservation2))
			->will($this->returnValue(true));

		$this->blackoutRepository->expects($this->once())
			->method('Add')
			->with($this->equalTo(Blackout::Create($userId, 2, $title, $date)));
		
		$result = $this->service->Add($date, $resourceIds, $title, $this->conflictHandler);

		$this->assertTrue($result->WasSuccessful());
	}

	public function testConflictHandlerReportsConflictingReservationAndDoesNotSaveBlackout()
	{
		$start = Date::Parse('2011-01-01 01:01:01');
		$end = Date::Parse('2011-02-02 02:02:02');
		$date = new DateRange($start, $end);
		$resourceIds = array(2);
		$title = 'title';

		$this->reservationViewRepository->expects($this->once())
			->method('GetBlackoutsWithin')
			->with($this->equalTo($date))
			->will($this->returnValue(array()));

		$reservation1 = new TestReservationItemView(1, $start, $end, 2);
		$reservation2 = new TestReservationItemView(2, $start, $end, 2);
		$this->reservationViewRepository->expects($this->once())
			->method('GetReservationList')
			->with($this->equalTo($start), $this->equalTo($end))
			->will($this->returnValue(array($reservation1, $reservation2)));

		$this->conflictHandler->expects($this->at(0))
			->method('Handle')
			->with($this->equalTo($reservation1))
			->will($this->returnValue(false));

		$this->conflictHandler->expects($this->at(1))
			->method('Handle')
			->with($this->equalTo($reservation2))
			->will($this->returnValue(false));

		$this->blackoutRepository->expects($this->never())
			->method('Add');

		$result = $this->service->Add($date, $resourceIds, $title, $this->conflictHandler);

		$this->assertFalse($result->WasSuccessful());
	}

	public function testNothingIsCheckedIfTimesAreInvalid()
	{
		$date = DateRange::Create('2011-01-01 00:00:00', '2011-01-01 00:00:00', 'UTC');
		$result = $this->service->Add($date, array(1), 'title', $this->conflictHandler);

		$this->assertFalse($result->WasSuccessful());
		$this->assertNotEmpty($result->Message());
	}

    public function testDeletesBlackoutById()
    {
        $blackoutId = 123;;

        $this->blackoutRepository->expects($this->once())
                ->method('Delete')
                ->with($this->equalTo($blackoutId));

        $this->service->Delete($blackoutId);
    }
}

class TestBlackoutItemView extends BlackoutItemView
{
	public function __construct(
		$instanceId,
		Date $startDate,
		Date $endDate,
		$resourceId)
	{
		parent::__construct($instanceId, $startDate, $endDate, $resourceId, null, null, null, null, null, null, null, null);
	}
}
?>
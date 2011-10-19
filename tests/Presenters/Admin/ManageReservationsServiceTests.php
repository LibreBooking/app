<?php

class ManageReservationsServiceTests extends TestBase
{
	/**
	 * @var IReservationRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $reservationRepository;

	/**
	 * @var IReservationViewRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $reservationViewRepository;

	/**
	 * @var ManageReservationsService
	 */
	private $service;
	
	public function setup()
	{
		parent::setup();

		$this->reservationRepository = $this->getMock('IReservationRepository');
		$this->reservationViewRepository = $this->getMock('IReservationViewRepository');

		$this->service = new ManageReservationsService($this->reservationRepository, $this->reservationViewRepository);

	}

	public function testLoadsFilteredResultsAndChecksAuthorizationAgainstPendingReservations()
	{
		$pageNumber = 1;
		$pageSize = 40;
		
		$filter = new ReservationFilter();
		
		$data = new PageableData();
		$this->reservationViewRepository->expects($this->once())
				->method('GetList')
				->with($pageNumber, $pageSize, null, null, $filter->GetFilter())
				->will($this->returnValue($data));

		$actualData = $this->service->LoadFiltered($pageNumber, $pageSize, $filter, $this->fakeUser);
		
		$this->assertEquals($data, $actualData);
	}
	
	public function testServiceDeletesReservation()
	{
		$scope = SeriesUpdateScope::FullSeries;
		$referenceNumber = '123';
		$reservation = $this->getMock('ExistingReservationSeries');

		$this->reservationRepository->expects($this->once())
			->method('LoadByReferenceNumber')
			->with($this->equalTo($referenceNumber))
			->will($this->returnValue($reservation));

		$reservation->expects($this->once())
			->method('ApplyChangesTo')
			->with($this->equalTo($scope));

		$reservation->expects($this->once())
			->method('Delete')
			->with($this->equalTo($this->fakeUser));

		$this->reservationRepository->expects($this->once())
			->method('Delete')
			->with($this->equalTo($reservation));

		$this->service->Delete($referenceNumber, $scope, $this->fakeUser);
	}
}
?>
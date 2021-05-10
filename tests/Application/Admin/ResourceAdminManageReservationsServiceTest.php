<?php

require_once(ROOT_DIR . 'lib/Application/Admin/namespace.php');

class ResourceAdminManageReservationsServiceTests extends TestBase
{
	/**
	 * @var IReservationViewRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $reservationViewRepository;

	/**
	 * @var IUserRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $userRepository;

	/**
	 * @var IReservationAuthorization|PHPUnit_Framework_MockObject_MockObject
	 */
	private $reservationAuthorization;

	/**
	 * @var ManageReservationsService
	 */
	private $service;

	public function setUp(): void
	{
		parent::setup();

		$this->reservationViewRepository = $this->createMock('IReservationViewRepository');
		$this->userRepository = $this->createMock('IUserRepository');
		$this->reservationAuthorization = $this->createMock('IReservationAuthorization');
		$handler = $this->createMock('IReservationHandler');
		$persistenceService = $this->createMock('IUpdateReservationPersistenceService');

		$this->service = new ResourceAdminManageReservationsService($this->reservationViewRepository, $this->userRepository, $this->reservationAuthorization, $handler, $persistenceService);
	}

	public function testLoadsFilteredResultsAndChecksAuthorizationAgainstPendingReservations()
	{
		$pageNumber = 1;
		$pageSize = 40;

		$groups = array(
			new UserGroup(1, '1'),
			new UserGroup(5, '5'),
			new UserGroup(9, '9'),
			new UserGroup(22, '22'),
		);
		$myGroups = array(1, 5, 9, 22);

		$this->userRepository->expects($this->once())
					->method('LoadGroups')
					->with($this->equalTo($this->fakeUser->UserId), $this->equalTo(RoleLevel::RESOURCE_ADMIN))
					->will($this->returnValue($groups));

		$filter = new ReservationFilter();
		$expectedFilter = $filter->GetFilter();
		$expectedFilter->_And(new SqlFilterIn(new SqlFilterColumn(TableNames::RESOURCES, ColumnNames::RESOURCE_ADMIN_GROUP_ID), $myGroups));

		$data = new PageableData();
		$this->reservationViewRepository->expects($this->once())
				->method('GetList')
				->with($pageNumber, $pageSize, null, null, $expectedFilter)
				->will($this->returnValue($data));

		$actualData = $this->service->LoadFiltered($pageNumber, $pageSize, null, null, $filter, $this->fakeUser);

		$this->assertEquals($data, $actualData);
	}
}

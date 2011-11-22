<?php

class BlackoutFilter
{
	private $startDate = null;
	private $endDate = null;
	private $scheduleId = null;
	private $resourceId = null;

	/**
	 * @param Date $startDate
	 * @param Date $endDate
	 * @param int $scheduleId
	 * @param int $resourceId
	 */
	public function __construct($startDate = null, $endDate = null, $scheduleId = null, $resourceId = null)
	{
		$this->startDate = $startDate;
		$this->endDate = $endDate;
		$this->scheduleId = $scheduleId;
		$this->resourceId = $resourceId;
	}

	public function GetFilter()
	{
		$filter = new SqlFilterNull();

		if (!empty($this->startDate)) {
			$filter->_And(new SqlFilterGreaterThan(ColumnNames::RESERVATION_START, $this->startDate->ToDatabase()));
		}
		if (!empty($this->endDate)) {
			$filter->_And(new SqlFilterLessThan(ColumnNames::RESERVATION_END, $this->endDate->ToDatabase()));
		}
		if (!empty($this->scheduleId)) {
			$filter->_And(new SqlFilterEquals(ColumnNames::SCHEDULE_ID, $this->scheduleId));
		}
		if (!empty($this->resourceId)) {
			$filter->_And(new SqlFilterEquals(new SqlFilterColumn(TableNames::RESOURCES, ColumnNames::RESOURCE_ID), $this->resourceId));
		}

		return $filter;
	}
}

interface IManageBlackoutsService
{
	/**
	 * @abstract
	 * @param $pageNumber int
	 * @param $pageSize int
	 * @param $filter BlackoutFilter
	 * @param $user UserSession
	 * @return PageableData
	 */
	public function LoadFiltered($pageNumber, $pageSize, $filter, $user);

	/**
	 * @abstract
	 * @param DateRange $blackoutDate
	 * @param array|int[] $resourceIds
	 * @param string $title
	 * @param IReservationConflictResolution $reservationConflictResolution
	 * @return void
	 */
	public function Add(DateRange $blackoutDate, $resourceIds, $title, IReservationConflictResolution $reservationConflictResolution);
}

class ManageBlackoutsService implements IManageBlackoutsService
{
	/**
	 * @var IReservationViewRepository
	 */
	private $reservationViewRepository;

	public function __construct(IReservationViewRepository $reservationViewRepository)
	{
		$this->reservationViewRepository = $reservationViewRepository;
	}

	public function LoadFiltered($pageNumber, $pageSize, $filter, $user)
	{
		return $this->reservationViewRepository->GetBlackoutList($pageNumber, $pageSize, null, null, $filter->GetFilter());
	}

	public function Add(DateRange $blackoutDate, $resourceIds, $title, IReservationConflictResolution $reservationConflictResolution)
	{
		// create blackout per resource
		// check conflicting blackouts
		// check conflicting reservations, handle
		// add each blackout
	}
}
?>
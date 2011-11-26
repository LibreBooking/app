<?php
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

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

		if (!empty($this->startDate))
		{
			$filter->_And(new SqlFilterGreaterThan(ColumnNames::RESERVATION_START, $this->startDate->ToDatabase()));
		}
		if (!empty($this->endDate))
		{
			$filter->_And(new SqlFilterLessThan(ColumnNames::RESERVATION_END, $this->endDate->ToDatabase()));
		}
		if (!empty($this->scheduleId))
		{
			$filter->_And(new SqlFilterEquals(ColumnNames::SCHEDULE_ID, $this->scheduleId));
		}
		if (!empty($this->resourceId))
		{
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
	 * @return BlackoutValidationResult
	 */
	public function Add(DateRange $blackoutDate, $resourceIds, $title, IReservationConflictResolution $reservationConflictResolution);
}

class BlackoutValidationResult
{
	/**
	 * @var array|Blackout[]
	 */
	private $conflictingBlackouts;

	/**
	 * @var array|ReservationItemView[]
	 */
	private $conflictingReservations;

	/**
	 * @param array|Blackout[] $conflictingBlackouts
	 * @param array|ReservationItemView[] $conflictingReservations
	 */
	public function __construct($conflictingBlackouts, $conflictingReservations)
	{
		$this->conflictingBlackouts = $conflictingBlackouts;
		$this->conflictingReservations = $conflictingReservations;
	}

	/**
	 * @return bool
	 */
	public function WasSuccessful()
	{
		return $this->CanBeSaved();
	}

	/**
	 * @return bool
	 */
	public function CanBeSaved()
	{
		return empty($this->conflictingBlackouts) && empty($this->conflictingReservations);
	}
}

class ManageBlackoutsService implements IManageBlackoutsService
{
	/**
	 * @var IReservationViewRepository
	 */
	private $reservationViewRepository;

	/**
	 * @var IBlackoutRepository
	 */
	private $blackoutRepository;

	public function __construct(IReservationViewRepository $reservationViewRepository, IBlackoutRepository $blackoutRepository)
	{
		$this->reservationViewRepository = $reservationViewRepository;
		$this->blackoutRepository = $blackoutRepository;
	}

	public function LoadFiltered($pageNumber, $pageSize, $filter, $user)
	{
		return $this->reservationViewRepository->GetBlackoutList($pageNumber, $pageSize, null, null, $filter->GetFilter());
	}

	public function Add(DateRange $blackoutDate, $resourceIds, $title, IReservationConflictResolution $reservationConflictResolution)
	{
		$userId = ServiceLocator::GetServer()->GetUserSession()->UserId;

		/** @var $blackouts array|Blackout[] */
		$blackouts = array();
		foreach ($resourceIds as $resourceId)
		{
			$blackouts[] = Blackout::Create($userId, $resourceId, $title, $blackoutDate);
		}

		$conflictingBlackouts = $this->GetConflictingBlackouts($blackouts, $blackoutDate);

		$conflictingReservations = array();
		if (empty($conflictingBlackouts))
		{
			$conflictingReservations = $this->GetConflictingReservations($blackouts, $blackoutDate, $reservationConflictResolution);
		}

		$blackoutValidationResult = new BlackoutValidationResult($conflictingBlackouts, $conflictingReservations);
		
		if ($blackoutValidationResult->CanBeSaved())
		{
			foreach ($blackouts as $blackout)
			{
				$this->blackoutRepository->Add($blackout);
			}
		}
		
		return $blackoutValidationResult;
	}

	/**
	 * @param array|Blackout[] $blackouts
	 * @param DateRange $blackoutDate
	 * @param IReservationConflictResolution $reservationConflictResolution
	 * @return array|ReservationItemView[]
	 */
	private function GetConflictingReservations($blackouts, $blackoutDate, $reservationConflictResolution)
	{
		$conflictingReservations = array();
		$existingReservations = $this->reservationViewRepository->GetReservationList($blackoutDate->GetBegin(), $blackoutDate->GetEnd());

		foreach ($existingReservations as $existingReservation)
		{
			foreach ($blackouts as $blackout)
			{
				if ($existingReservation->ResourceId == $blackout->ResourceId() && $blackout->Date()->Overlaps($existingReservation->Date))
				{
					if (!$reservationConflictResolution->Handle($existingReservation))
					{
						$conflictingReservations[] = $existingReservation;
					}
				}
			}
		}

		return $conflictingReservations;
	}

	/**
	 * @param array|Blackout[] $blackouts
	 * @param DateRange $blackoutDate
	 * @return array|Blackout[]
	 */
	private function GetConflictingBlackouts($blackouts, $blackoutDate)
	{
		$conflictingBlackouts = array();
		$existingBlackouts = $this->reservationViewRepository->GetBlackoutsWithin($blackoutDate);

		foreach ($existingBlackouts as $existingBlackout)
		{
			foreach ($blackouts as $blackout)
			{
				if ($existingBlackout->ResourceId == $blackout->ResourceId() && $blackout->Date()->Overlaps($existingBlackout->Date))
				{
					$conflictingBlackouts[] = $blackout;
				}
			}
		}

		return $conflictingBlackouts;
	}
}

?>
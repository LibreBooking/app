<?php
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/BlackoutFilter.php');

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
	 * @return IBlackoutValidationResult
	 */
	public function Add(DateRange $blackoutDate, $resourceIds, $title, IReservationConflictResolution $reservationConflictResolution);
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

    /**
     * @param int $pageNumber
     * @param int $pageSize
     * @param BlackoutFilter $filter
     * @param UserSession $user
     * @return BlackoutItemView[]|PageableData
     */
	public function LoadFiltered($pageNumber, $pageSize, $filter, $user)
	{
		return $this->reservationViewRepository->GetBlackoutList($pageNumber, $pageSize, null, null, $filter->GetFilter());
	}

	public function Add(DateRange $blackoutDate, $resourceIds, $title, IReservationConflictResolution $reservationConflictResolution)
	{
		if (!$blackoutDate->GetEnd()->GreaterThan($blackoutDate->GetBegin()))
		{
			return new BlackoutDateTimeValidationResult();
		}
		
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
	 * @return array|BlackoutItemView[]
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
					$conflictingBlackouts[] = $existingBlackout;
				}
			}
		}

		return $conflictingBlackouts;
	}

    /**
     * @param int $blackoutId
     */
    public function Delete($blackoutId)
    {
        $this->blackoutRepository->Delete($blackoutId);
    }
}

?>
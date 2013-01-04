<?php
/**
Copyright 2011-2013 Nick Korbel

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
	 * @param IRepeatOptions $repeatOptions
	 * @return IBlackoutValidationResult
	 */
	public function Add(DateRange $blackoutDate, $resourceIds, $title, IReservationConflictResolution $reservationConflictResolution, IRepeatOptions $repeatOptions);

	/**
	 * @param int $blackoutId
	 */
	public function Delete($blackoutId);
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

	/**
	 * @var IUserRepository
	 */
	private $userRepository;

	public function __construct(IReservationViewRepository $reservationViewRepository, IBlackoutRepository $blackoutRepository, IUserRepository $userRepository)
	{
		$this->reservationViewRepository = $reservationViewRepository;
		$this->blackoutRepository = $blackoutRepository;
		$this->userRepository = $userRepository;
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
		$blackoutFilter = $filter->GetFilter();
		if (!$user->IsAdmin)
		{
			$groups = $this->userRepository->LoadGroups($user->UserId, array(RoleLevel::RESOURCE_ADMIN, RoleLevel::SCHEDULE_ADMIN));
			$groupIds = array();
			foreach ($groups as $group)
			{
				$groupIds[] = $group->GroupId;
			}
			$adminFilter = new SqlFilterIn(new SqlFilterColumn(TableNames::RESOURCES, ColumnNames::RESOURCE_ADMIN_GROUP_ID), $groupIds);
			$adminFilter->_Or(new SqlFilterIn(new SqlFilterColumn(TableNames::SCHEDULES, ColumnNames::SCHEDULE_ADMIN_GROUP_ID), $groupIds));
			$blackoutFilter->_And($adminFilter);
		}

		return $this->reservationViewRepository->GetBlackoutList($pageNumber, $pageSize, null, null, $blackoutFilter);
	}

	public function Add(DateRange $blackoutDate, $resourceIds, $title, IReservationConflictResolution $reservationConflictResolution, IRepeatOptions $repeatOptions)
	{
		if (!$blackoutDate->GetEnd()->GreaterThan($blackoutDate->GetBegin()))
		{
			return new BlackoutDateTimeValidationResult();
		}

		$userId = ServiceLocator::GetServer()->GetUserSession()->UserId;

		$dates = array_merge(array($blackoutDate), $repeatOptions->GetDates($blackoutDate));

		/** @var $blackouts array|Blackout[] */
		$blackouts = array();
		foreach ($resourceIds as $resourceId)
		{
			foreach ($dates as $date)
			{
				$blackouts[] = Blackout::Create($userId, $resourceId, $title, $date);
			}
		}

		$conflictingBlackouts = $this->GetConflictingBlackouts($blackouts);

		$conflictingReservations = array();
		if (empty($conflictingBlackouts))
		{
			$conflictingReservations = $this->GetConflictingReservations($blackouts, $reservationConflictResolution);
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
	 * @param IReservationConflictResolution $reservationConflictResolution
	 * @return array|ReservationItemView[]
	 */
	private function GetConflictingReservations($blackouts, $reservationConflictResolution)
	{
		$conflictingReservations = array();

		foreach ($blackouts as $blackout)
		{
			$existingReservations = $this->reservationViewRepository->GetReservationList($blackout->StartDate(), $blackout->EndDate(), null, null, null, $blackout->ResourceId());

			foreach ($existingReservations as $existingReservation)
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
	 * @return array|BlackoutItemView[]
	 */
	private function GetConflictingBlackouts($blackouts)
	{
		$conflictingBlackouts = array();
		foreach ($blackouts as $blackout)
		{
			$existingBlackouts = $this->reservationViewRepository->GetBlackoutsWithin($blackout->Date());

			foreach ($existingBlackouts as $existingBlackout)
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
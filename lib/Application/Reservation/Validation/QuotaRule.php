<?php

/**
 * Copyright 2011-2020 Nick Korbel
 *
 * This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

class QuotaRule implements IReservationValidationRule
{
	/**
	 * @var \IQuotaRepository
	 */
	private $quotaRepository;

	/**
	 * @var \IReservationViewRepository
	 */
	private $reservationViewRepository;

	/**
	 * @var \IUserRepository
	 */
	private $userRepository;

	/**
	 * @var \IScheduleRepository
	 */
	private $scheduleRepository;

	/**
	 * @var IQuotaViewRepository
	 */
	private $quotaViewRepository;

	public function __construct(IQuotaRepository $quotaRepository,
								IReservationViewRepository $reservationViewRepository,
								IUserRepository $userRepository,
								IScheduleRepository $scheduleRepository,
								IQuotaViewRepository $quotaViewRepository)
	{
		$this->quotaRepository = $quotaRepository;
		$this->reservationViewRepository = $reservationViewRepository;
		$this->userRepository = $userRepository;
		$this->scheduleRepository = $scheduleRepository;
		$this->quotaViewRepository = $quotaViewRepository;
	}

	/**
	 * @param ReservationSeries $reservationSeries
	 * @param $retryParameters
	 * @return ReservationRuleResult
	 */
	public function Validate($reservationSeries, $retryParameters)
	{
		$quotas = $this->quotaRepository->LoadAll();
		$user = $this->userRepository->LoadById($reservationSeries->UserId());
		$schedule = $this->scheduleRepository->LoadById($reservationSeries->ScheduleId());

		$quotaViews = $this->GetQuotaView();

		foreach ($quotas as $quota)
		{
			if ($quota->ExceedsQuota($reservationSeries, $user, $schedule, $this->reservationViewRepository))
			{
				Log::Debug('Quota exceeded. %s', $quota->ToString());
				$item = isset($quotaViews[$quota->Id()]) ? $quotaViews[$quota->Id()] : null;
				return new ReservationRuleResult(false, $this->GetDescription($item));
			}
		}

		return new ReservationRuleResult();
	}

	/**
	 * @return QuotaItemView[]
	 */
	private function GetQuotaView()
	{
		$quotas = $this->quotaViewRepository->GetAll();
		$views = array();
		foreach ($quotas as $quota)
		{
			$views[$quota->Id] = $quota;
		}

		return $views;
	}

	/**
	 * @param QuotaItemView $item
	 * @return mixed|string
	 */
	private function GetDescription($item)
	{
		if ($item == null)
		{
			return '';
		}

		$resources = Resources::GetInstance();
		$config = $resources->GetString('QuotaConfiguration', array(
																	(empty($item->ScheduleName) ? $resources->GetString('AllSchedules') : $item->ScheduleName),
																	(empty($item->ResourceName) ? $resources->GetString('AllResources') : $item->ResourceName),
																	(empty($item->GroupName) ? $resources->GetString('AllGroups') : $item->GroupName),
																	$item->Limit,
																	$resources->GetString($item->Unit),
																	$resources->GetString($item->Duration),
																	($item->Scope == QuotaScope::IncludeCompleted) ? $resources->GetString('IncludingCompletedReservations') : $resources->GetString('NotCountingCompletedReservations'),
																	$resources->GetString($item->Scope))
		);


		$enforcementParams = array();
		if ($item->AllDay)
		{
			$enforcementParams[] = $resources->GetString('AllDay');
		}
		else
		{
			$enforcementParams[] = $resources->GetString('Between') . ' ' . $item->EnforcedStartTime->Format('h:ia') . ' - ' . $item->EnforcedEndTime->Format('h:ia');
		}

		if ($item->Everyday)
		{
			$enforcementParams[] = $resources->GetString('Everyday');
		}
		else
		{
			$dayNames = array(
					0 => 'DaySundayAbbr',
					1 => 'DayMondayAbbr',
					2 => 'DayTuesdayAbbr',
					3 => 'DayWednesdayAbbr',
					4 => 'DayThursdayAbbr',
					5 => 'DayFridayAbbr',
					6 => 'DaySaturdayAbbr',
			);
			$days = '';
			foreach ($item->EnforcedDays as $day)
			{
				$days .= $resources->GetString($dayNames[$day]) . ' ';
			}
			$enforcementParams[] = $days;
		}

		$scope = '';
		if ($item->Scope == QuotaScope::IncludeCompleted)
		{
			$scope = $resources->GetString('IncludingCompletedReservations');
		}
		else
		{
			$scope = $resources->GetString('NotCountingCompletedReservations');
		}

		$enforcement = $resources->GetString('QuotaEnforcement', $enforcementParams);

		return $config . ' ' . $scope . '. ' . $enforcement;
	}
}
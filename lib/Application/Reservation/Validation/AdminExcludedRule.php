<?php
/**
Copyright 2011-2020 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

class AdminExcludedRule implements IReservationValidationRule
{
	/**
	 * @var IReservationValidationRule
	 */
	private $rule;

	/**
	 * @var UserSession
	 */
	private $userSession;

	/**
	 * @var IUserRepository
	 */
	private $userRepository;

	public function __construct(IReservationValidationRule $baseRule, UserSession $userSession, IUserRepository $userRepository)
	{
		$this->rule = $baseRule;
		$this->userSession = $userSession;
		$this->userRepository = $userRepository;
	}

	public function Validate($reservationSeries, $retryParameters)
	{
		if ($this->userSession->IsAdmin)
		{
			Log::Debug('User is application admin. Skipping check. UserId=%s', $this->userSession->UserId);

			return new ReservationRuleResult(true);
		}

		if ($this->userSession->IsGroupAdmin || $this->userSession->IsResourceAdmin || $this->userSession->IsScheduleAdmin)
		{
			if ($this->userSession->IsGroupAdmin)
			{
				$user = $this->userRepository->LoadById($this->userSession->UserId);
				$reservationUser = $this->userRepository->LoadById($reservationSeries->UserId());

				if ($user->IsAdminFor($reservationUser)){
					Log::Debug('User is admin for reservation user. Skipping check. UserId=%s', $this->userSession->UserId);
					return new ReservationRuleResult(true);
				}
			}

			if ($this->userSession->IsResourceAdmin || $this->userSession->IsScheduleAdmin)
			{
				$user = $this->userRepository->LoadById($this->userSession->UserId);
				$isResourceAdmin = true;

				foreach($reservationSeries->AllResources() as $resource)
				{
					if (!$user->IsResourceAdminFor($resource))
					{
						$isResourceAdmin = false;
						break;
					}
				}

				if ($isResourceAdmin)
				{
					Log::Debug('User is admin for all resources. Skipping check. UserId=%s', $this->userSession->UserId);
					return new ReservationRuleResult(true);
				}
			}
		}

		return $this->rule->Validate($reservationSeries, $retryParameters);
	}
}
<?php
/**
Copyright 2011-2014 Nick Korbel

This file is part of Booked SchedulerBooked SchedulereIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later versBooked SchedulerduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
alBooked SchedulercheduleIt.  If not, see <http://www.gnu.org/licenses/>.
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

	public function __construct(IQuotaRepository $quotaRepository, IReservationViewRepository $reservationViewRepository, IUserRepository $userRepository, IScheduleRepository $scheduleRepository)
	{
		$this->quotaRepository = $quotaRepository;
		$this->reservationViewRepository = $reservationViewRepository;
		$this->userRepository = $userRepository;
		$this->scheduleRepository = $scheduleRepository;
	}

	/**
	 * @param ReservationSeries $reservationSeries
	 * @return ReservationRuleResult
	 */
	public function Validate($reservationSeries)
	{
		$quotas = $this->quotaRepository->LoadAll();
		$user = $this->userRepository->LoadById($reservationSeries->UserId());
		$schedule = $this->scheduleRepository->LoadById($reservationSeries->ScheduleId());

		foreach ($quotas as $quota)
		{
			if ($quota->ExceedsQuota($reservationSeries, $user, $schedule, $this->reservationViewRepository))
			{
				Log::Debug('Quota exceeded. %s', $quota->ToString());
				return new ReservationRuleResult(false, Resources::GetInstance()->GetString('QuotaExceeded'));
			}
		}

		return new ReservationRuleResult();
	}
}

?>
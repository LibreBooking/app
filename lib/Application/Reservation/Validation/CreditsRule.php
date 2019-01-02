<?php

/**
 * Copyright 2017-2019 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Domain/Access/UserRepository.php');

class CreditsRule implements IReservationValidationRule
{
	/**
	 * @var IUserRepository
	 */
	private $userRepository;
	/**
	 * @var UserSession
	 */
	private $user;

	public function __construct(IUserRepository $userRepository, UserSession $user)
	{
		$this->userRepository = $userRepository;
		$this->user = $user;
	}

	public function Validate($reservationSeries, $retryParameters)
	{
		if (!Configuration::Instance()->GetSectionKey(ConfigSection::CREDITS, ConfigKeys::CREDITS_ENABLED, new BooleanConverter()))
		{
			return new ReservationRuleResult();
		}

		$user = $this->userRepository->LoadById($this->user->UserId);
		$userCredits = $user->GetCurrentCredits();

		$creditsConsumedByThisReservation = $reservationSeries->GetCreditsConsumed();
		$creditsRequired = $reservationSeries->GetCreditsRequired();

		Log::Debug('Credits allocated to reservation=%s, Credits required=%s, Credits available=%s, ReservationSeriesId=%s, UserId=%s',
				   $creditsConsumedByThisReservation, $creditsRequired, $userCredits,$reservationSeries->SeriesId(), $user->Id());

		return new ReservationRuleResult($creditsRequired <= $userCredits + $creditsConsumedByThisReservation,
										 Resources::GetInstance()->GetString('CreditsRule', array($creditsRequired, $userCredits)));
	}
}

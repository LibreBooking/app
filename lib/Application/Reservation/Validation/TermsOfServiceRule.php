<?php
/**
Copyright 2018-2019 Nick Korbel

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

class TermsOfServiceRule implements IReservationValidationRule
{
    /**
     * @var ITermsOfServiceRepository
     */
    private $termsOfServiceRepository;

    public function __construct(ITermsOfServiceRepository $termsOfServiceRepository)
    {
        $this->termsOfServiceRepository = $termsOfServiceRepository;
    }

	/**
	 * @see IReservationValidationRule::Validate()
	 *
	 * @param ReservationSeries $reservationSeries
	 * @param null|ReservationRetryParameter[] $retryParameters
	 * @return ReservationRuleResult
	 */
	public function Validate($reservationSeries, $retryParameters)
	{
		if (!$reservationSeries->HasAcceptedTerms())
        {
            $terms = $this->termsOfServiceRepository->Load();
            if ($terms != null && $terms->AppliesToReservation())
            {
                return new ReservationRuleResult(false, Resources::GetInstance()->GetString('TermsOfServiceError'));
            }
        }

		return new ReservationRuleResult();
	}
}
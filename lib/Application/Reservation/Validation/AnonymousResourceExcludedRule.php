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

class AnonymousResourceExcludedRule implements IReservationValidationRule
{
    /**
     * @var IReservationValidationRule
     */
    private $rule;
	/**
	 * @var UserSession
	 */
	private $session;

	public function __construct(IReservationValidationRule $baseRule, UserSession $session)
    {
        $this->rule = $baseRule;
		$this->session = $session;
	}

    public function Validate($reservationSeries, $retryParameters)
    {
    	if ($this->session->IsLoggedIn())
		{
			return new ReservationRuleResult(true);
		}

        foreach ($reservationSeries->AllResources() as $resource)
        {
            if ($resource->GetIsDisplayEnabled())
            {
                return new ReservationRuleResult(true);
            }
        }

		return new ReservationRuleResult(false);
    }
}
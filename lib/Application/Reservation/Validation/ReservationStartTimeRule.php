<?php
/**
Copyright 2011-2012 Nick Korbel

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

require_once(ROOT_DIR . 'Domain/Values/ReservationStartTimeConstraint.php');

class ReservationStartTimeRule implements IReservationValidationRule
{
    public function __construct(IScheduleRepository $scheduleRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
    }

	/**
	 * @param ReservationSeries $reservationSeries
	 * @return ReservationRuleResult
	 */
	public function Validate($reservationSeries)
	{
        $constraint = Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION, ConfigKeys::RESERVATION_START_TIME_CONSTRAINT);

        if (empty($constraint))
        {
            $constraint = ReservationStartTimeConstraint::_DEFAULT;
        }

        if ($constraint == ReservationStartTimeConstraint::NONE)
        {
            return new ReservationRuleResult();
        }

        $currentInstance = $reservationSeries->CurrentInstance();

        $dateThatShouldBeLessThanNow = $currentInstance->StartDate();
        if ($constraint == ReservationStartTimeConstraint::CURRENT)
        {
            $timezone = $dateThatShouldBeLessThanNow->GetDate()->Timezone();
            $currentPeriod = $this->scheduleRepository->GetLayout($reservationSeries->ScheduleId(), new ScheduleLayoutFactory($timezone))->GetPeriod($currentInstance->StartDate());
            $dateThatShouldBeLessThanNow = $currentPeriod->EndDate();
        }
		Log::Debug("Start Time Rule: Comparing %s to %s", $dateThatShouldBeLessThanNow, Date::Now());
		
		$startIsInFuture = $dateThatShouldBeLessThanNow->Compare(Date::Now()) >= 0;
		return new ReservationRuleResult($startIsInFuture, Resources::GetInstance()->GetString('StartIsInPast'));
	}
}
?>
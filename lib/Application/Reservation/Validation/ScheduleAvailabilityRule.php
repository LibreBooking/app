<?php
/**
 * Copyright 2018-2019 Nick Korbel
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

require_once(ROOT_DIR . 'Domain/Access/ScheduleRepository.php');

class ScheduleAvailabilityRule implements IReservationValidationRule
{
    /**
     * @var IScheduleRepository
     */
    protected $scheduleRepository;

    public function __construct(IScheduleRepository $scheduleRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
    }

    public function Validate($reservationSeries, $retryParameters)
    {
        $schedule = $this->scheduleRepository->LoadById($reservationSeries->ScheduleId());

        if (!$schedule->HasAvailability())
        {
            return new ReservationRuleResult();
        }

        $reservations = $reservationSeries->SortedInstances();

        reset($reservations);
        $key = key($reservations);
        $first = $reservations[$key];

        end($reservations);
        $key = key($reservations);
        $last = $reservations[$key];
        reset($reservations);

        $beginAvailability = $schedule->GetAvailabilityBegin();
        $endAvailability = $schedule->GetAvailabilityEnd();
        $isValid = $first->StartDate()->GreaterThanOrEqual($beginAvailability) &&
            $last->EndDate()->LessThanOrEqual($endAvailability);

        $resources = Resources::GetInstance();
        $format = $resources->GetDateFormat(ResourceKeys::DATE_GENERAL);
        $tz = $schedule->GetTimezone();

        return new ReservationRuleResult($isValid, $resources->GetString('ScheduleAvailabilityError',
            array($beginAvailability->ToTimezone($tz)->Format($format), $endAvailability->ToTimezone($tz)->Format($format)))
        );
    }

    /**
     * @param array $conflicts
     * @return string
     */
    protected function GetErrorString($conflicts)
    {
        $errorString = new StringBuilder();

        $errorString->Append(Resources::GetInstance()->GetString('ConflictingAccessoryDates'));
        $errorString->AppendLine();
        $format = Resources::GetInstance()->GetDateFormat(ResourceKeys::DATE_GENERAL);

        foreach ($conflicts as $conflict) {
            $errorString->Append(sprintf('(%s) %s', $conflict['date']->ToTimezone($this->timezone)->Format($format), $conflict['name']));
            $errorString->AppendLine();
        }

        return $errorString->ToString();
    }
}
<?php
/**
 * Copyright 2020 Nick Korbel
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

//////////////////
/* Cron Example //
//////////////////

This script must be executed every minute for to enable automatic reservation extension functionality

* * * * * php /home/mydomain/public_html/booked/Jobs/auto-extend.php
* * * * * /path/to/php /home/mydomain/public_html/booked/Jobs/auto-extend.php

*/

define('ROOT_DIR', dirname(__FILE__) . '/../');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Jobs/JobCop.php');

const JOB_NAME = 'auto-extend';

Log::Debug('Running %s', JOB_NAME);

JobCop::EnsureCommandLine();
JobCop::EnforceSchedule(JOB_NAME, 1);

try {
    $fiveMinAgo = Date::Now()->SubtractMinutes(-5);
    $now = Date::Now();
    $alreadySeen = array();

    $missedCheckOutSql = 'SELECT `ri`.`reservation_instance_id`, `r`.`resource_id`, `ri`.`end_date` 
    FROM `reservation_instances` `ri` 
    INNER JOIN `reservation_series` `rs` ON `rs`.`series_id` = `ri`.`series_id`
    INNER JOIN `reservation_resources` `rr` ON `rs`.`series_id` = `rr`.`series_id`
    INNER JOIN `resources` `r` ON `r`.`resource_id` = `rr`.`resource_id`
    WHERE `r`.`enable_check_in` = 1 
      AND `r`.`auto_extend_reservations` = 1
      AND `ri`.`checkout_date` IS NULL 
      AND `ri`.`end_date` >= @five_minutes_ago 
      AND `ri`.`end_date` < @now
      AND `rs`.`status_id` <> 2';

    $missedCheckoutCommand = new AdHocCommand($missedCheckOutSql);
    $missedCheckoutCommand->AddParameter(new Parameter('@five_minutes_ago', $fiveMinAgo->ToDatabase()));
    $missedCheckoutCommand->AddParameter(new Parameter('@now', $now->ToDatabase()));
    $missedCheckoutReader = ServiceLocator::GetDatabase()->Query($missedCheckoutCommand);

    while ($missedCheckoutRow = $missedCheckoutReader->GetRow()) {
        $currentEndDate = Date::FromDatabase($missedCheckoutRow[ColumnNames::RESERVATION_END]);
        $reservationInstanceId = $missedCheckoutRow[ColumnNames::RESERVATION_INSTANCE_ID];

        if (array_key_exists($reservationInstanceId, $alreadySeen)) {
            continue;
        }
        $alreadySeen[$reservationInstanceId] = 1;

        $nextReservationSql = 'SELECT `ri`.`start_date` 
    FROM `reservation_instances` `ri` 
    INNER JOIN `reservation_series` `rs` ON `rs`.`series_id` = `ri`.`series_id`
    INNER JOIN `reservation_resources` `rr` ON `rs`.`series_id` = `rr`.`series_id`
    WHERE `ri`.`start_date` > @endDate AND `rr`.`resource_id` = @resourceid
    ORDER BY `ri`.`start_date` ASC
    LIMIT 1';
        $nextReservationCommand = new AdHocCommand($nextReservationSql);
        $nextReservationCommand->AddParameter(new Parameter(ParameterNames::END_DATE, $currentEndDate->ToDatabase()));
        $nextReservationCommand->AddParameter(new Parameter(ParameterNames::RESOURCE_ID, $missedCheckoutRow[ColumnNames::RESOURCE_ID]));

        $nextReservationReader = ServiceLocator::GetDatabase()->Query($nextReservationCommand);
        if ($nextReservationRow = $nextReservationReader->GetRow()) {
            $newEndDate = Date::FromDatabase($nextReservationRow[ColumnNames::RESERVATION_START]);
        }
        else {
            $newEndDate = $currentEndDate->AddMonths(1);
        }

        $updateEndDateCommand = new AdHocCommand('UPDATE `reservation_instances` SET `end_date` = @endDate WHERE `reservation_instance_id` = @reservationid');
        $updateEndDateCommand->AddParameter(new Parameter(ParameterNames::END_DATE, $newEndDate->ToDatabase()));
        $updateEndDateCommand->AddParameter(new Parameter(ParameterNames::RESERVATION_INSTANCE_ID, $reservationInstanceId));

        ServiceLocator::GetDatabase()->Execute($updateEndDateCommand);

        Log::Debug('Extended reservation end date for id %s from %s to %s', $reservationInstanceId, $currentEndDate, $newEndDate);
    }

    $missedCheckoutReader->Free();
    JobCop::UpdateLastRun(JOB_NAME, true);
} catch (Exception $ex) {
    Log::Error('Error running %s: %s', JOB_NAME, $ex);
    JobCop::UpdateLastRun(JOB_NAME, false);
}

Log::Debug('Finished running %s', JOB_NAME);
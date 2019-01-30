<?php
/**
 * Copyright 2019 Nick Korbel
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

This script must be executed every day for to enable series ending email functionality

0 0 * * * php /home/mydomain/public_html/booked/Jobs/sendseriesend.php
0 0 * * * /path/to/php /home/mydomain/public_html/booked/Jobs/sendseriesend.php

*/

define('ROOT_DIR', dirname(__FILE__) . '/../');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Jobs/JobCop.php');
require_once(ROOT_DIR . 'lib/Email/Messages/ReservationSeriesEndingEmail.php');

Log::Debug('Running sendseriesend.php');

JobCop::EnsureCommandLine();

$emailEnabled = Configuration::Instance()->GetKey(ConfigKeys::ENABLE_EMAIL, new BooleanConverter());
if (!$emailEnabled) {
    return;
}

/**
 * @return AdHocCommand
 */
function BuildQuery()
{
    $now = Date::Now();
    $searchStart = $now->AddDays(7)->ToDatabase();
    $searchEnd = $now->AddDays(8)->ToDatabase();

    $instancesEnding = new AdHocCommand("SELECT
  ri.reference_number, sub.last_date, sub.timezone, sub.language, sub.email
FROM
  reservation_instances ri
INNER JOIN
(
  SELECT
    ri.series_id, MAX(ri.start_date) AS last_date, u.timezone, u.language, u.email
  FROM
   user_email_preferences uep
  INNER JOIN
     reservation_series rs ON rs.owner_id = uep.user_id
  INNER JOIN
    reservation_instances ri ON rs.series_id = ri.series_id
  INNER JOIN
    users u ON rs.owner_id = u.user_id
  WHERE
    repeat_type <> 'none' 
    AND uep.event_category = @event_category 
    AND uep.event_type = @event_type
  GROUP BY
    ri.series_id
) sub ON ri.series_id = sub.series_id and sub.last_date = ri.start_date
WHERE
  sub.last_date BETWEEN @startDate AND @endDate");
    $instancesEnding->AddParameter(new Parameter(ParameterNames::START_DATE, $searchStart));
    $instancesEnding->AddParameter(new Parameter(ParameterNames::END_DATE, $searchEnd));
    $instancesEnding->AddParameter(new Parameter(ParameterNames::EVENT_CATEGORY, EventCategory::Reservation));
    $instancesEnding->AddParameter(new Parameter(ParameterNames::EVENT_TYPE, ReservationEvent::SeriesEnding));
    return $instancesEnding;
}

try {
    $reservationRepository = new ReservationRepository();

    $instancesEnding = BuildQuery();

    $reader = ServiceLocator::GetDatabase()->Query($instancesEnding);
    Log::Debug('Sending %s series ending emails', $reader->NumRows());

    while ($row = $reader->GetRow()) {
        $referenceNumber = $row[ColumnNames::REFERENCE_NUMBER];
        $language = $row[ColumnNames::LANGUAGE_CODE];
        $timezone = $row[ColumnNames::TIMEZONE_NAME];
        $email = $row[ColumnNames::EMAIL];

        $reservation = $reservationRepository->LoadByReferenceNumber($referenceNumber);

        Log::Debug('Sending series ending email. ReferenceNumber=%s, User=%s',
            $referenceNumber, $reservation->UserId());

        ServiceLocator::GetEmailService()->Send(new ReservationSeriesEndingEmail($reservation, $language, $timezone, $email));
    }
    $reader->Free();

} catch (Exception $ex) {
    Log::Error('Error running sendseriesend.php: %s', $ex);
}

Log::Debug('Finished running sendseriesend.php');
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

//////////////////
/* Cron Example //
//////////////////

This script must be executed every minute for to enable missed checkin email functionality

* * * * * php /home/mydomain/public_html/booked/Jobs/sendmissedcheckin.php
* * * * * /path/to/php /home/mydomain/public_html/booked/Jobs/sendmissedcheckin.php

*/

define('ROOT_DIR', dirname(__FILE__) . '/../');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Jobs/JobCop.php');
require_once(ROOT_DIR . 'lib/Email/Messages/MissedCheckinEmail.php');

Log::Debug('Running sendmissedcheckin.php');

JobCop::EnsureCommandLine();

try
{
    $emailEnabled = Configuration::Instance()->GetKey(ConfigKeys::ENABLE_EMAIL, new BooleanConverter());
    if (!$emailEnabled)
    {
        return;
    }

    $alreadySeen = array();

	$reservationViewRepository = new ReservationViewRepository();

    $now = Date::Now();
    $onlyMissedCheckinReservations = new SqlFilterFreeForm(sprintf("%s=1 AND %s IS NULL AND %s BETWEEN '%s' AND '%s'",
        ColumnNames::ENABLE_CHECK_IN, ColumnNames::CHECKIN_DATE, ColumnNames::RESERVATION_START, $now->AddMinutes(-1)->ToDatabase(), $now->ToDatabase()));
	$reservations = $reservationViewRepository->GetList(null, null, null, null, $onlyMissedCheckinReservations)->Results();

	/** @var ReservationItemView $reservation */
	foreach ($reservations as $reservation)
	{
        if (array_key_exists($reservation->ReferenceNumber, $alreadySeen))
        {
            continue;
        }

        $alreadySeen[$reservation->ReferenceNumber] = 1;

        Log::Debug('Sending missed checkin email. ReferenceNumber=%s, User=%s, Resource=%s',
            $reservation->ReferenceNumber, $reservation->UserId, $reservation->ResourceName);

        ServiceLocator::GetEmailService()->Send(new MissedCheckinEmail($reservation));
	}

} catch (Exception $ex)
{
	Log::Error('Error running sendmissedcheckin.php: %s', $ex);
}

Log::Debug('Finished running sendmissedcheckin.php');
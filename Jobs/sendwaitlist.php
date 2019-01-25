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

This script must be executed every minute for to enable waitlist notification emails

* * * * * php /home/mydomain/public_html/booked/Jobs/sendwaitlist.php
* * * * * /path/to/php /home/mydomain/public_html/booked/Jobs/sendwaitlist.php
*/

define('ROOT_DIR', dirname(__FILE__) . '/../');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Jobs/JobCop.php');
require_once(ROOT_DIR . 'lib/Email/Messages/ReservationAvailableEmail.php');

Log::Debug('Running sendwaitlist.php');

JobCop::EnsureCommandLine();

try
{
    $emailEnabled = Configuration::Instance()->GetKey(ConfigKeys::ENABLE_EMAIL, new BooleanConverter());
    if (!$emailEnabled)
    {
        return;
    }

    $reservationViewRepository = new ReservationViewRepository();
	$resourceRepository = new ResourceRepository();
	$waitlistRepository = new ReservationWaitlistRepository();
    $userRepository = new UserRepository();

    $waitlistRequests = $waitlistRepository->GetAll();

    /** @var ReservationWaitlistRequest $r */
    foreach ($waitlistRequests as $r)
    {
        $reservations = $reservationViewRepository->GetReservations($r->StartDate(), $r->EndDate(), null, null, null, $r->ResourceId());

        $conflicts = false;

        /** @var ReservationItemView $reservation */
        foreach ($reservations as $reservation)
        {
            if ($reservation->BufferedTimes()->Overlaps($r->Duration()))
            {
                $conflicts = true;
                break;
            }
        }

        if (!$conflicts || $r->StartDate()->LessThanOrEqual(Date::Now()))
        {
            $user = $userRepository->LoadById($r->UserId());
            $resource = $resourceRepository->LoadById($r->ResourceId());
            $email = new ReservationAvailableEmail($user, $resource, $r);
            ServiceLocator::GetEmailService()->Send($email);
            $waitlistRepository->Delete($r);
        }
    }
} catch (Exception $ex)
{
	Log::Error('Error running sendwaitlist.php: %s', $ex);
}

Log::Debug('Finished running sendwaitlist.php');
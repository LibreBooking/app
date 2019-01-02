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

This script must be executed every minute for to enable automatic release functionality

* * * * * php /home/mydomain/public_html/booked/Jobs/autorelease.php
* * * * * /path/to/php /home/mydomain/public_html/booked/Jobs/autorelease.php

*/

define('ROOT_DIR', dirname(__FILE__) . '/../');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Jobs/JobCop.php');

Log::Debug('Running autorelease.php');

JobCop::EnsureCommandLine();

try
{
	$reservationViewRepository = new ReservationViewRepository();
	$resourceRepository = new ResourceRepository();
	$reservationRepository = new ReservationRepository();

	$onlyAutoReleasedResources = new SqlFilterFreeForm(sprintf("%s IS NOT NULL AND %s <> ''",
															   ColumnNames::AUTO_RELEASE_MINUTES, ColumnNames::AUTO_RELEASE_MINUTES));
	$autoReleasedResources = $resourceRepository->GetList(null, null, null, null, $onlyAutoReleasedResources)->Results();

	$userSession = new UserSession(0);
	$userSession->FirstName = 'Auto release job';
	$userSession->IsAdmin = true;

	/** @var BookableResource $resource */
	foreach ($autoReleasedResources as $resource)
	{
		$autoReleaseMinutes = $resource->GetAutoReleaseMinutes();

		$latestStartDate = Date::Now()->SubtractMinutes($autoReleaseMinutes)->ToDatabase();

		$reservationsThatShouldHaveBeenCheckedIn = new SqlFilterFreeForm(sprintf("%s.%s = %s AND %s IS NULL AND %s.%s < '%s'",
																				 TableNames::RESOURCES, ColumnNames::RESOURCE_ID, $resource->GetId(),
																				 ColumnNames::CHECKIN_DATE,
																				 TableNames::RESERVATION_INSTANCES_ALIAS, ColumnNames::RESERVATION_START, $latestStartDate));
		$reservationItemViews = $reservationViewRepository->GetList(null, null, null, null, $reservationsThatShouldHaveBeenCheckedIn)->Results();

		/** @var ReservationItemView $reservationItemView */
		foreach ($reservationItemViews as $reservationItemView)
		{
			Log::Debug('Automatically releasing reservation. ReferenceNumber=%s, User=%s %s, Resource=%s',
					   $reservationItemView->ReferenceNumber, $reservationItemView->OwnerFirstName, $reservationItemView->OwnerLastName, $reservationItemView->ResourceName);

			$reservation = $reservationRepository->LoadByReferenceNumber($reservationItemView->ReferenceNumber);
			$reservation->ApplyChangesTo(SeriesUpdateScope::ThisInstance);
			$reservation->Delete($userSession);
			$reservationRepository->Delete($reservation);
		}
	}

} catch (Exception $ex)
{
	Log::Error('Error running autorelease.php: %s', $ex);
}

Log::Debug('Finished running autorelease.php');
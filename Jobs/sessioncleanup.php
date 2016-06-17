<?php
/**
 * Copyright 2016 W.J. Roes
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

This script must be executed every day to enable session cleanup functionality

* * * * * php /home/mydomain/public_html/booked/Jobs/sessioncleanup.php
* * * * * /path/to/php /home/mydomain/public_html/booked/Jobs/sessioncleanup.php

*/

define('ROOT_DIR', dirname(__FILE__) . '/../');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Jobs/JobCop.php');

Log::Debug('Running sessioncleanup.php');

JobCop::EnsureCommandLine();

try
{
	$userSessionRepository = new UserSessionRepository();
    $userSessionRepository->CleanUp();
    Log::Debug('Cleaning up stale user sessions');

} catch (Exception $ex)
{
	Log::Error('Error running sessioncleanup.php: %s', $ex);
}

Log::Debug('Finished running sessioncleanup.php');
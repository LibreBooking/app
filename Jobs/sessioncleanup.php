<?php
/**

Cron Example:

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

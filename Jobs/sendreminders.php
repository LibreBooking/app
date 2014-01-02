<?php
/**
Copyright 2013-2014 Stephen Oliver, Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

//////////////////
/* Cron Example //
//////////////////

This script must be executed every minute for to enable Reservation Reminders functionality

* * * * * php /home/mydomain/public_html/booked/Jobs/sendreminders.php
* * * * * /path/to/php /home/mydomain/public_html/booked/Jobs/sendreminders.php

*/

define('ROOT_DIR', dirname(__FILE__) . '/../');
//define('ROOT_DIR', __DIR__ . '/../');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Domain/Reminder.php');
require_once(ROOT_DIR . 'lib/Email/Messages/ReminderEmail.php');
require_once(ROOT_DIR . 'Jobs/JobCop.php');

Log::Debug('Running sendreminders.php');

JobCop::EnsureCommandLine();

try
{
	$repository = new ReminderRepository();
	$now = Date::Now();

	$startNotices = $repository->GetReminderNotices($now, ReservationReminderType::Start);
	Log::Debug('Found %s start reminders', count($startNotices));
	foreach ($startNotices as $notice)
	{
		ServiceLocator::GetEmailService()->Send(new ReminderStartEmail($notice));
	}

	$endNotices = $repository->GetReminderNotices(Date::Now(), ReservationReminderType::End);
	Log::Debug('Found %s end reminders', count($endNotices));
	foreach ($endNotices as $notice)
	{
		ServiceLocator::GetEmailService()->Send(new ReminderEndEmail($notice));
	}
} catch (Exception $ex)
{
	Log::Error('Error running sendreminders.php: %s', $ex);
}

Log::Debug('Finished running sendreminders.php');
?>
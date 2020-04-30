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

@define('ROOT_DIR', dirname(__FILE__) . '/../');
require_once(ROOT_DIR . 'Jobs/JobCop.php');

JobCop::EnsureCommandLine();

$phpExec = Configuration::Instance()->GetSectionKey(ConfigSection::JOBS, ConfigKeys::JOBS_PHP_EXEC_PATH);

if (empty($phpExec)) {
    Log::Debug('No path to PHP set in $conf[\'settings\'][\'jobs\'][\'php.exec.path\']. Defaulting to "php"');
    $phpExec = "php";
}

Log::Debug("Executing all scheduled jobs");

exec("$$phpExec " . ROOT_DIR . 'Jobs/auto-extend.php');
exec("$$phpExec " . ROOT_DIR . 'Jobs/autorelease.php');
exec("$$phpExec " . ROOT_DIR . 'Jobs/replenish-credits.php');
exec("$$phpExec " . ROOT_DIR . 'Jobs/sendmissedcheckin.php');
exec("$$phpExec " . ROOT_DIR . 'Jobs/sendreminders.php');
exec("$$phpExec " . ROOT_DIR . 'Jobs/sendseriesend.php');
exec("$$phpExec " . ROOT_DIR . 'Jobs/sessioncleanup.php');

Log::Debug("Finished executing all scheduled jobs");
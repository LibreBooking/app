<?php
/**
Copyright 2013-2020 Nick Korbel

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

require_once(ROOT_DIR . 'Domain/Access/namespace.php');

class JobCop
{
	public static function EnsureCommandLine()
	{
		try
		{
			if (array_key_exists('REQUEST_METHOD', $_SERVER))
			{
				die('This can only be accessed via the command line');
			}
		}
		catch(Exception $ex){
			Log::Error('Error in JobCop->EnsureCommandLine: %s', $ex);
		}
	}

	public static function EnforceSchedule($jobName, $minInterval) {
        $lastRunCommand = new AdHocCommand('SELECT * FROM `scheduled_job_status` WHERE `job_name` = @job_name');
        $lastRunCommand->AddParameter(new Parameter("@job_name", $jobName));

        $reader = ServiceLocator::GetDatabase()->Query($lastRunCommand);
        if ($row = $reader->GetRow()) {
            $lastRunTime = Date::FromDatabase($row['last_run_date']);

            $minNextRun = $lastRunTime->AddMinutes($minInterval);
            echo "min " . $minNextRun;

            if ($minNextRun->GreaterThan(Date::Now()))
            {
                Log::Debug("Skipping run of %s. Last run %s, minimum next run %s", $jobName, $lastRunTime, $minNextRun);
                die();
            }
        }
    }

    public static function UpdateLastRun($jobName, $success) {
        $updateLastRunCommand = new AdHocCommand('REPLACE INTO `scheduled_job_status` (`job_name`, `last_run_date`, `status`) VALUES (@job_name, @last_run_date, @status)');
        $updateLastRunCommand->AddParameter(new Parameter("@job_name", $jobName));
        $updateLastRunCommand->AddParameter(new Parameter("@last_run_date", Date::Now()->ToDatabase()));
        $updateLastRunCommand->AddParameter(new Parameter("@status", $success ? 1 : 0));

        ServiceLocator::GetDatabase()->Execute($updateLastRunCommand);
    }
}

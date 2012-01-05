<?php
/**
Copyright 2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Page.php');
require_once(ROOT_DIR . 'lib/Database/namespace.php');
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

class MigrationPage extends Page
{
    /**
     * @var MigrationPresenter
     */
    private $presenter;

    public function __construct()
    {
        parent::__construct('Migration', 1);
        $this->presenter = new MigrationPresenter($this);
    }

    public function PageLoad()
    {
        $this->presenter->PageLoad();
    }

    public function IsRunningMigration()
    {
        $buttonValue = $this->GetForm('run');

        return !empty($buttonValue);
    }

    public function DisplayResults()
    {
        $this->Set('ShowResults', true);
        $this->Display('migrate.tpl');
    }

    public function DisplayMigrationPrompt()
    {
        $this->Display('migrate.tpl');
    }

    public function GetLegacyUserName()
    {
        return $this->GetForm('legacyUser');
    }

    public function GetLegacyPassword()
    {
        return $this->GetForm('legacyPassword');
    }

    public function GetLegacyHostSpec()
    {
        return $this->GetForm('legacyHostSpec');
    }

    public function GetLegacyDatabaseName()
    {
        return $this->GetForm('legacyDatabaseName');
    }

    public function SetLegacyConnectionSucceeded($wasSuccessful)
    {
        $this->Set('LegacyConnectionSucceeded', $wasSuccessful);
    }

    public function SetSchedulesMigrated($schedulesMigrated)
    {
        $this->Set('SchedulesMigratedCount', $schedulesMigrated);
    }
}

class MigrationPresenter
{
    /**
     * @var MigrationPage
     */
    private $page;

    public function __construct(MigrationPage $page)
    {
        $this->page = $page;
    }

    public function PageLoad()
    {
        if ($this->page->IsRunningMigration())
        {
            if ($this->TestLegacyConnection())
            {
                $this->Migrate();
                $this->page->DisplayResults();
            }
            else
            {
                $this->page->DisplayMigrationPrompt();
            }
        }
        else
        {
            $this->page->DisplayMigrationPrompt();
        }
    }

    private function Migrate()
    {
        $legacyDatabase = new Database($this->GetLegacyConnection());
        $currentDatabase = ServiceLocator::GetDatabase();

        $this->MigrateSchedules($legacyDatabase, $currentDatabase);
    }

    /**
     * @return MySqlConnection
     */
    private function GetLegacyConnection()
    {
        $legacyUserName = $this->page->GetLegacyUserName();
        $legacyPassword = $this->page->GetLegacyPassword();
        $legacyHostSpec = $this->page->GetLegacyHostSpec();
        $legacyDatabaseName = $this->page->GetLegacyDatabaseName();

        return new MySqlConnection($legacyUserName, $legacyPassword, $legacyHostSpec, $legacyDatabaseName);

    }

    private function TestLegacyConnection()
    {
        $legacyConnection = $this->GetLegacyConnection();
        try
        {
            $legacyConnection->Connect();
            $legacyConnection->Disconnect();
            $this->page->SetLegacyConnectionSucceeded(true);
            return true;
        }
        catch (Exception $ex)
        {
            $this->page->SetLegacyConnectionSucceeded(false);
            return false;
        }
    }

    private function MigrateSchedules(Database $legacyDatabase, Database $currentDatabase)
    {
        $schedulesMigrated = 0;
        $scheduleRepo = new ScheduleRepository();

        $getSchedules = new AdHocCommand('select scheduleid, scheduletitle, daystart, dayend, timespan,
                timeformat, weekdaystart, viewdays, usepermissions, ishidden, showsummary, adminemail, isdefault
                from schedules');

        $reader = $legacyDatabase->Query($getSchedules);

        while ($row = $reader->GetRow())
        {
            $newId = $scheduleRepo->Add(new Schedule(null, $row['scheduletitle'], false, $row['weekdaystart'], $row['viewdays']), 1);

            $currentDatabase->Execute(new AdHocCommand("update schedules set legacyid = \"{$row['scheduleid']}\" where schedule_id = $newId"));
            $timezone = Configuration::Instance()->GetKey(ConfigKeys::SERVER_TIMEZONE);

            $available = $this->CreateAvailableTimeSlots($row['daystart'], $row['dayend'], $row['timespan']);
            $unavailable = $this->CreateUnavailableTimeSlots($row['daystart'], $row['dayend'], $row['timespan']);
            $layout = ScheduleLayout::Parse($timezone, $available, $unavailable);

            $scheduleRepo->AddScheduleLayout($newId, $layout);

            $schedulesMigrated++;
        }

        $this->page->SetSchedulesMigrated($schedulesMigrated);
    }

    private function CreateAvailableTimeSlots($start, $end, $interval)
    {
        $times = '';
        for ($time = $start; $time < $end; $time += $interval)
        {
            $startTime = $time;

            $startHour = intval($startTime / 60);
            $startMin = $startTime % 60;

            $endTime = $time + $interval;
            $endHour = intval($endTime / 60);
            $endMin = $endTime % 60;

            $times .= "$startHour:$startMin - $endHour:$endMin\n";
        }

        return $times;
    }

    private function CreateUnavailableTimeSlots($start, $end, $interval)
    {
        $times = '';
        for ($time = 0; $time < $start; $time += $interval)
        {
            $startTime = $time;

            $startHour = intval($startTime / 60);
            $startMin = $startTime % 60;

            $endTime = $time + $interval;
            $endHour = intval($endTime / 60);
            $endMin = $endTime % 60;

            $times .= "$startHour:$startMin - $endHour:$endMin\n";
        }

        for ($time = $end; $time < 1440; $time += $interval)
        {
            $startTime = $time;

            $startHour = intval($startTime / 60);
            $startMin = $startTime % 60;

            $endTime = $time + $interval;
            $endHour = intval($endTime / 60);
            $endMin = $endTime % 60;

            $times .= "$startHour:$startMin - $endHour:$endMin\n";
        }

        return $times;
    }
}

$page = new MigrationPage();
$page->PageLoad();

// migrate resources
// select machid, scheduleid, name, location, rphone, notes, status, minres, maxres, autoassign, approval,
//    allow_multi, max_participants, min_notice_time, max_notice_time

// insert resource_id, name, location, contact_info, description, notes, isactive, min_duration, min_increment,
//        max_duration, unit_cost, autoassign, requires_approval, allow_multiday_reservations, max_participants
//        min_notice_time, max_notice_time, image_nam, 	schedule_id, legacyid


// migrate accessories

// migrate groups

// migrate users

// migrate reservations

// migrate permissions

?>
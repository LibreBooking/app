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
        parent::__construct('', 1);
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
        $this->Display('Install/migrate.tpl');
    }

    public function DisplayMigrationPrompt()
    {
        $this->Display('Install/migrate.tpl');
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
        $this->Set('LegacyConnectionFailed', !$wasSuccessful);
    }

    public function SetSchedulesMigrated($schedulesMigrated)
    {
        $this->Set('SchedulesMigratedCount', $schedulesMigrated);
    }

    public function SetResourcesMigrated($resourcesMigrated)
    {
        $this->Set('ResourcesMigratedCount', $resourcesMigrated);
    }

    public function SetAccessoriesMigrated($accessoriesMigrated)
    {
        $this->Set('AccessoriesMigratedCount', $accessoriesMigrated);
    }

    public function SetGroupsMigrated($groupsMigrated)
    {
        $this->Set('GroupsMigratedCount', $groupsMigrated);
    }

    public function SetUsersMigrated($usersMigrated)
    {
        $this->Set('UsersMigratedCount', $usersMigrated);
    }

    public function SetReservationsMigrated($reservationsMigrated)
    {
        $this->Set('ReservationsMigratedCount', $reservationsMigrated);
    }

    public function GetInstallPassword()
    {
        return $this->GetForm('installPassword');
    }

    public function SetInstallPasswordSucceeded($passwordValid)
    {
        $this->Set('InstallPasswordFailed', !$passwordValid);
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
            if ($this->TestInstallPassword() && $this->TestLegacyConnection())
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
        $this->MigrateResources($legacyDatabase, $currentDatabase);
        $this->MigrateAccessories($legacyDatabase, $currentDatabase);
        $this->MigrateGroups($legacyDatabase, $currentDatabase);
        $this->MigrateUsers($legacyDatabase, $currentDatabase);
        $this->MigrateReservations($legacyDatabase, $currentDatabase);
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

    /**
     * @return bool
     */
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

    /**
     * @return bool
     */
    private function TestInstallPassword()
    {
        $password = Configuration::Instance()->GetKey(ConfigKeys::INSTALLATION_PASSWORD);

        if (empty($password) || $password != $this->page->GetInstallPassword())
        {
            $this->page->SetInstallPasswordSucceeded(false);
            return false;
        }
        $this->page->SetInstallPasswordSucceeded(true);
        return true;
    }

    private function MigrateSchedules(Database $legacyDatabase, Database $currentDatabase)
    {
		Log::Debug('Start migrating schedules');

        $schedulesMigrated = 0;
        $scheduleRepo = new ScheduleRepository();

        $getLegacySchedules = new AdHocCommand('select scheduleid, scheduletitle, daystart, dayend, timespan,
                timeformat, weekdaystart, viewdays, usepermissions, ishidden, showsummary, adminemail, isdefault
                from schedules');


        $getExistingSchedules = new AdHocCommand('select legacyid from schedules');
        $reader = $currentDatabase->Query($getExistingSchedules);

        $knownIds = array();
        while ($row = $reader->GetRow())
        {
            $knownIds[] = $row['legacyid'];
        }

        $reader = $legacyDatabase->Query($getLegacySchedules);

        while ($row = $reader->GetRow())
        {
            if (in_array($row['scheduleid'], $knownIds))
            {
                continue;
            }

            $newId = $scheduleRepo->Add(new Schedule(null, $row['scheduletitle'], false, $row['weekdaystart'], $row['viewdays']), 1);

            $currentDatabase->Execute(new AdHocCommand("update schedules set legacyid = \"{$row['scheduleid']}\" where schedule_id = $newId"));
            $timezone = Configuration::Instance()->GetKey(ConfigKeys::SERVER_TIMEZONE);

            $available = $this->CreateAvailableTimeSlots($row['daystart'], $row['dayend'], $row['timespan']);
            $unavailable = $this->CreateUnavailableTimeSlots($row['daystart'], $row['dayend'], $row['timespan']);
            $layout = ScheduleLayout::Parse($timezone, $available, $unavailable);

            $scheduleRepo->AddScheduleLayout($newId, $layout);

            $schedulesMigrated++;
        }

		Log::Debug('Done migrating schedules (%s schedules)', $schedulesMigrated);

        $this->page->SetSchedulesMigrated($schedulesMigrated);
    }

    private function MigrateResources(Database $legacyDatabase, Database $currentDatabase)
    {
		Log::Debug('Start migrating resources');

        $resourcesMigrated = 0;
        $resourceRepo = new ResourceRepository();

        $getExisting = new AdHocCommand('select legacyid from resources');
        $reader = $currentDatabase->Query($getExisting);

        $knownIds = array();
        while ($row = $reader->GetRow())
        {
            $knownIds[] = $row['legacyid'];
        }

        $getResources = new AdHocCommand('select machid, scheduleid, name, location, rphone, notes, status, minres, maxres, autoassign, approval,
                        allow_multi, max_participants, min_notice_time, max_notice_time
                        from resources');

        $reader = $legacyDatabase->Query($getResources);

        while ($row = $reader->GetRow())
        {
            if (in_array($row['machid'], $knownIds))
            {
                continue;
            }

            $newScheduleReader = $currentDatabase->Query(new AdHocCommand("select schedule_id from schedules where legacyId = \"{$row['scheduleid']}\""));

            if ($srow = $newScheduleReader->GetRow())
            {
                $newScheduleId = $srow['schedule_id'];
            }

            $minTimeSeconds = $row['minres'] * 60;
            $maxTimeSeconds = $row['maxres'] * 60;
            $min_notice_time = $row['min_notice_time'] * 60;
            $max_notice_time = $row['max_notice_time'] * 60;

            $newId = $resourceRepo->Add(
                new BookableResource(null,
                    $row['name'],
                    $row['location'],
                    $row['rphone'],
                    $row['notes'],
                    $minTimeSeconds,
                    $maxTimeSeconds,
                    $row['autoassign'],
                    $row['approval'],
                    $row['allow_multi'],
                    $row['max_participants'],
                    $min_notice_time,
                    $max_notice_time, null, $newScheduleId));

            $currentDatabase->Execute(new AdHocCommand("update resources set legacyid = \"{$row['machid']}\" where resource_id = $newId"));

            $resourcesMigrated++;
        }

		Log::Debug('Done migrating resources (%s resources)', $resourcesMigrated);

        $this->page->SetResourcesMigrated($resourcesMigrated);
    }

    private function MigrateAccessories(Database $legacyDatabase, Database $currentDatabase)
    {
		Log::Debug('Start migrating accessories');

        $accessoriesMigrated = 0;
        $accessoryRepo = new AccessoryRepository();

        $getExisting = new AdHocCommand('select legacyid from accessories');
        $reader = $currentDatabase->Query($getExisting);

        $knownIds = array();
        while ($row = $reader->GetRow())
        {
            $knownIds[] = $row['legacyid'];
        }

        $getAccessories = new AdHocCommand('select resourceid, name, number_available from additional_resources');

        $reader = $legacyDatabase->Query($getAccessories);

        while ($row = $reader->GetRow())
        {
            if (in_array($row['resourceid'], $knownIds))
            {
                continue;
            }
            $newId = $accessoryRepo->Add(new Accessory(null, $row['name'], $row['number_available']));

            $currentDatabase->Execute(new AdHocCommand("update accessories set legacyid = \"{$row['resourceid']}\" where accessory_id = $newId"));

            $accessoriesMigrated++;
        }

		Log::Debug('Done migrating accessories (%s accessories)', $accessoriesMigrated);
        $this->page->SetAccessoriesMigrated($accessoriesMigrated);
    }

    private function MigrateGroups(Database $legacyDatabase, Database $currentDatabase)
    {
		Log::Debug('Start migrating groups');

        $groupsMigrated = 0;
        $groupRepo = new GroupRepository();

        $getExisting = new AdHocCommand('select legacyid from groups');
        $reader = $currentDatabase->Query($getExisting);

        $knownIds = array();
        while ($row = $reader->GetRow())
        {
            $knownIds[] = $row['legacyid'];
        }

        $getGroups = new AdHocCommand('select groupid, group_name  from groups');

        $reader = $legacyDatabase->Query($getGroups);

        while ($row = $reader->GetRow())
        {
            if (in_array($row['groupid'], $knownIds))
            {
                continue;
            }

            $newId = $groupRepo->Add(new Group(null, $row['group_name']));

            $currentDatabase->Execute(new AdHocCommand("update groups set legacyid = \"{$row['groupid']}\" where group_id = $newId"));

            $groupsMigrated++;
        }

		Log::Debug('Done migrating groups (%s groups)', $groupsMigrated);

        $this->page->SetGroupsMigrated($groupsMigrated);
    }

    private function MigrateUsers(Database $legacyDatabase, Database $currentDatabase)
    {
		Log::Debug('Start migrating users');

        $usersMigrated = 0;
        $userRepo = new UserRepository();

        $getExisting = new AdHocCommand('select legacyid from users');
        $reader = $currentDatabase->Query($getExisting);

        $knownIds = array();
        while ($row = $reader->GetRow())
        {
            $knownIds[] = $row['legacyid'];
        }

        $getGroups = new AdHocCommand('select groupid, memberid from user_groups');
        $reader = $legacyDatabase->Query($getGroups);

        $userGroups = array();
        while ($row = $reader->GetRow())
        {
            $memberId = $row['memberid'];
            if (!array_key_exists($memberId, $userGroups))
            {
                $userGroups[$memberId] = array();
            }
            $userGroups[$memberId][] = $row['groupid'];
        }

        $getGroupMapping = new AdHocCommand('select group_id, legacyid from groups');
        $reader = $currentDatabase->Query($getGroupMapping);

        $groupMap = array();
        while ($row = $reader->GetRow())
        {
            $groupMap[$row['legacyid']] = $row['group_id'];
        }

        $getUsers = new AdHocCommand('select memberid, email, password, fname, lname, phone, institution, position, e_add, e_mod, e_del, e_app, e_html, logon_name, is_admin, lang, timezone from login');
        $reader = $legacyDatabase->Query($getUsers);

        while ($row = $reader->GetRow())
        {
            $legacyId = $row['memberid'];
            if (in_array($legacyId, $knownIds))
            {
                continue;
            }

            $registerCommand = new RegisterUserCommand(
                $row['logon_name'],
                $row['email'],
                $row['fname'],
                $row['lname'],
                $row['password'],
                '',
                Configuration::Instance()->GetKey(ConfigKeys::SERVER_TIMEZONE),
                $row['lang'],
                Pages::DEFAULT_HOMEPAGE_ID,
                $row['phone'],
                $row['institution'],
                $row['position'],
                AccountStatus::ACTIVE);

            $newId = ServiceLocator::GetDatabase()->ExecuteInsert($registerCommand);

            $currentDatabase->Execute(new AdHocCommand("update users set legacyid = \"$legacyId\" where user_id = $newId"));

            // migrate group assignments
            if (array_key_exists($legacyId, $userGroups))
            {
                foreach ($userGroups[$legacyId] as $legacyGroupId)
                {
                    $newGroupId = $groupMap[$legacyGroupId];
                    $currentDatabase->ExecuteInsert(new AddUserGroupCommand($newId, $newGroupId));
                }
            }
            $usersMigrated++;
        }

		Log::Debug('Done migrating users (%s users)', $usersMigrated);

        $this->page->SetUsersMigrated($usersMigrated);
    }

    private function MigrateReservations(Database $legacyDatabase, Database $currentDatabase)
    {
		Log::Debug('Start migrating reservations');

        $reservationsMigrated = 0;
        $reservationRepository = new ReservationRepository();
        $blackoutRepository = new BlackoutRepository();

        $getLegacyReservations = new AdHocCommand('select r.resid, machid, scheduleid, start_date, end_date,
            starttime, endtime, created, modified, parentid, is_blackout, is_pending, summary, allow_participation, allow_anon_participation,
            ru.memberid
            FROM reservations r INNER JOIN reservation_users ru ON r.resid = ru.resid AND owner = 1');

        $getLegacyReservationAccessories = new AdHocCommand('SELECT resid, resourceid from reservation_resources');
        $getLegacyReservationParticipants = new AdHocCommand('SELECT resid, memberid, owner, invited  FROM reservation_users WHERE invited is null and owner is null');

        $getAccessoryMapping = new AdHocCommand('select accessory_id, legacyid from accessories');
        $getUserMapping = new AdHocCommand('select user_id, legacyid from users');
        $getResourceMapping = new AdHocCommand('select resource_id, legacyid from resources');

        $accessoryMapping = array();
        $accessoryMappingReader = $currentDatabase->Query($getAccessoryMapping);
        while ($row = $accessoryMappingReader->GetRow())
        {
            $legacyId = $row['legacyid'];
            $accessoryMapping[$legacyId] = $row['accessory_id'];
        }

        $userMapping = array();
        $userMappingReader = $currentDatabase->Query($getUserMapping);
        while ($row = $userMappingReader->GetRow())
        {
            $legacyId = $row['legacyid'];
            $userMapping[$legacyId] = $row['user_id'];
        }

        $resourceMapping = array();
        $resourceMappingReader = $currentDatabase->Query($getResourceMapping);
        while ($row = $resourceMappingReader->GetRow())
        {
            $legacyId = $row['legacyid'];
            $resourceMapping[$legacyId] = $row['resource_id'];
        }

        $reservationAccessories = array();
        $legacyAccessoryReader = $legacyDatabase->Query($getLegacyReservationAccessories);
        while ($row = $legacyAccessoryReader->GetRow())
        {
            $resId = $row['resid'];
            if (!array_key_exists($resId, $reservationAccessories))
            {
                $reservationAccessories[$resId] = array();
            }
            $reservationAccessories[$resId][] = $row['resourceid'];
        }

        $reservationParticipants = array();
        $legacyParticipantReader = $legacyDatabase->Query($getLegacyReservationParticipants);
        while ($row = $legacyParticipantReader->GetRow())
        {
            $resId = $row['resid'];
            if (!array_key_exists($resId, $reservationParticipants))
            {
                $reservationParticipants[$resId] = array();
            }
            $reservationParticipants[$resId][] = $row['memberid'];
        }

        $legacyReservationReader = $legacyDatabase->Query($getLegacyReservations);
        while ($row = $legacyReservationReader->GetRow())
        {
            $reservationsMigrated++;

            $date = $this->BuildDateRange($row['start_date'], $row['starttime'], $row['end_date'], $row['endtime']);

            $mappedUserId = $userMapping[$row['memberid']];
            $mappedResourceId = $resourceMapping[$row['machid']];

            $legacyId = $row['resid'];

            if ($row['is_blackout'] == 1)
            {
                // handle blackout
                $blackout = Blackout::Create($mappedUserId, $mappedResourceId, '', $date);

                $newId = $blackoutRepository->Add($blackout);
                $currentDatabase->Execute(new AdHocCommand("update blackout_series set legacyid = \"$legacyId\" where blackout_series_id = $newId"));
            }
            else
            {
                // handle reservation

                $mappedParticipantIds = array();
                if (array_key_exists($legacyId, $reservationParticipants))
                {
                    $legacyParticipants = $reservationParticipants[$legacyId];
                    foreach ($legacyParticipants as $legacyParticipantId)
                    {
                        $mappedParticipantIds[] = $mappedParticipantIds[$legacyParticipantId];
                    }
                }

                $mappedAccessoryList = array();
                if (array_key_exists($legacyId, $reservationAccessories))
                {
                    $legacyAccessories = $reservationAccessories[$legacyId];
                    foreach ($legacyAccessories as $legacyAccessoryId)
                    {
                        $mappedAccessoryId = $accessoryMapping[$legacyAccessoryId];
                        $mappedAccessoryList[] = new ReservationAccessory($mappedAccessoryId, 1);
                    }
                }


                $currentUser = new UserSession($row['memberid']);
                $mappedResource = new MigrateBookableResource($mappedResourceId);

                $reservation = ReservationSeries::Create($mappedUserId, $mappedResource, '', $row['summary'], $date, new RepeatNone(), $currentUser);
                foreach ($mappedAccessoryList as $accessory)
                {
                    $reservation->AddAccessory($accessory);
                }

                $reservation->ChangeParticipants($mappedParticipantIds);

                $reservationRepository->Add($reservation);

                $newId = $reservation->SeriesId();
                $currentDatabase->Execute(new AdHocCommand("update reservation_series set legacyid = \"$legacyId\" where series_id = $newId"));
            }
        }

		Log::Debug('Done migrating reservations (%s reservations)', $reservationsMigrated);

        $this->page->SetReservationsMigrated($reservationsMigrated);
    }

    private function CreateAvailableTimeSlots($start, $end, $interval)
    {
        $times = '';
        for ($time = $start; $time < $end; $time += $interval)
        {
            $startTime = $time;
            $startString = $this->MinutesToTime($startTime);

            $endTime = $time + $interval;
            $endString = $this->MinutesToTime($endTime);

            $times .= "$startString - $endString\n";
        }

        return $times;
    }

    private function CreateUnavailableTimeSlots($start, $end, $interval)
    {
        $times = '';
        for ($time = 0; $time < $start; $time += $interval)
        {
            $startTime = $time;
            $startString = $this->MinutesToTime($startTime);

            $endTime = $time + $interval;
            $endString = $this->MinutesToTime($endTime);

            $times .= "$startString - $endString\n";
        }

        for ($time = $end; $time < 1440; $time += $interval)
        {
            $startTime = $time;
            $startString = $this->MinutesToTime($startTime);

            $endTime = $time + $interval;
            $endString = $this->MinutesToTime($endTime);

            $times .= "$startString - $endString\n";
        }

        return $times;
    }

    private function MinutesToTime($minutes)
    {
        $hour = intval($minutes / 60);
        $min = $minutes % 60;

        $hour = $hour % 24;

        return "$hour:$min";
    }

    private function BuildDateRange($startDate, $startTime, $endDate, $endTime)
    {
        $s = date('Y-m-d', $startDate) . ' ' . $this->MinutesToTime($startTime);
        $e = date('Y-m-d', $endDate) . ' ' . $this->MinutesToTime($endTime);

        return DateRange::Create($s, $e, Configuration::Instance()->GetKey(ConfigKeys::SERVER_TIMEZONE));
    }
}

class MigrateBookableResource extends BookableResource
{
    public function __construct($resourceId)
    {
        $this->_resourceId = $resourceId;
    }
}

$page = new MigrationPage();
$page->PageLoad();



?>
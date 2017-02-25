<?php
/**
Copyright 2011-2017 Nick Korbel

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

$path = ini_get('include_path');
ini_set('include_path', $path . ';' . 'C:\PHP\PEAR');

define('ROOT_DIR', dirname(__FILE__) . '/../');

//echo dirname(__FILE__);

//require_once 'PHPUnit/TextUI/TestRunner.php';
require_once 'PHPUnit/Autoload.php';
require_once ROOT_DIR . 'lib/Timer.class.php';
require_once ROOT_DIR . 'tests/data/namespace.php';
require_once ROOT_DIR . 'tests/fakes/namespace.php';
require_once ROOT_DIR . 'tests/TestBase.php';

$tests = array(
'Domain/Reservation/ReservationViewRepositoryTests.php',
'Domain/Reservation/AdminEmailNotificationTests.php',
'Domain/Reservation/OwnerEmailNotificationTests.php',
'Domain/Reservation/ReservationDateTimeRuleTests.php',
'Domain/PermissionValidationRuleTests.php',
'Domain/ResourceAvailabilityRuleTests.php',
'Domain/AddReservationValidationServiceTests.php',
'PresenterTests/EditReservationPresenterTests.php',
'PresenterTests/ReservationSavePresenterTests.php',
'Domain/RepeatOptionsTests.php',
'Domain/ReservationTests.php',
'Domain/UserRepositoryTests.php',
'Domain/ReservationRepositoryTests.php',
'PresenterTests/NewReservationPresenterTests.php',
'PresenterTests/ReservationInitializationTests.php',
'PresenterTests/NewReservationPreconditionServiceTests.php',
'ScheduleUserRepositoryTests.php',
'ResourcePermissionStoreTests.php',
'PermissionServiceTests.php',
'DateTests.php',
'ReservationListingTests.php',
'ScheduleLayoutTests.php',
'DailyLayoutTests.php',
'SchedulePresenterTests.php',
'ReservationServiceTests.php',
'ScheduleReservationListTests.php',
'ResourceRepositoryTestsitoryTests.php',
'SchedulesTests.php',
'AnnouncementRepositoryTeststoryTests.php',
'AnnouncementPresenterTests.php',
//'DashboardPresenterTests.php',
'PluginManagerTests.php',
'ConfigTests.php',
'ActiveDirectoryTests.php',
'RegisterPresenterTests.php',
'ValidatorTests.php',
'PasswordMigrationTests.php',
'ResourcesTests.php',
'LoginPresenterTests.php',
'DatabaseTests.php',
'DatabaseCommandTests.php',
'AuthorizationTests.php',
//'Mdb2CommandAdapterTests.php',
//'Mdb2ConnectionTests.php',
//'Mdb2ReaderTests.php',
'PasswordEncryptionTests.php',
'RegistrationTests.php',
'SmartyControlTests.php'
);

/*
$tests = array(
'SchedulePresenterTests.php',
'ResourceRepositoryTests.phpyTests.php',
'DateTests.php',
'ScheduleReservationListTests.php');
*/

$passed = true;
$totalRun = 0;
$totalPassed = 0;
$totalFailed = 0;
$totalTimer = new StopWatch();
$totalTimer->Start();

$suite = new PHPUnit_Framework_TestSuite('PHPUnit Framework');

for ($i = 0; $i < count($tests); $i++)
{
	require_once($tests[$i]);
	$fileWithDir = explode('/', $tests[$i]);
	$fileName = $tests[$i];

	if (count($fileWithDir) > 1)
	{
		$fileName = $fileWithDir[count($fileWithDir)-1];
	}

	$name_parts = explode('.', $fileName);
	$name  = $name_parts[0];
	//$suite->addTestFile($tests[$i]);
	$suite->addTestSuite($name);
}

PHPUnit_TextUI_TestRunner::run($suite);

$totalTimer->Stop();




?>
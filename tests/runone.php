<?php
$path = ini_get('include_path');
ini_set('include_path', $path . ';' . 'C:\PHP\PEAR');

define('ROOT_DIR', dirname(__FILE__) . '/../');

//echo dirname(__FILE__);

require_once 'PHPUnit/TextUI/TestRunner.php';
require_once 'PHPUnit/Framework.php';
require_once ROOT_DIR . 'lib/Timer.class.php';
require_once ROOT_DIR . 'tests/data/namespace.php';
require_once ROOT_DIR . 'tests/fakes/namespace.php';
require_once ROOT_DIR . 'tests/TestBase.php';

$tests = array(
'ScheduleReservationListTests.php',
'DateTests.php',
'ResourceTests.php',
'ReservationsTests.php',
'SchedulesTests.php',
'SchedulePresenterTests.php',
'AnnouncementsTests.php',
'AnnouncementPresenterTests.php',
//'DashboardPresenterTests.php',
'PluginManagerTests.php',
'ConfigTests.php',
'LdapTests.php',
'RegisterPresenterTests.php',
'ValidatorTests.php',
'PasswordMigrationTests.php',
'ResourcesTests.php', 
'LoginPresenterTests.php', 
'DatabaseTests.php', 
'DatabaseCommandTests.php', 
'AuthorizationTests.php', 
'Mdb2CommandAdapterTests.php', 
'Mdb2ConnectionTests.php', 
'Mdb2ReaderTests.php', 
'PasswordEncryptionTests.php',
'RegistrationTests.php',
'SmartyControlTests.php'
);

$passed = true;
$totalRun = 0;
$totalPassed = 0;
$totalFailed = 0;
$totalTimer = new Timer();
$totalTimer->start();

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
		
$totalTimer->stop();

?>
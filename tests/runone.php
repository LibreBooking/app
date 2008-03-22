<?php
$path = ini_get('include_path');
ini_set('include_path', $path . ';' . 'C:\PHP\PEAR');

$root = '../';

require_once 'PHPUnit/TextUI/TestRunner.php';
require_once 'PHPUnit/Framework.php';
require_once $root . 'lib/Timer.class.php';
require_once $root . 'tests/fakes/namespace.php';
require_once $root . 'tests/TestBase.php';

//$tests = array('DatabaseCommandTests.php', 'ConfigTests.php', 'DatabaseTests.php', 'EmailTests.php', 'Mdb2CommandAdapterTests.php', 'Mdb2ConnectionTests.php', 'Mdb2ReaderTests.php');

$tests = array(
'LdapTests.php',
'RegisterPresenterTests.php',
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
'DateTests.php',
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

for ($i = 0; $i < count($tests); $i++) {
	require_once($tests[$i]);
	$name_parts = explode('.', $tests[$i]);	
	$name  = $name_parts[0];
	$suite->addTestSuite($name);
}

PHPUnit_TextUI_TestRunner::run($suite);
		
$totalTimer->stop();

?>
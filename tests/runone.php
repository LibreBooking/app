<?php
$path = ini_get('include_path');
ini_set('include_path', $path . ';' . 'C:\PHP\PEAR');

require_once('../lib/Timer.class.php');
require_once 'PHPUnit/Framework.php';
require_once 'PHPUnit/TextUI/TestRunner.php';
require_once 'PHPUnit/Framework.php';


$tests = array('DatabaseCommandTests.php', 'ConfigTests.php', 'DatabaseTests.php', 'EmailTests.php', 'Mdb2CommandAdapterTests.php', 'Mdb2ConnectionTests.php', 'Mdb2ReaderTests.php');

$tests = array('DatabaseCommandTests.php', 'AuthorizationTests.php');
$tests = array('ResourcesTests.php', 'LoginPresenterTests.php');

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
		
/*		
	require_once($tests[$i]);
	
	$name_parts = explode('.', $tests[$i]);
	
	$t = new Timer();
	$t->start();
	
	$suite  = new PHPUnit_Framework_TestSuite($name_parts[0]);
	$result = PHPUnit::run($suite);
	
	$t->stop();
	
	echo "\n--- {$name_parts[0]} Output ---\n" . $result->toString();
	
	printf("\n--- Results ---\nTests Run: %s, Passed: %s, Failed: %s, %s seconds\n\n", $suite->testCount(), count($result->passedTests()), $result->failureCount(), $t->get_timer_value());

	if ($result->failureCount() > 0) {
		$passed = false;
	}
	
	$totalRun += intval($suite->testCount());
	$totalPassed += count($result->passedTests());
	$totalFailed += intval($result->failureCount());
	
	if($result->failureCount() > 0)
	{
		break;
	}

}
*/
$totalTimer->stop();

//printf("\n--- Test Suite Results ---\nTests Run: %s, Passed: %s, Failed: %s, %s seconds\n\n", $totalRun, $totalPassed, $totalFailed, $totalTimer->get_timer_value());

/*
function GetTests() {
	$tests = array();
	
	$dir = dirname(__FILE__);
	
	if (is_dir($dir)) {
	   if ($dh = opendir($dir)) {
		   while (($file = readdir($dh)) !== false) {
			   if (is_file($file)) {		 	 	
					if (strpos($file, 'Test') !== false) {
						$tests[] = $file;
					}
				}
			}
		}
	}
	
	return $tests;
}
*/
?>
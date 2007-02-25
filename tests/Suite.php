<?php
require_once('PHPUnit/Framework.php');
require_once('../lib/Timer.class.php');

$failed = 0;
$run = 0;
$passed = 0;

$verbose = true;

writeln("\n---------- STARTING TESTS ----------");

$passed = true;

$tests = GetTests();

for ($i = 0; $i < count($tests); $i++) {
	printf("\nIncluding file... %s\n", $tests[$i]);
	require_once($tests[$i]);
	
	$name_parts = explode('.', $tests[$i]);
	
	$t = new Timer();
	$t->start();
	
	$suite  = new PHPUnit_TestSuite($name_parts[0]);
	$result = PHPUnit::run($suite);
	
	$t->stop();
	
	echo "\n--- {$name_parts[0]} Output ---\n" . $result->toString();
	
	printf("\n--- Results ---\nTests Run: %s, Passed: %s, Failed: %s, %s seconds\n\n", $suite->testCount(), count($result->passedTests()), $result->failureCount(), $t->get_timer_value());

	if ($result->failureCount() > 0) {
		$passed = false;
		die();
	}
}

if ($passed) {
	echo "\n PASSED \n";
}
else {
	echo "\n FAILED \n";
}

function GetTests() {
	$tests = array();
	
	$dir = dirname(__FILE__);
	
	if (is_dir($dir)) {
	   if ($dh = opendir($dir)) {
		   while (($file = readdir($dh)) !== false) {
			   if (is_file($file)) {		 	 	
					if (strpos($file, 'Test') !== false && strpos($file, '_') === false) {
						$tests[] = $file;
					}
				}
			}
		}
	}
	
	return $tests;
}

function writeln($line) {
	global $verbose;
	if ($verbose) {
		echo $line . "\n";
	}
}

?>
<?php
include_once('PHPUnit.php');
include_once('../lib/Timer.class.php');

$tests = array('ConfigTests.php');

for ($i = 0; $i < count($tests); $i++) {
	include_once($tests[$i]);
	
	$name_parts = explode('.', $tests[$i]);
	
	
	$t = new Timer();
	$t->start();
	
	$suite  = new PHPUnit_TestSuite($name_parts[0]);
	$result = PHPUnit::run($suite);
	
	$t->stop();
	
	echo "\n--- {$name_parts[0]} Output ---\n" . $result->toString();
	
	printf("\n--- Results ---\nTests Run: %s, Passed: %s, Failed: %s, %s seconds\n\n", $suite->testCount(), count($result->passedTests()), $result->failureCount(), $t->get_timer_value());
}
?>
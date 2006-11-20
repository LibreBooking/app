<?php
/// TestSuite ///

require_once('PHPUnit.php');

$failed = 0;
$run = 0;
$passed = 0;

$verbose = true;

writeln("\n---------- STARTING TESTS ----------");
$dir = dirname(__FILE__);

if (is_dir($dir)) {
   if ($dh = opendir($dir)) {
       while (($file = readdir($dh)) !== false) {
           //echo $file . "\n";
		   if (is_file($file)) {		 	 	
				if (strpos($file, 'Test') !== false) {
					@include_once($file);
					$suite_name = explode('.', $file);
					$name = $suite_name[0];
					
					writeln("\n>>> STARTING [$name] >>>");
					
					$suite  = new PHPUnit_TestSuite($name);
					$result = PHPUnit::run($suite);
					
					$failed += $result->failureCount();
					$passed += sizeof($result->passedTests());
					$run += $suite->testCount();
					
					writeln("\n" . $result->toString());
					
					writeln("\n<<< FINISHED [$name] <<<");
				}
		   }
       }
       closedir($dh);
   }
}
writeln("\n---------- FINISNED TESTS ----------");

echo "Tests Complete:\t\t$run Total\t\t$passed Passed\t\t$failed Failed\n";

if ($failed > 0) {
	//exit(-1);
}

function writeln($line) {
	global $verbose;
	if ($verbose) {
		echo $line . "\n";
	}
}

?>
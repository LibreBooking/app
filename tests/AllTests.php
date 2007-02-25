<?php

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'AllTests::main');
}
 
require_once 'PHPUnit/Framework.php';
require_once 'PHPUnit/TextUI/TestRunner.php';
 
class AllTests
{
    public static function main()
    {
		PHPUnit_TextUI_TestRunner::run(self::suite());
    }
	 
    public static function suite()
    {
		$tests = self::GetTests();
		$tests = array('ResourcesTests.php');
		
		$suite = new PHPUnit_Framework_TestSuite('PHPUnit Framework');

		for ($i = 0; $i < count($tests); $i++) {
       		printf("\nIncluding file... %s\n", $tests[$i]);
			require_once($tests[$i]);
			$name_parts = explode('.', $tests[$i]);	
			$name  = $name_parts[0];
        	$suite->addTestSuite($name );
		}
 
        return $suite;
    }
	
	private function GetTests() {
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

	private function writeln($line) {
		global $verbose;
		if ($verbose) {
			echo $line . "\n";
		}
	}
}
 
if (PHPUnit_MAIN_METHOD == 'AllTests::main') {
    AllTests::main();
}

?>
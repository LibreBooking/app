<?php
$path = ini_get('include_path');
ini_set('include_path', $path . ';' . 'C:\PHP\PEAR');

define('ROOT_DIR', dirname(__FILE__) . '/../');

require_once 'PHPUnit/Autoload.php';
require_once(ROOT_DIR . 'tests/TestBase.php');
require_once(ROOT_DIR . 'tests/Fakes/namespace.php');

require_once(ROOT_DIR . 'tests/PresenterTests/PresenterSuite.php');

class AllTests
{
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite();
 
        $suite->addTest(PresenterSuite::suite());

        return $suite;
    }
}

class TestHelper
{
	public static function GetSuite($relativePath)
	{
		$testDirectory = ROOT_DIR . $relativePath;
    	$tests = TestHelper::GetTests($testDirectory);
        
    	foreach($tests as $test)
    	{
    		require_once("$testDirectory/" . $test->FileName);
    	}
    	
    	$suite = new PHPUnit_Framework_TestSuite();
 
       	$suite->addTestSuite($test->TestName);

        return $suite;
	}
	
	public static function GetTests($directory)
	{
		$tests = array();
		
		if ($dh = opendir($directory)) 
		{
	        while (($file = readdir($dh)) !== false) 
	        {
	        	if (self::endsWith($file, "Tests.php"))
	        	{
	       			 $tests[] = new UnitTest($file);
	        	}
	        }
	        closedir($dh);
	    }
	    
	    return $tests;
	}
	
	
	private static function endsWith($haystack, $needle)
	{
	    $length = strlen($needle);
	    $start =  $length *-1; //negative
	    return (substr($haystack, $start, $length) === $needle);
	}
	
}

class UnitTest
{
	public $FileName;
	public $TestName;
	
	public function __construct($fileName)
	{
		$this->FileName = $fileName;
		
		$pathinfo = pathinfo($fileName);
		$this->TestName = $pathinfo['filename'];
	}
}
?>
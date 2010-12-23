<?php
$path = ini_get('include_path');
ini_set('include_path', $path . ';' . 'C:\PHP\PEAR');

define('ROOT_DIR', dirname(__FILE__) . '/../');

require_once 'PHPUnit/Autoload.php';
require_once(ROOT_DIR . 'tests/TestBase.php');
require_once(ROOT_DIR . 'tests/Fakes/namespace.php');

require_once(ROOT_DIR . 'tests/PresenterTests/PresenterSuite.php');
require_once(ROOT_DIR . 'tests/Infrastructure/Database/DatabaseSuite.php');
require_once(ROOT_DIR . 'tests/Infrastructure/Common/CommonSuite.php');
require_once(ROOT_DIR . 'tests/Application/Authorization/AuthorizationSuite.php');
require_once(ROOT_DIR . 'tests/Application/Schedule/ScheduleSuite.php');

class AllTests
{
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite();
 
        $suite->addTest(PresenterSuite::suite());
        $suite->addTest(DatabaseSuite::suite());
        $suite->addTest(CommonSuite::suite());
        $suite->addTest(AuthorizationSuite::suite());
        $suite->addTest(ScheduleSuite::suite());

        return $suite;
    }
}

class TestHelper
{
	public static function GetSuite($relativePath, $ignoreCallback = array())
	{
		$testDirectory = ROOT_DIR . $relativePath;
    	$tests = TestHelper::GetTests($testDirectory, $ignoreCallback);
        
    	$suite = new PHPUnit_Framework_TestSuite();
 
    	foreach($tests as $test)
    	{
    		$test->AddToSuite($suite, $testDirectory);	
    	}
  
        return $suite;
	}
	
	public static function GetTests($directory, $ignoreCallback)
	{
		$tests = array();
		
		if ($dh = opendir($directory)) 
		{
	        while (($file = readdir($dh)) !== false) 
	        {
	        	if (!self::Ignored($file, $ignoreCallback) && self::endsWith($file, "Tests.php"))
	        	{
	       			 $tests[] = new UnitTest($file);
	        	}
	        }
	        closedir($dh);
	    }
	    
	    return $tests;
	}
	
	private static function Ignored($fileName, $ignoreCallback)
	{
		if (empty($ignoreCallback))
		{
			return false;
		}
		return call_user_func($ignoreCallback, $fileName);
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
	
	public function AddToSuite($suite, $testDirectory)
	{
		require_once("$testDirectory/" . $this->FileName);
		$suite->addTestSuite($this->TestName);
	}
}
?>
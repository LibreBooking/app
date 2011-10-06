<?php
$path = ini_get('include_path');
ini_set('include_path', $path . ';' . 'C:\PHP\PEAR');

if (!defined('ROOT_DIR')) {
    define('ROOT_DIR', dirname(__FILE__) . '/../');
}

require_once 'PHPUnit/Autoload.php';
require_once(ROOT_DIR . 'tests/TestBase.php');
require_once(ROOT_DIR . 'tests/Fakes/namespace.php');

require_once(ROOT_DIR . 'tests/Application/Authorization/Application_Authorization_Suite.php');
require_once(ROOT_DIR . 'tests/Application/Authentication/Application_Authentication_Suite.php');
require_once(ROOT_DIR . 'tests/Application/Reservation/Application_Reservation_Suite.php');
require_once(ROOT_DIR . 'tests/Application/Schedule/Application_Schedule_Suite.php');
require_once(ROOT_DIR . 'tests/Application/Resource/Application_Resource_Suite.php');

require_once(ROOT_DIR . 'tests/Domain/Announcement/Domain_Announcement_Suite.php');
require_once(ROOT_DIR . 'tests/Domain/Reservation/Domain_Reservation_Suite.php');
require_once(ROOT_DIR . 'tests/Domain/Resource/Domain_Resource_Suite.php');
require_once(ROOT_DIR . 'tests/Domain/Schedule/Domain_Schedule_Suite.php');
require_once(ROOT_DIR . 'tests/Domain/User/Domain_User_Suite.php');

require_once(ROOT_DIR . 'tests/Infrastructure/Common/Infrastructure_Common_Suite.php');
require_once(ROOT_DIR . 'tests/Infrastructure/Config/Infrastructure_Config_Suite.php');
require_once(ROOT_DIR . 'tests/Infrastructure/Database/Infrastructure_Database_Suite.php');

require_once(ROOT_DIR . 'tests/Plugins/Authentication/Ldap/Plugins_Auth_Ldap_Suite.php');

require_once(ROOT_DIR . 'tests/Presenters/Presenters_Suite.php');
require_once(ROOT_DIR . 'tests/Presenters/Dashboard/DashboardPresenters_Suite.php');
require_once(ROOT_DIR . 'tests/Presenters/Admin/AdminPresenters_Suite.php');

class AllTests
{
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite();

        //TODO: Dynamically add all suites under the test directory and subdirectories
        $suite->addTest(Application_Authentication_Suite::suite());
        $suite->addTest(Application_Authorization_Suite::suite());
        $suite->addTest(Application_Schedule_Suite::suite());
        $suite->addTest(Application_Reservation_Suite::suite());
        $suite->addTest(Application_Resource_Suite::suite());
        
        $suite->addTest(Domain_Announcement_Suite::suite());
        $suite->addTest(Domain_Reservation_Suite::suite());
        $suite->addTest(Domain_Resource_Suite::suite());
        $suite->addTest(Domain_Schedule_Suite::suite());
        $suite->addTest(Domain_User_Suite::suite());
        
        $suite->addTest(Infrastructure_Common_Suite::suite());
        $suite->addTest(Infrastructure_Config_Suite::suite());
        $suite->addTest(Infrastructure_Database_Suite::suite());
        
        $suite->addTest(Plugins_Auth_Ldap_Suite::suite());
        
        $suite->addTest(Presenters_Suite::suite());
        $suite->addTest(DashboardPresenters_Suite::suite());
        $suite->addTest(AdminPresenters_Suite::suite());

        return $suite;
    }
}

class TestHelper
{
	public static $Debug = false;
	
	/**
	 * @param string $relativePath
	 * @param string[] $ignoreCallback
	 * @return PHPUnit_Framework_TestSuite
	 */
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
	        		if (self::$Debug)
	        		{
	  					echo "Adding $file\n";	       			 	
	        		}
	        	}
	        	else 
	        	{
	        		if (self::$Debug)
	        		{
	  					echo "Ignored $file\n";	       			 	
	        		}
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
		$filePath = "$testDirectory/" . $this->FileName;
		if (TestHelper::$Debug)
		{
			echo "Adding test suite: $this->TestName from path: $filePath\n";
		}
		require_once($filePath);
		$suite->addTestSuite($this->TestName);
	}
}
?>
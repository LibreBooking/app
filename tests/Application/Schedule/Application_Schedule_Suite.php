<?php 
require_once(ROOT_DIR . 'tests/AllTests.php');

class Application_Schedule_Suite
{
	public static function suite()
    {
    	return TestHelper::GetSuite('tests/Application/Schedule', array(__CLASS__, "IsIgnored"));
    }
    
    public static function IsIgnored($fileName)
    {
    	return false;
    }
}
?>
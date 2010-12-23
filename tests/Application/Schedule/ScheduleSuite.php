<?php 
require_once(ROOT_DIR . 'tests/AllTests.php');

class ScheduleSuite
{
	public static function suite()
    {
    	return TestHelper::GetSuite('tests/Application/Schedule', array('ScheduleSuite', "IsIgnored"));
    }
    
    public static function IsIgnored($fileName)
    {
    	return false;
    }
}
?>
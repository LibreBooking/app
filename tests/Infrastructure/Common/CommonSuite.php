<?php 
require_once(ROOT_DIR . 'tests/AllTests.php');

class CommonSuite
{
	public static function suite()
    {
    	return TestHelper::GetSuite('tests/Infrastructure/Common', array('CommonSuite', "IsIgnored"));
    }
    
    public static function IsIgnored($fileName)
    {
    	return false;
    }
}
?>
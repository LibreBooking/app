<?php 
require_once(ROOT_DIR . 'tests/AllTests.php');

class Application_Authorization_Suite
{
	public static function suite()
    {
    	return TestHelper::GetSuite('tests/Application/Authentication', array(__CLASS__, "IsIgnored"));
    }
    
    public static function IsIgnored($fileName)
    {
    	return false;
    }
}
?>
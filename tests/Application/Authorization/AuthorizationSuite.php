<?php 
require_once(ROOT_DIR . 'tests/AllTests.php');

class AuthorizationSuite
{
	public static function suite()
    {
    	return TestHelper::GetSuite('tests/Application/Authorization', array('AuthorizationSuite', "IsIgnored"));
    }
    
    public static function IsIgnored($fileName)
    {
    	return false;
    }
}
?>